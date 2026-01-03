<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationConfig;
use App\Models\NotificationTemplate;
use App\Models\UserNotificationConfig;
use App\Models\User;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = __('common.notifications');
        $user = new User();
        $notificationObj = new Notification();
        $notifications = Notification::with('sender', 'receiver', 'notification_config')->orderBy('created_at')->orderBy('read')->paginate(config('Reading.nodes_per_page'));
        return view('admin.notifications.index', compact('notifications', 'user', 'notificationObj', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = __('common.notifications');
        $notification = new Notification();
        $placeholderData = $notification->defaultPlaceholder();
        return view('admin.notifications.create', compact('placeholderData', 'page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validate($request, 
            [
                'title'                     => 'required',
                'code'                      => 'required',
                'table_model'               => 'required',
            ],
            [
                'title.required'                => 'The title field is required.',
                'code.required'                 => 'The code field is required.',
                'table_model.required'          => 'The table model field is required.',
            ],
        );

        $notificationConfig                         = new NotificationConfig();
            $notificationConfig->code               = $request->code;
        $notificationConfig->title                  = $request->title;
        $notificationConfig->table_model            = $request->table_model;
        $notificationConfig->notification_types     = $request->notification_types ? implode(',', array_keys($request->notification_types)) : '';
        $notificationConfig->placeholders           = $request->placeholders;
        $res = $notificationConfig->save();

        if($res) 
        {
            foreach ($request->content as $key => $value) 
            {
                $notificationTemplates                          = new NotificationTemplate();
                if($key == 1)
                {
                    $notificationTemplates->subject                 = $request->subject;
                    $notificationTemplates->slug                    = \Str::kebab($request->subject);   
                }
                $notificationTemplates->notification_config_id      = $notificationConfig->id;
                $notificationTemplates->notification_type_id        = $key;
                $notificationTemplates->content                     = $value;
                $res = $notificationTemplates->save();
            }
            return redirect()->route('admin.notification.notifications_config')->with('success', __('common.notification_added_successfully'));
        }
        return redirect()->route('admin.notification.notifications_config')->with('error', __('common.something_went_wrong'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = __('common.notifications');
        $templatesObj = new NotificationTemplate();
        $notification_template  = NotificationConfig::findorFail($id);
        $placeholderData = (new Notification())->defaultPlaceholder();
        return view('admin.notifications.edit', compact('notification_template', 'templatesObj', 'placeholderData', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notificationConfig = NotificationConfig::findorFail($id);
        $validation = $this->validate($request, 
            [
                'title'                     => 'required',
                'code'                      => 'required',
                'table_model'               => 'required',
            ],
            [
                'title.required'                => 'The title field is required.',
                'code.required'                 => 'The code field is required.',
                'table_model.required'          => 'The table model field is required.',
            ],
        );

        $notificationConfig->code                   = $request->code;
        $notificationConfig->title                  = $request->title;
        $notificationConfig->table_model            = $request->table_model;
        $notificationConfig->notification_types     = $request->notification_types ? implode(',', array_keys($request->notification_types)) : '';
        $notificationConfig->placeholders           = $request->placeholders;
        $res = $notificationConfig->save();

        if($res) 
        {
            foreach ($request->content as $key => $value) 
            {
                $notificationTemplates  = new NotificationTemplate();
                $templates = $notificationTemplates->get_notification_template($id, $key);
                if($templates)
                {
                    $notificationTemplates  = $templates;
                }
                if($key == 1)
                {
                    $notificationTemplates->subject                 = $request->subject;
                    $notificationTemplates->slug                    = \Str::kebab($request->subject);   
                }

                $notificationTemplates->notification_config_id      = $notificationConfig->id;
                $notificationTemplates->notification_type_id        = $key;
                $notificationTemplates->content                     = $value;
                $res = $notificationTemplates->save();
            }
    
            return redirect()->route('admin.notification.notifications_config')->with('success', __('common.notification_updated_successfully'));
        }

        return redirect()->route('admin.notification.notifications_config')->with('error', __('common.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notifications_config   = NotificationConfig::findorFail($id);
        $res = $notifications_config->delete();

        if($res)
        {
            return redirect()->route('admin.notification.notifications_config')->with('success', __('common.notification_deleted_successfully'));
        }
        return redirect()->route('admin.notification.notifications_config')->with('error', __('common.something_went_wrong'));
    }

    public function notifications_config(Request $request)
    {
        $page_title = __('common.notifications');
        $templates = NotificationConfig::query();

        if($request->filled('title')) {
            $templates->where('title', 'like', "%{$request->input('title')}%");
        }

        if($request->filled('code')) {
            $templates->where('code', '=', $request->input('code'));
        }

        $notifications_config = $templates->orderBy('created_at', 'desc')->paginate(config('Reading.nodes_per_page'));
        return view('admin.notifications.notifications_config', compact('notifications_config', 'page_title'));
    }

    public function edit_template(Request $request, $config_id='')
    {

        if($request->isMethod('post'))
        {
            foreach ($request->content as $key => $value) 
            {
                $notificationTemplates  = new NotificationTemplate();
                $templates = $notificationTemplates->get_notification_template($config_id, $key);
                if($templates)
                {
                    $notificationTemplates  = $templates;
                }
                if($key == 1)
                {
                    $notificationTemplates->subject                 = $request->subject;
                }

                $notificationTemplates->notification_config_id      = $config_id;
                $notificationTemplates->notification_type_id        = $key;
                $notificationTemplates->content                     = $value;
                $res = $notificationTemplates->save();
            }

            if($res)
            {
                return redirect()->route('admin.notification.notifications_config')->with('success', __('common.notification_template_updated_successfully'));
            }
            return redirect()->route('admin.notification.notifications_config')->with('error', __('common.something_went_wrong'));
        }
        else 
        {
            $page_title = __('common.notifications');
            $templatesObj = new NotificationTemplate();
            $notification_config = NotificationConfig::select('placeholders')->findorFail($config_id);
            $all_templates = NotificationTemplate::where('notification_config_id', '=', $config_id)->get();
            return view('admin.notifications.edit_template', compact('notification_config', 'all_templates', 'config_id', 'templatesObj', 'page_title'));
        }
    }

    public function edit_email_template(Request $request, $config_id='')
    {
        if($request->isMethod('post'))
        {
            foreach ($request->content as $key => $value) 
            {
                $notificationTemplates  = new NotificationTemplate();
                $templates = $notificationTemplates->get_notification_template($config_id, $key);
                if($templates)
                {
                    $notificationTemplates  = $templates;
                }
                if($key == 1)
                {
                    $notificationTemplates->subject                 = $request->subject;
                }

                $notificationTemplates->notification_config_id      = $config_id;
                $notificationTemplates->notification_type_id        = $key;
                $notificationTemplates->content                     = $value;
                $res = $notificationTemplates->save();
            }

            if($res)
            {
                return redirect()->route('admin.notification.notifications_config')->with('success', __('common.email_notification_updated_successfully'));
            }
            return redirect()->route('admin.notification.notifications_config')->with('error', __('common.something_went_wrong'));
        }
        else 
        {
            $page_title = __('common.notifications');
            $templatesObj = new NotificationTemplate();
            $notification_config = NotificationConfig::select('placeholders')->findorFail($config_id);
            $email_template = NotificationTemplate::where('notification_config_id', '=', $config_id)
                                ->where('notification_type_id', '=', 1)
                                ->get();
            return view('admin.notifications.edit_email_template', compact('notification_config', 'email_template', 'config_id', 'templatesObj', 'page_title'));
        }
    }

    public function edit_web_template(Request $request, $config_id='')
    {
        if($request->isMethod('post'))
        {
            foreach ($request->content as $key => $value) 
            {
                $notificationTemplates  = new NotificationTemplate();
                $templates = $notificationTemplates->get_notification_template($config_id, $key);
                if($templates)
                {
                    $notificationTemplates  = $templates;
                }

                $notificationTemplates->notification_config_id      = $config_id;
                $notificationTemplates->notification_type_id        = $key;
                $notificationTemplates->content                     = $value;
                $res = $notificationTemplates->save();
            }

            if($res)
            {
                return redirect()->route('admin.notification.notifications_config')->with('success', __('common.web_notification_updated_successfully'));
            }
            return redirect()->route('admin.notification.notifications_config')->with('error', __('common.something_went_wrong'));
        }
        else 
        {
            $page_title = __('common.notifications');
            $templatesObj = new NotificationTemplate();
            $notification_config = NotificationConfig::select('placeholders')->findorFail($config_id);
            $web_template = NotificationTemplate::where('notification_config_id', '=', $config_id)
                                ->where('notification_type_id', '=', 2)
                                ->get();
            return view('admin.notifications.edit_web_template', compact('notification_config', 'web_template', 'config_id', 'templatesObj', 'page_title'));
        }
    }

    public function edit_sms_template(Request $request, $config_id='')
    {
        if($request->isMethod('post'))
        {
            foreach ($request->content as $key => $value) 
            {
                $notificationTemplates  = new NotificationTemplate();
                $templates = $notificationTemplates->get_notification_template($config_id, $key);
                if($templates)
                {
                    $notificationTemplates  = $templates;
                }

                $notificationTemplates->notification_config_id      = $config_id;
                $notificationTemplates->notification_type_id        = $key;
                $notificationTemplates->content                     = $value;
                $res = $notificationTemplates->save();
            }

            if($res)
            {
                return redirect()->route('admin.notification.notifications_config')->with('success', __('common.sms_notification_updated_successfully'));
            }
            return redirect()->route('admin.notification.notifications_config')->with('error', __('common.something_went_wrong'));
        }
        else 
        {
            $page_title = __('common.notifications');
            $templatesObj = new NotificationTemplate();
            $notification_config = NotificationConfig::select('placeholders')->findorFail($config_id);
            $sms_template = NotificationTemplate::where('notification_config_id', '=', $config_id)
                                ->where('notification_type_id', '=', 2)
                                ->get();
            return view('admin.notifications.edit_sms_template', compact('notification_config', 'sms_template', 'config_id', 'templatesObj', 'page_title'));
        }
    }

    public function settings(Request $request)
    {

        if($request->isMethod('post')) 
        {
            if(!empty($request->input('notification_types')))
            {
                foreach($request->input('notification_types') as $notification_id => $notification)
                {

                    if(isset($notification['all']))
                    {
                        unset($notification['all']);
                        $notificationConfig = NotificationConfig::find($notification_id);
                        $notificationConfig->notification_types = $request->notification_types ? implode(',', array_keys($notification)) : '';
                        $notificationConfig->status = 1;
                        $notificationConfig->save();
                    }
                    else
                    {
                        NotificationConfig::where('status', '=', 1)->update(['status' => 0]);
                    }
                }
                return redirect()->back()->with('success', __('common.notification_settings_updated_successfully'));
            }
            else
            {
                NotificationConfig::where('status', '=', 1)->update(['status' => 0]);
            }
        }

        $page_title = __('common.notifications');
        $notifications = NotificationConfig::get();
        return view('admin.notifications.settings', compact('notifications', 'page_title'));
    }
}
