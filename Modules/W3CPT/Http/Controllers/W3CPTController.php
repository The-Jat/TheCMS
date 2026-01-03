<?php

namespace Modules\W3CPT\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\W3CPT\Entities\Blog;
use Modules\W3CPT\Entities\BlogMeta;
use App\Models\MenuItem;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Notification;
use Auth;

class W3CPTController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $resultQuery = Blog::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }

            if($request->filled('from') && $request->filled('to')) {
                $resultQuery->whereBetween('created_at', [$request->input('from'), $request->input('to')]);
            }
        }

        $page_title = __('w3cpt::common.w3cpt');
        $allCpts = $resultQuery->with('blog_meta')->where('post_type', '=', config('w3cpt.post_type'))->where('status', '=', 1)->paginate(config('Reading.nodes_per_page'));
        return view('w3cpt::admin.w3cpt.index', compact('allCpts', 'page_title'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index_taxo(Request $request)
    {
        $resultQuery = Blog::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }

            if($request->filled('from') && $request->filled('to')) {
                $resultQuery->whereBetween('created_at', [$request->input('from'), $request->input('to')]);
            }
        }
        
        $page_title = __('w3cpt::common.taxonomies');
        $allTxonomies = $resultQuery->with('blog_meta')->where('post_type', '=', config('w3cpt.post_type_taxo'))->where('status', '=', 1)->paginate(config('Reading.nodes_per_page'));
        return view('w3cpt::admin.w3cpt_taxo.index', compact('allTxonomies', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function save(Request $request, $id=Null)
    { 
        if($request->isMethod('post'))
        {

            $request['slug'] = \Str::slug($request->title, '-');
            
            $validation['title'] = 'required';
            $validationMsg['title'] = __('Title is required.');

            if ($id) {
                $validation['slug'] = 'required|unique:blogs,slug,'.$id;
            }else{
                $validation['slug'] = 'required|unique:blogs,slug';
            }
        
            $validationMsg['slug'] = __('The CPT has already been taken.');
            $this->validate($request, $validation, $validationMsg);

            $cpt = Blog::updateOrCreate(
                    [
                        'id' => $id,
                    ],
                    [
                        'user_id' => Auth::id(), 
                        'title' => $request->title, 
                        'slug' => $request['slug'],
                        'post_type' => config('w3cpt.post_type'), 
                        'publish_on' => date('Y-m-d H:i:s'), 
                        'status' => 1
                    ]
                );

            if($cpt)
            {
                BlogMeta::where('blog_id', '=', $cpt->id)->delete();
                $blogMetas = array();
                foreach ($request->BlogMeta as $key => $value) {

                    if(is_array($value))
                    {
                        $value = serialize($value);
                    }
                    $blogMetas[] = array('blog_id' => $cpt->id, 'title' => $key, 'value' => $value);

                }
                BlogMeta::insert($blogMetas);

                /* Send Event Notification */
                $notificationObj        = new Notification();
                if($id)
                {
                    $notificationObj->notification_entry('CPT-UPT', $cpt->id, Auth::id(), config('constants.superadmin'));
                }
                else
                {
                    $notificationObj->notification_entry('CPT-CNPT', $cpt->id, Auth::id(), config('constants.superadmin'));
                }
                /* End Send Event Notification */

                return redirect()->route('cpt.admin.index')->with('success', __('w3cpt::common.post_type_created_successfully'));
            }
            return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'))->withInput();

        }

        $blog       = $id ? Blog::where('post_type', '=', config('w3cpt.post_type'))->find($id) : New Blog;
        $blogMeta   = $blog->getBlogMeta($id);
        $cpt_supports = isset($blogMeta['cpt_supports']) ? unserialize($blogMeta['cpt_supports']) : array('Title', 'Editor', 'Excerpt');
        $cpt_builtin_taxonomies = isset($blogMeta['cpt_builtin_taxonomies']) ? unserialize($blogMeta['cpt_builtin_taxonomies']) : array();
        $screenOption = config('w3cpt.ScreenOption');
        $page_title = __('w3cpt::common.w3cpt');
        
        return view('w3cpt::admin.w3cpt.create', compact('blog', 'blogMeta', 'cpt_supports', 'cpt_builtin_taxonomies', 'screenOption', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function save_taxo(Request $request, $id=Null)
    {
        if($request->isMethod('post'))
        {

            $validation = [
                'title'     => 'required',
            ];

            $validationMsg = [
            ];

            $request['slug'] = \Str::slug($request->title, '-');
            $this->validate($request, $validation, $validationMsg);

            $cpt = Blog::updateOrCreate(
                    [
                        'id' => $id,
                    ],
                    [
                        'user_id' => Auth::id(), 
                        'title' => $request->title, 
                        'slug' => $request['slug'],
                        'post_type' => config('w3cpt.post_type_taxo'), 
                        'publish_on' => date('Y-m-d H:i:s'), 
                        'status' => 1
                    ]
                );

            if($cpt)
            {
                foreach ($request->BlogMeta as $key => $value) {

                    if(is_array($value))
                    {
                        $value = serialize($value);
                    }

                    BlogMeta::updateOrCreate(
                        ['blog_id' => $cpt->id, 'title' => $key],
                        ['blog_id' => $cpt->id, 'title' => $key, 'value' => $value]
                    );
                }

                /* Send Event Notification */
                $notificationObj        = new Notification();
                if($id)
                {
                    $notificationObj->notification_entry('CPT-UT', $cpt->id, Auth::id(), config('constants.superadmin'));
                }
                else
                {
                    $notificationObj->notification_entry('CPT-CNT', $cpt->id, Auth::id(), config('constants.superadmin'));
                }
                /* End Send Event Notification */

                return redirect()->route('cpt_taxo.admin.index')->with('success', __('w3cpt::common.taxonomy_created_successfully'));
            }
            return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'))->withInput();

        }

        $blog       = $id ? Blog::where('post_type', '=', config('w3cpt.post_type_taxo'))->find($id) : New Blog;
        $blogMeta   = $blog->getBlogMeta($id);
        $cpt_tax_post_types = isset($blogMeta['cpt_tax_post_types']) ? unserialize($blogMeta['cpt_tax_post_types']) : array('title', 'editor', 'excerpt');
        $blogs      = $blog->getAllCpt();
        $page_title = __('w3cpt::common.taxonomies');

        return view('w3cpt::admin.w3cpt_taxo.create', compact('blog', 'blogMeta', 'cpt_tax_post_types', 'blogs', 'page_title'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $blog   = Blog::findOrFail($id);
        $blogMeta = $blog->getBlogMeta($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('CPT-DPT', $blog->id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */

        $res    = $blog->delete();

        if($res)
        {
            Blog::where(['post_type' => $blogMeta['cpt_name']])->delete();

            return redirect()->back()->with('success', $blog->title.' '.__('w3cpt::common.deleted_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy_taxo($id)
    {
        $blog   = Blog::findOrFail($id);
        $blogMeta = $blog->getBlogMeta($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('CPT-DT', $blog->id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */
            
        $res    = $blog->delete();

        if($res)
        {

            return redirect()->back()->with('success', $blog->title.' '.__('w3cpt::common.deleted_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    public function trash_cpt($id)
    {
        $blog           = Blog::findOrFail($id);
        $blog->status   = 3;
        $res            = $blog->save();

        if($res)
        {
            $blogMeta = $blog->getBlogMeta($id);
            MenuItem::where(['type' => $blogMeta['cpt_name']])->delete();

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('CPT-TPT', $blog->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->back()->with('success', $blog->title.' '.__('w3cpt::common.trashed_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    public function trash_taxo($id)
    {
        $blog           = Blog::findOrFail($id);
        $blog->status   = 3;
        $res            = $blog->save();

        if($res)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('CPT-TT', $blog->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */
            
            $blogMeta = $blog->getBlogMeta($id);
            MenuItem::where(['type' => $blogMeta['cpt_tax_name']])->delete();
            return redirect()->back()->with('success', $blog->title.' '.__('w3cpt::common.trashed_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    public function trash_taxo_list(Request $request)
    {
        $resultQuery = Blog::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }

            if($request->filled('from') && $request->filled('to')) {
                $resultQuery->whereBetween('created_at', [$request->input('from'), $request->input('to')]);
            }
        }
        
        $page_title = __('w3cpt::common.taxonomies');
        $allTxonomies = $resultQuery->with('blog_meta')->where('post_type', '=', config('w3cpt.post_type_taxo'))->where('status', '=', 3)->paginate(config('Reading.nodes_per_page'));
        return view('w3cpt::admin.w3cpt_taxo.trash_taxo_list', compact('allTxonomies', 'page_title'));
    }

    public function resotre_cpt_taxo($id)
    {
        $blog           = Blog::findOrFail($id);
        $blog->status   = 1;
        $res            = $blog->save();

        if($res)
        {
            return redirect()->back()->with('success', $blog->title.' '.__('w3cpt::common.restored_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    public function trash_list(Request $request)
    {
        $page_title = __('Trashed W3Cpts');
        $resultQuery = Blog::query();

        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }

            if($request->filled('from') && $request->filled('to')) {
                $resultQuery->whereBetween('created_at', [$request->input('from'), $request->input('to')]);
            }
        }

        $resultQuery->where('post_type', '=', config('w3cpt.post_type'));
        $resultQuery->where('status', '=', 3);

        $allCpts = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('w3cpt::admin.w3cpt.trash_list', compact('allCpts', 'page_title'));
    }

}
