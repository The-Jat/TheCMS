<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Ticket;
use Auth;
use Mail;

class Notification extends Model
{
	use HasFactory;

	protected $table = 'notifications';
	protected $fillable = [
		'notification_config_id',
		'notification_types',
		'object_id',
		'sender_id',
		'receiver_id',
		'read',
	];

	public function notification_config()
	{
		return $this->belongsTo(NotificationConfig::class, 'notification_config_id', 'id');
	}

	public function sender()
	{
		return $this->belongsTo(User::class, 'sender_id', 'id');
	}

	public function receiver()
	{
		return $this->belongsTo(User::class, 'reciever_id', 'id');
	}

	public function blog()
	{
		return $this->belongsTo(Blog::class, 'object_id', 'id');
	}

	public function page()
	{
		return $this->belongsTo(Page::class, 'object_id', 'id');
	}

	public function notification_entry($code='', $table_id='', $sender_id='', $receiver_id='')
	{
		$notificationConfig = NotificationConfig::select('id', 'notification_types')->with('notification_templates')->where('code', '=', $code)->where('status', '=', 1)->first();
		if(!empty($notificationConfig))
		{
			$web_notification = array(
							'notification_config_id'    => $notificationConfig->id,
							'notification_types'        => $notificationConfig->notification_types,
							'object_id'                 => $table_id,
							'sender_id'                 => $sender_id,
							'receiver_id'               => $receiver_id,
							);
			$web_notification = Notification::create($web_notification);
			
			$notification_id = $web_notification->id;
			if(\Str::contains($notificationConfig->notification_types, '1'))
			{
				$this->email_notification($notificationConfig->id, 1, $notification_id);
			}
		}
	}

	public function email_notification($notification_config_id='', $notification_type_id='', $notification_id='')
	{
		$email_template     = NotificationTemplate::with('notification_config')->where('notification_config_id', '=', $notification_config_id)
								->where('notification_type_id', '=', $notification_type_id)->first();
		$tableModel         = optional($email_template->notification_config)->table_model;
		
		$notification       = Notification::firstWhere('id', $notification_id);
		$user               = User::find($notification->receiver_id);
		$currentUser		= auth()->user();

		$placeholder_arr = array();
		$assign_users_emails = array();

		if($tableModel == 'Ticket')
		{
			$placeholderData = $this->ticket_notification_settings($tableModel, $user);
			$ticketObj                  = new Ticket();
			$assign_users_emails        = $ticketObj->assign_users(optional($ticket)->id, 'email');
			$assign_users_emails        = array_unique($assign_users_emails);
		}
		elseif($tableModel == 'ACL')
		{
			$placeholderData = $this->acl_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'User')
		{
			$placeholderData = $this->user_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Role')
		{
			$placeholderData = $this->role_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Comment')
		{
			$placeholderData = $this->comment_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Configuration')
		{
			$placeholderData = $this->configuration_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Blog')
		{
			$placeholderData = $this->blog_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BlogCategory')
		{
			$placeholderData = $this->blog_category_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BlogTag')
		{
			$placeholderData = $this->blog_tag_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Page')
		{
			$placeholderData = $this->page_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Contact')
		{
			$placeholderData = $this->contact_notification_settings($notification, $currentUser);
		}

		$to_email                   = $user->email;
		$to_name                    = $user->full_name;
		$from_email                 = optional($currentUser)->email;
		$from_name                  = optional($currentUser)->full_name;
		$placeholder_arr            = $this->getPlaceholders('', $tableModel, $placeholderData);
		$subject                    = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $email_template->subject);
		$message                    = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $email_template->content);
		$view_data['description']   = $message;
		

		if (env('MAIL_USERNAME') && env('MAIL_PASSWORD') && env('MAIL_HOST')) {
			Mail::send('emails.notification_email', $view_data, function($mail) use($to_email, $to_name, $assign_users_emails, $subject, $from_email, $from_name) {
				$mail->getHeaders()->addTextHeader(
					'MIME-Version', '1.0',
					'Content-type', 'text/html;charset=UTF-8',
				);
				if ($from_email && $from_name) {
					$mail->from($from_email, $from_name);
				}
				$mail->to($to_email, $to_name)->cc($assign_users_emails)->subject($subject);
			});
		}
	}
	
	private function ticket_notification_settings($notificationObj, $userObj) {
		
		$ticket             = Ticket::with('ticket_attachments', 'category')->where('id', '=', $notificationObj->object_id)->first();
		$ticket_attachments = optional($ticket)->ticket_attachments;
		$ticket_category    = optional($ticket)->category;
		$ticketAttachments  = '';
		if(!empty($ticket_attachments))
		{
			foreach($ticket_attachments as $attachment)
			{
				$ticketAttachments .= '<a href="'.asset('/storage/ticket-images/'.$attachment->attachment).'">'.$attachment->attachment.'</a><br>';
			}
		}
		$ticket_id = optional($ticket)->id;
		$parentTicketId = optional($ticket)->id;
		if(optional($ticket)->parent_id)
		{
			$parentTicketId = optional($ticket)->parent_id;
		}
		$placeholderData    =   ['Support' =>
									[
										'sender_id' => $notificationObj->sender_id,
										'receiver_id' => $notificationObj->receiver_id,
										'ticket_attachment' => $ticketAttachments,
										'ticket_id' => $ticket_id,
										'category_name' => optional($ticket_category)->name,
										'ticket_comment' => optional($ticket)->description,
										'ticket_link' => $parentTicketId ? route('ticket.customer_ticket_detail', $parentTicketId) : '#',
									]
								];
		
		return $placeholderData;
	}

	private function acl_notification_settings($notificationObj, $userObj)
	{
	}

	private function user_notification_settings($notificationObj, $userObj)
	{
		$user = User::where('id', '=', $notificationObj->object_id)->first();
		$roles = $user ? $user->getRoleNames()->implode(',') : '';
		$profile = !empty($user->profile) ? asset('storage/user-images/'.$user->profile) : config('constants.user_default_img');
		$placeholderData    =   ['User' =>
									[
										'username' => optional($userObj)->full_name,
										'name' => optional($user)->full_name,
										'email' => optional($user)->email,
										'firstname' => optional($user)->first_name,
										'lastname' => optional($user)->last_name,
										'password' => optional($user)->password,
										'role' => $roles,
										'profile' => '<img src="'.$profile.'" width="100px" height="100px" alt="'.optional($user)->full_name.'">',
									]
								];
		
		return $placeholderData;
	}

	private function contact_notification_settings($notificationObj, $userObj)
	{
		$contact = Contact::where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Contact' =>
									[
										'first_name' => optional($contact)->first_name,
										'last_name' => optional($contact)->last_name,
										'email' => optional($contact)->email,
										'phone_number' => optional($contact)->phone_number,
										'message' => optional($contact)->message,
									]
								];
		
		return $placeholderData;
	}

	private function role_notification_settings($notificationObj, $userObj)
	{
		$role = Role::select('name')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Role' =>
									[
										'username' => optional($userObj)->full_name,
										'name' => optional($role)->name,
									]
								];
		
		return $placeholderData;
	}

	private function comment_notification_settings($notificationObj, $userObj)
	{
		$comment = Comment::select('comment','object_id','commenter')->where('id', '=', $notificationObj->object_id)->where('object_type', '=', 1)->with('blog')->first();
		
		$placeholderData    =   ['Comment' =>
									[
										'username' => optional($comment)->commenter,
										'comment' => optional($comment)->comment,
										'title' => optional(@$comment->blog)->title,
									]
								];
		
		return $placeholderData;
	}

	private function configuration_notification_settings($notificationObj, $userObj)
	{
		$config = Configuration::select('title', 'name')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Configuration' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blog)->title,
										'content' => optional($blog)->content,
									]
								];
		
		return $placeholderData;
	}

	private function blog_notification_settings($notificationObj, $userObj)
	{
		$blog = Blog::select('title', 'content')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Blog' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blog)->title,
										'content' => optional($blog)->content,
									]
								];
		
		return $placeholderData;
	}

	private function blog_category_notification_settings($notificationObj, $userObj)
	{
		$blogCategory = BlogCategory::select('title', 'description')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['BlogCategory' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blogCategory)->title,
										'content' => optional($blogCategory)->description,
									]
								];
		
		return $placeholderData;
	}

	private function blog_tag_notification_settings($notificationObj, $userObj)
	{
		$blogTag = BlogTag::select('title')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['BlogTag' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blogTag)->title,
									]
								];
		
		return $placeholderData;
	}

	private function page_notification_settings($notificationObj, $userObj)
	{
		$page = Page::select('title', 'content')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Page' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($page)->title,
										'content' => optional($page)->content,
									]
								];
		
		return $placeholderData;
	}
	
	public function sms_notification()
	{
	}

	public function show_notification($user_id, $code=array())
	{
		$notification_configs       = NotificationConfig::whereIn('code', $code)->pluck('code', 'id')->toArray();
		$notification_config_ids    = array_keys($notification_configs);
		$notification_templates     = NotificationTemplate::whereIn('notification_config_id', $notification_config_ids)->where('notification_type_id', '=', 2)->pluck('content', 'notification_config_id');
		$userObj                    = new User();
		$ticket_ids                 = $userObj->assign_tickets($user_id);
		$notifications              = Notification::whereIn('notification_config_id', $notification_config_ids)
							->whereIn('object_id', $ticket_ids)
									->where('read', '=', '0')
									->orderBy('created_at', 'desc')
									->take(15)
									->get();
		$NotificationsArr = array();
		if(!$notifications->isEmpty())
		{
			foreach ($notifications as $key => $notification) {
								$sender_user        = $this->get_user($notification->sender_id);
								$receiver_user      = $this->get_user($notification->receiver_id);
				$placeholderData    =   array('Support' =>
											array(
												'sender_id' => $this->display_you($notification->sender_id, $sender_user->full_name),
												'receiver_id' => $this->display_you($notification->receiver_id, $receiver_user->full_name, true),
												'ticket_id' => $notification->object_id,
											)
										);
				$placeholder_arr    = $this->getPlaceholders('', 'Support', $placeholderData);
				
				$content            = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $notification_templates[$notification->notification_config_id]);
				$NotificationsArr[] = array(
										'sender_name'   => $this->display_you($notification->sender_id, $sender_user->full_name),
										'receiver_name' => $this->display_you($notification->receiver_id, $receiver_user->full_name, true),
										'sender_img'    => $sender_user->image,
										'updated_at'    => \Carbon\Carbon::parse($notification->updated_at)->diffForHumans(),
										'message'       => $content,
										'comment'       => $this->get_ticket_comment($notification->object_id),
										'object_id'     => $notification->object_id,
																'code'          => $notification_configs[$notification->notification_config_id],
																'read'          => $notification->read
									);
			}
		}
		return $NotificationsArr;
	}

	public function get_user($id='', $type='')
	{
		$user = User::firstWhere('id', $id);
		if($user && $type == 'name')
		{
			return $user->full_name;
		}
		else if($user && $type == 'email')
		{
			return $user->email;
		}
		else if($user && $type == 'image')
		{
			return $user->image;
		}
		else
		{
			return $user;
		}
	}
	public function getPlaceholders($user_id = NULL, $model='', $data = array())
	{
		$config = config('constants.Placeholder');
		$result = array();
		if($model == 'User')
		{
			$result[$config['User']['username']['placeholder']] = (!empty($data['User']['username'])) ? $data['User']['username'] : '';
			$result[$config['User']['name']['placeholder']] = (!empty($data['User']['name'])) ? $data['User']['name'] : '';
			$result[$config['User']['email']['placeholder']] = (!empty($data['User']['email'])) ? $data['User']['email'] : '';
			$result[$config['User']['firstname']['placeholder']] = (!empty($data['User']['firstname'])) ? $data['User']['firstname'] : '';
			$result[$config['User']['lastname']['placeholder']] = (!empty($data['User']['lastname'])) ? $data['User']['lastname'] : '';
			$result[$config['User']['password']['placeholder']] = (!empty($data['User']['password'])) ? $data['User']['password'] : '';
			$result[$config['User']['role']['placeholder']] = (!empty($data['User']['role'])) ? $data['User']['role'] : '';
			$result[$config['User']['profile']['placeholder']] = (!empty($data['User']['profile'])) ? $data['User']['profile'] : '';
		}

		foreach($config['Config'] as $key => $value)
		{
		
			$result[$value['placeholder']] = config($key);
		}
		
		$result[$config['Generate']['site_logo']['placeholder']] = '<img  src="'.asset('storage/configuration-images/'.config('Site.logo')).'" />';
		$result[$config['Generate']['login_link']['placeholder']] = '<a href="'.route("login").'">Account login link</a>';
		$result[$config['Generate']['register_link']['placeholder']] = '<a href="javascript:void(0);">Account Registration link</a>';
		
		if($model == 'Contact')
		{
			$result[$config['Contact']['first_name']['placeholder']] = (!empty($data['Contact']['first_name'])) ? $data['Contact']['first_name'] : '';
			$result[$config['Contact']['last_name']['placeholder']] = (!empty($data['Contact']['last_name']))?$data['Contact']['last_name'] : '';
			$result[$config['Contact']['email']['placeholder']] = (!empty($data['Contact']['email']))?$data['Contact']['email'] : '';
			$result[$config['Contact']['phone_number']['placeholder']] = (!empty($data['Contact']['phone_number']))?$data['Contact']['phone_number'] : '';
			$result[$config['Contact']['message']['placeholder']] = (!empty($data['Contact']['message']))?$data['Contact']['message'] : '';
		}
		
		if($model == 'Subscribe')
		{
			$result[$config['Subscribe']['name']['placeholder']] = (!empty($data['Subscribe']['name'])) ? $data['Subscribe']['name'] : '';
		}
		
		if($model == 'Support' && !empty($config['Support']))
		{
			$sender_name            = is_int($data['Support']['sender_id']) ? $this->get_user($data['Support']['sender_id'], 'name') : $data['Support']['sender_id'];
			$receiver_name          = is_int($data['Support']['receiver_id']) ? $this->get_user($data['Support']['receiver_id'], 'name') : $data['Support']['receiver_id'];
			$result[$config['Support']['sender_name']['placeholder']] = $sender_name;
			$result[$config['Support']['receiver_name']['placeholder']] = $receiver_name;
			$result[$config['Support']['object_title']['placeholder']] = (!empty($data['Support']['object_title'])) ? $data['Support']['object_title'] : '';
			$result[$config['Support']['category_name']['placeholder']] = (!empty($data['Support']['category_name'])) ? $data['Support']['category_name'] : '';
			$result[$config['Support']['ticket_id']['placeholder']] = (!empty($data['Support']['ticket_id'])) ? $data['Support']['ticket_id'] : '';
			$result[$config['Support']['ticket_attachment']['placeholder']] = (!empty($data['Support']['ticket_attachment'])) ? $data['Support']['ticket_attachment'] : '';
			$result[$config['Support']['ticket_comment']['placeholder']] = (!empty($data['Support']['ticket_comment'])) ? $data['Support']['ticket_comment'] : '';
			$result[$config['Support']['ticket_link']['placeholder']] = (!empty($data['Support']['ticket_link'])) ? $data['Support']['ticket_link'] : '';
		}
		
		if($model == 'Blog' && !empty($config['Blog']))
		{
			$result[$config['Blog']['username']['placeholder']] = (!empty($data['Blog']['username'])) ? $data['Blog']['username'] : '';
			$result[$config['Blog']['title']['placeholder']] = (!empty($data['Blog']['title'])) ? $data['Blog']['title'] : '';
			$result[$config['Blog']['content']['placeholder']] = (!empty($data['Blog']['content'])) ? $data['Blog']['content'] : '';
			$result[$config['Blog']['taxonomy_title']['placeholder']] = (!empty($data['Blog']['title'])) ? $data['Blog']['title'] : '';
			$result[$config['Blog']['taxonomy_content']['placeholder']] = (!empty($data['Blog']['content'])) ? $data['Blog']['content'] : '';
			$result[$config['Blog']['post_type_title']['placeholder']] = (!empty($data['Blog']['title'])) ? $data['Blog']['title'] : '';
			$result[$config['Blog']['post_type_content']['placeholder']] = (!empty($data['Blog']['content'])) ? $data['Blog']['content'] : '';
		}
		
		if($model == 'BlogCategory' && !empty($config['BlogCategory']))
		{
			$result[$config['BlogCategory']['username']['placeholder']] = (!empty($data['BlogCategory']['username'])) ? $data['BlogCategory']['username'] : '';
			$result[$config['BlogCategory']['title']['placeholder']] = (!empty($data['BlogCategory']['title'])) ? $data['BlogCategory']['title'] : '';
			$result[$config['BlogCategory']['content']['placeholder']] = (!empty($data['BlogCategory']['content'])) ? $data['BlogCategory']['content'] : '';
		}
		
		if($model == 'BlogTag' && !empty($config['BlogTag']))
		{
			$result[$config['BlogTag']['username']['placeholder']] = (!empty($data['BlogTag']['username'])) ? $data['BlogTag']['username'] : '';
			$result[$config['BlogTag']['title']['placeholder']] = (!empty($data['BlogTag']['title'])) ? $data['BlogTag']['title'] : '';
		}
		
		if($model == 'Comment' && !empty($config['Comment']))
		{
			$result[$config['Comment']['username']['placeholder']] = (!empty($data['Comment']['username'])) ? $data['Comment']['username'] : '';
			$result[$config['Comment']['comment']['placeholder']] = (!empty($data['Comment']['comment'])) ? $data['Comment']['comment'] : '';
			$result[$config['Comment']['title']['placeholder']] = (!empty($data['Comment']['title'])) ? $data['Comment']['title'] : '';
		}
		
		if($model == 'Page' && !empty($config['Page']))
		{
			$result[$config['Page']['username']['placeholder']] = (!empty($data['Page']['username'])) ? $data['Page']['username'] : '';
			$result[$config['Page']['title']['placeholder']] = (!empty($data['Page']['title'])) ? $data['Page']['title'] : '';
			$result[$config['Page']['content']['placeholder']] = (!empty($data['Page']['content'])) ? $data['Page']['content'] : '';
		}
		
		if($model == 'Role' && !empty($config['Role']))
		{
			$result[$config['Role']['username']['placeholder']] = (!empty($data['Role']['username'])) ? $data['Role']['username'] : '';
			$result[$config['Role']['name']['placeholder']] = (!empty($data['Role']['name'])) ? $data['Role']['name'] : '';
		}

		return $result;
		
	}

	public function notification_delete($code='', $object_id='')
	{
		$notification_config = NotificationConfig::where('code', '=', $code)->first();
		if(!empty($notification_config))
		{
			return Notification::where('notification_config_id', '=', $notification_config->id)
							->where('object_id', '=', $object_id)
							->delete();
		}
	}

	public function get_ticket_comment($ticket_id='')
	{
		$ticket = Ticket::select('id', 'description')->firstWhere('id', $ticket_id);
		return !empty($ticket->description) ? $ticket->description : '';
	}

	public function display_you($user_id, $name, $noun_type=false)
	{
		if(Auth::id() == $user_id)
		{
			if($noun_type)
			{
				return 'Your';
			}
			return 'You';
		}
		return $name;
	}

	public function get_message($table_model, $notification_config_id, $sender_id, $receiver_id, $object_id)
	{
		$notification_templates    = NotificationTemplate::where(['notification_config_id' => $notification_config_id, 'notification_type_id' => 1])->pluck('content', 'notification_config_id');
		$placeholderData    =   array($table_model =>
											array(
														'sender_id'     => $sender_id,
														'receiver_id'   => $receiver_id,
														'ticket_id'     => $object_id,
											)
										);
		$placeholder_arr    = $this->getPlaceholders('', $table_model, $placeholderData);
		
		$content            = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $notification_templates[$notification_config_id]);
		return $content;
	}

	public function defaultPlaceholder()
	{
		$configArray = config('constants.Placeholder');
		$placeholderData = '';
		
		foreach($configArray as $key => $configValue)
		{
			$placeholderData .= '<b>'.$key.' Configuration </b> <br>';
			foreach($configValue as $value)
			{
				$placeholderData .= $value['placeholder'];
				$placeholderData .= ': '.$value['guideline'];
				$placeholderData .= '<br>';
			}
		}

		return $placeholderData;

	}
}
