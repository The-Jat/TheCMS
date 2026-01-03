<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageMeta;
use App\Models\PageSeo;
use App\Models\User;
use App\Models\Notification;
use App\Rules\EditorEmptyCheckRule;
use Modules\CustomField\Entities\CustomField;
use Storage;
use Auth;
use DB;


class PagesController extends Controller
{
	public function index($page_slug) {
		$page_title = __('common.pages');
		$page = Page::with('page_metas', 'page_seo')->firstWhere('slug', $page_slug);
		return view('front.pages.index', compact('page','page_title'));
	}

	/**
	 * Display a listing of the resource.
	 * @return Renderable
	 * 
	 */
	public function admin_index(Request $request)
	{

		$page_title = __('common.all_pages');
		$pages_query = Page::query();

		if($request->isMethod('get') && $request->input('todo') == 'Filter')
		{
			if($request->filled('title')) {
				$pages_query->where('title', 'like', "%{$request->input('title')}%");
			}

			if($request->filled('status')) {
				$pages_query->where('status', '=', $request->input('status'));
			}

			if($request->filled('from') && $request->filled('to')) {
				$pages_query->whereBetween('created_at', [$request->input('from'), $request->input('to')]);
			}
		}
		$pages_query->with('user');
        $pages_query->where('status', '!=', 3);

        $sortWith = $request->get('with') ? $request->get('with') : Null;
		$sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        
        $pages_query->orderBy('pages.'.$sortBy, $direction);


		$pages = $pages_query->paginate(config('Reading.nodes_per_page'));
		$status = config('page.status');
		return view('admin.pages.index', compact('pages','page_title', 'status'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Renderable
	 */
	public function admin_create()
	{
		
		$page_title = __('common.add_new_page');
		$pages = Page::get();
		$users = User::get();
        $cptTaxoScreenOption = $this->taxonomies_by_cpt(true);
		$screenOption = array_merge(config('page.ScreenOption'),$cptTaxoScreenOption);
		return view('admin.pages.create', compact('users', 'pages','page_title','screenOption'));
	}

	/**
	 * Store a newly created resource in storage.
	 * @param Request $request
	 * @return Renderable
	 */
	public function admin_store(Request $request)
	{
		$validation = [
			'data.Page.title'       	=> 'required',
			'data.Page.content'     	=> ['required', new EditorEmptyCheckRule],
			'data.Page.slug'  			=> 'required|unique:pages,slug',
			'data.Page.publish_on'  	=> 'required',
            'data.PageMeta.0.value'     => 'mimes:jpg,png,jpeg,gif,svg,webp',
		];

		$validationMsg = [
			'data.Page.title.required'      => __('common.title_field_required'),
			'data.Page.content.required'    => __('common.page_content_field_required'),
			'data.Page.publish_on.required' => __('common.published_on_field_required'),
            'data.PageMeta.0.value.mimes'   => __('common.feature_image_validation'),
		];

		$this->validate($request, $validation, $validationMsg);
		
		$pageData = $request->input('data.Page');
		$user_id 	= Auth::id();
		$pageData['user_id'] = $user_id;
		$page       = Page::create($pageData);
		$page_metas = collect($request->data['PageMeta'])->sortKeys()->all();
		
		/* for page options save */
		if (!empty($request->file('page-options'))) {
            foreach($request->file('page-options') as $imgKey => $imgValue)
            {
                if (is_array($imgValue)) {
                    foreach ($imgValue as $image) {
                        $fileName = $image->hashName();
                        $image->storeAs('public/page-options', $image->hashName());
                        $fileFullName[] = $fileName;
                    }
                    $fileName = implode(",",$fileFullName);
                }
                else {
                    $fileName = time().'.'.$imgValue->getClientOriginalName();
                    $imgValue->storeAs('public/page-options', $fileName);
                }

                $request->merge([
                    'page-options' => array_merge($request->input('page-options'), [$imgKey => $fileName])
                ]);
            }
        }
	
		if (!empty($request->{'page-options'})) {
			$page_options = serialize(array_filter($request->{'page-options'}, function($value) {
	            return ($value !== null && $value !== false && $value !== ''); 
	        }));
	        $page_metas = array_merge($page_metas,[['title'=>'w3_page_options' ,'value'=>$page_options]]);
		}
		/* for page options save */

		if($page)
		{
			$pageseo    = $page->page_seo()->create($request->input('data.PageSeo'));
			
			$page->page_categories()->sync(
			    collect($request->input('data.BlogCategory'))->mapWithKeys(function ($categoryId) {
			        return [$categoryId => ['object_type' => 2]];
			    })->toArray()
			);

			if(!empty($page_metas))
			{
				foreach ($page_metas as $page_meta) {
					if($page_meta['title'] == 'ximage')
					{
						if(!empty($page_meta['value']))
						{
							$OriginalName = $page_meta['value']->getClientOriginalName();
							$fileName = time().'_'.$OriginalName;
							$page_meta['value']->storeAs('public/page-images/', $fileName);
							$pageMetaArr = ['title' => $page_meta['title'], 'value' => $fileName];
							$page_meta['value'] = $fileName;
						}
					} else 
					{
						$pageMetaArr = ['title' => $page_meta['title'], 'page_id'=>$page->id, 'value' => $page_meta['value']];
					}

					$page->page_metas()->create($page_meta);

				}
			}

            $CustomFieldObj = new CustomField();
            $CustomFieldObj->update_custom_field($request, $page->id);

			/* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('PAGE-ANP', $page->id, $user_id, config('constants.superadmin'));
            /* End Send Event Notification */

			return redirect()->route('page.admin.index')->with('success', __('common.page_add_success'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	/**
	 * Show the specified resource.
	 * @param int $id
	 * @return Renderable
	 */
	public function show($id)
	{
		return view('admin.pages.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param int $id
	 * @return Renderable
	 */
	public function admin_edit($id)
	{
		$page_title = __('common.edit_page');
		$users = User::get();

		$parentPages = Page::where('id', '!=', $id)->where(function ($query) use($id)
		{
			$query->where('parent_id', '!=', $id);
			$query->orWhereNull('parent_id');
		})->get();

		$page = Page::with('page_metas', 'page_seo', 'feature_img')->findorFail($id);
        $cptTaxoScreenOption = $this->taxonomies_by_cpt(true);
		$screenOption = array_merge(config('page.ScreenOption'),$cptTaxoScreenOption);
		return view('admin.pages.edit', compact('parentPages', 'users', 'page','page_title','screenOption'));
	}

	/**
	 * Update the specified resource in storage.
	 * @param Request $request
	 * @param int $id
	 * @return Renderable
	 */
	public function admin_update(Request $request, $id)
	{
		$validation = [
			'data.Page.title'       => 'required',
			'data.Page.content'     => ['required', new EditorEmptyCheckRule],
			'data.Page.editslug'  		=> 'required|unique:pages,slug,'.$id,
			'data.Page.publish_on'  => 'required',
            'data.PageMeta.0.value'     => 'mimes:jpg,png,jpeg,gif,svg,webp',
		];

		$validationMsg = [
			'data.Page.title.required'      => __('common.title_field_required'),
			'data.Page.content.required'    => __('common.page_content_field_required'),
			'data.Page.publish_on.required' => __('common.published_on_field_required'),
            'data.PageMeta.0.value.mimes'   => __('common.feature_image_validation'),
			'data.Page.editslug.required'   => __('common.slug_field_required'),
		];

		$this->validate($request, $validation, $validationMsg,['data.Page.editslug' => 'slug']);

		$page       		= Page::with('page_metas', 'page_seo')->findorFail($id);
		$pageArr 			= $request->input('data.Page');
		$pageArr['slug'] 	= $request->input('data.Page.editslug');
		$page->fill($pageArr)->save();
		$page_metas = collect($request->data['PageMeta'])->sortKeys()->all();
		/* for page options save */
		if (!empty($request->file('page-options'))) {
            foreach($request->file('page-options') as $imgKey => $imgValue)
            {
                if (is_array($imgValue)) {
                    foreach ($imgValue as $image) {
                        $fileName = $image->hashName();
                        $image->storeAs('public/page-options', $image->hashName());
                        $fileFullName[] = $fileName;
                    }
                    $fileName = implode(",",$fileFullName);
                }
                else {
                    $fileName = time().'.'.$imgValue->getClientOriginalName();
                    $imgValue->storeAs('public/page-options', $fileName);
                }

                $request->merge([
                    'page-options' => array_merge($request->input('page-options'), [$imgKey => $fileName])
                ]);
            }
        }
		if (!empty($request->{'page-options'})) {
			$page_options = serialize(array_filter($request->input('page-options'), function($value) {
	            return ($value !== null && $value !== false && $value !== ''); 
	        }));
	        $page_metas = array_merge($page_metas,[['title'=>'w3_page_options' ,'value'=>$page_options]]);
	    }
		/* for page options save */
		
		if($page)
		{
			$pageseo = $page->page_seo()->updateOrCreate(
							    ['page_id' => $page->id],
							    [
				                    'page_id'           => $page->id,
				                    'page_title'        => $request->input('data.PageSeo.page_title'),
				                    'meta_keywords'     => $request->input('data.PageSeo.meta_keywords'),
				                    'meta_descriptions' => $request->input('data.PageSeo.meta_descriptions'),
				                ]
							);
			$page->page_categories()->sync(
			    collect($request->input('data.BlogCategory'))->mapWithKeys(function ($categoryId) {
			        return [$categoryId => ['object_type' => 2]];
			    })->toArray()
			);
			
			if(!empty($page_metas))
			{   
				$pageMetaIds = array_column($page_metas, 'meta_id');  
                DB::table('page_metas')->where('page_id', $id)->delete();
            
				foreach ($page_metas as $page_meta) {

                    if($page_meta['title'] != ''){
                        if($page_meta['title'] != 'ximage')
                        {
                            $page->page_metas()->create($page_meta);
                        }
                        else
                        {
                            
                            if(!empty($page_meta['value']))
                            {
                                $OriginalName = $page_meta['value']->getClientOriginalName();
                                $fileName = time().'_'.$OriginalName;
                                $page_meta['value']->storeAs('public/page-images/', $fileName);
                                if($page_meta['old_value'] && Storage::exists('public/page-images/'.$page_meta['old_value']))
                                {
                                    Storage::delete('public/page-images/'.$page_meta['old_value']);
                                }
                                $page_meta['value'] = $fileName;
                            }
                            else
                            {
                                if($page_meta['old_value'] && Storage::exists('public/page-images/'.$page_meta['old_value']))
                                {
                                    $page_meta['value'] = $page_meta['old_value'];
                                }
                            }
                            $page->page_metas()->create($page_meta);
                        }
                    }
				}
			}

            $CustomFieldObj = new CustomField();
            $CustomFieldObj->update_custom_field($request, $page->id);

			/* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('PAGE-UP', $page->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

			return redirect()->route('page.admin.index')->with('success', __('common.page_update_success'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	/**
	 * Remove the specified resource from storage.
	 * @param int $id
	 * @return Renderable
	 */
	public function admin_destroy($id)
	{
		$page           = Page::findOrFail($id);

		/* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('PAGE-DP', $page->id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
		$res            = $page->delete();
		if($res)
		{

			return redirect()->back()->with('success', __('common.page_delete_success'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	public function admin_trash_status($id)
	{
        
		$page           = Page::findOrFail($id);
		$page->status   = 3;
		$res            = $page->save();

		if($res)
		{
			/* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('PAGE-TP', $page->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */
            
			return redirect()->back()->with('success', __('common.page_trash_success'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	public function restore_page($id)
	{
		$page           = Page::findOrFail($id);
		$page->status   = 1;
		$res            = $page->save();

		if($res)
		{
			return redirect()->back()->with('success', __('common.page_restore_success'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	public function trash_list(Request $request)
	{
		$page_title = __('common.trashed_pages');
		$pages_query = Page::query()->where('status','=', 3);

		$pages_query->join('users', 'pages.user_id', '=', 'users.id');
		$pages_query->select('pages.*','users.name as user_name');

        $sortWith = $request->get('with') ? $request->get('with') : Null;
		$sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        
        
        if($sortWith == 'users')
    	{
			$pages_query->orderBy('users.'.$sortBy, $direction);
    	}
    	else
    	{
			$pages_query->orderBy('pages.'.$sortBy, $direction);
    	}


		$pages = $pages_query->paginate(config('Reading.nodes_per_page'));
		return view('admin.pages.trashed_pages', compact('pages','page_title'));
	}

	public function remove_feature_image($id)
	{
		$page_meta	= PageMeta::where('title', '=', 'ximage')->where('page_id', '=', $id)->first();
		if(!empty($page_meta->value) && Storage::exists('public/page-images/'.$page_meta->value))
		{
			Storage::delete('public/page-images/'.$page_meta->value);
			return $page_meta->delete();
		}
	}
}
