<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogBlogCategory;
use App\Models\BlogTag;
use App\Models\BlogBlogTag;
use App\Models\BlogMeta;
use App\Models\Comment;
use App\Models\BlogSeo;
use App\Models\User;
use App\Models\Notification;
use App\Rules\EditorEmptyCheckRule;
use Modules\CustomField\Entities\CustomField;
use Storage;
use Auth;

class BlogsController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $page_title = __('common.all_blogs');
        $resultQuery = Blog::query();
        $users = User::get();
        $blog_categories = BlogCategory::get();
        $blog_tags = BlogTag::get();

        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            if($request->filled('status')) {
                $resultQuery->where('status', '=', $request->input('status'));
            }
            if($request->filled('from') && $request->filled('to')) {
                $resultQuery->whereBetween('blogs.created_at', [$request->input('from'), $request->input('to')]);
            }
            if($request->filled('publish_on')) {
                $resultQuery->whereDate('publish_on', '=', $request->input('publish_on'));
            }
            if($request->filled('user')) {
                $resultQuery->where('user_id', '=', $request->input('user'));
            }
            if($request->filled('visibility')) {
                $resultQuery->where('visibility', '=', $request->input('visibility'));
            }
            if($request->filled('category')) {
                $resultQuery->whereHas('blog_categories',function($query) use($request){
                    $query->where('blog_categories.id', '=', $request->input('category'));
                });
            }
            if($request->filled('tag')) {
                $resultQuery->whereHas('blog_tags',function($query) use($request){
                    $query->where('blog_tags.id', '=', $request->input('tag'));
                });
            }
        }
        $resultQuery->with('user');
        $resultQuery->where('status', '!=', 3);
        $resultQuery->where('post_type', '=', config('blog.post_type'));

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->orderBy('blogs.'.$sortBy, $direction);

        $blogs = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $status = config('blog.status');

        return view('admin.blogs.index', compact('blogs','blog_categories','blog_tags','users','page_title', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('common.add_new_blog');
        $blogs = Blog::where('post_type', '=', config('blog.post_type'))->get();
        $users = User::get();
        $blogCatArr = !empty(old('data.BlogCategory')) ? old('data.BlogCategory') : array();
        $categoryArr = (new BlogCategory())->generateCategoryTreeListCheckbox(Null, ' ', $blogCatArr);
        $parentCategoryArr = (new BlogCategory())->generateCategoryTreeArray(Null, '&nbsp;&nbsp;&nbsp;');
        
        $cptTaxoScreenOption = $this->taxonomies_by_cpt(true);
        $screenOption = array_merge(config('blog.ScreenOption'),$cptTaxoScreenOption);

        return view('admin.blogs.create', compact('users', 'blogs', 'categoryArr', 'parentCategoryArr', 'page_title', 'screenOption'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $validation = [
            'data.Blog.title'           => 'required',
            'data.Blog.content'         => ['required', new EditorEmptyCheckRule],
            'data.Blog.slug'            => 'required|unique:blogs,slug',
            'data.Blog.publish_on'      => 'required',
            'data.BlogMeta.0.value'     => 'mimes:jpg,png,jpeg,gif,svg,webp,svg,webp',
        ];

        $validationMsg = [
            'data.Blog.title.required'      => __('common.title_field_required'),
            'data.Blog.content.required'    => __('common.blog_content_field_required'),
            'data.Blog.publish_on.required' => __('common.published_on_field_required'),
            'data.Blog.slug.unique'         => __('common.slug_already_taken'),
            'data.BlogMeta.0.value.mimes'   => __('common.feature_image_validation'),
        ];

        $this->validate($request, $validation, $validationMsg);
        $blogData   = $request->input('data.Blog');
        $user_id    = Auth::id();
        $blogData['user_id'] = $request->input('data.Blog.user_id') ? $request->input('data.Blog.user_id') : $user_id;
        $blog       = Blog::create($blogData);
        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();
        
        /* for Blog options save */
        if (!empty($request->file('blog-options'))) {
            foreach($request->file('blog-options') as $imgKey => $imgValue)
            {
                $fileFullName = [];
            
                if (is_array($imgValue)) {
                    foreach ($imgValue as $key => $image) {

                        /* Multiple Image Upload */
                        if (is_array($image)) {

                            foreach ($image as $fieldName => $value) {
                                $fileName = $value->hashName();
                                $value->storeAs('public/blog-options', $value->hashName());
                                $request_value[$imgKey][$key][$fieldName] = $fileName;
                            }
                            $fileFullName = $request_value[$imgKey];

                        }
                        /* Single Image Upload */
                        else{
                            $fileName = $image->hashName();
                            $image->storeAs('public/blog-options', $image->hashName());
                            $fileFullName = !empty($fileFullName) ? $fileFullName.','.$fileName : $fileName;
                        }

                    }

                    $fileName = $fileFullName;
                }
                else {
                    $fileName = time().'.'.$imgValue->getClientOriginalName();
                    $imgValue->storeAs('public/blog-options', $fileName);
                }

                $request->merge([
                    'blog-options' => array_merge($request->input('blog-options'), [$imgKey => $fileName])
                ]);
            }
        }
        if (!empty($request->input('blog-options'))) {
            $blog_options = serialize(array_filter($request->input('blog-options'), function($value) {
                return ($value !== null && $value !== false && $value !== ''); 
            }));
            $blog_metas = array_merge($blog_metas,[['title'=>'w3_blog_options' ,'value'=>$blog_options]]);
        }
        /* for Blog options save */

        $blog_tags  = !empty($request->input('data.BlogTag')) ? explode(',', $request->input('data.BlogTag')) : '';

        if($blog)
        {
            $BlogSeo                    = new BlogSeo();
            $BlogSeo->blog_id           = $blog->id;
            $BlogSeo->page_title        = $request->input('data.BlogSeo.page_title');
            $BlogSeo->meta_keywords     = $request->input('data.BlogSeo.meta_keywords');
            $BlogSeo->meta_descriptions = $request->input('data.BlogSeo.meta_descriptions');
            $BlogSeo->blog_url          = $request->input('data.BlogSeo.blog_url');
            $BlogSeo->save();

            $BlogTagIds = array();

            if(!empty($blog_tags))
            {
                foreach ($blog_tags as $blog_tag)
                {
                    $BlogTag = BlogTag::where('title', '=', $blog_tag)->first();

                    if(!empty($BlogTag))
                    {
                        $BlogTagIds[] = $BlogTag->id;
                    }
                    else
                    {
                        $BlogTag = new BlogTag();
                        $BlogTag->title = $blog_tag;
                        $BlogTag->slug = $blog_tag;
                        $BlogTag->user_id = $user_id;
                        $BlogTag->save();
                        $BlogTagIds[] = $BlogTag->id;
                    }

                }
            }

            $blog->blog_categories()->sync($request->input('data.BlogCategory'));
            $blog->blog_taxo_categories()->sync($request->input('data.TaxoCategory'));
            $blog->blog_tags()->sync($BlogTagIds);

            if(!empty($blog_metas))
            {
                foreach ($blog_metas as $blog_meta) {

                    if($blog_meta['title'] != 'ximage')
                    {
                        $blog->blog_meta()->create($blog_meta);
                    }
                    else
                    {
                        if(!empty($blog_meta['value']))
                        {
                            $OriginalName = $blog_meta['value']->getClientOriginalName();
                            $fileName = time().'_'.$OriginalName;
                            $blog_meta['value']->storeAs('public/blog-images/', $fileName);
                            $blog_meta['value'] = $fileName;
                        }

                        $blog->blog_meta()->create($blog_meta);
                    }
                }
            }

            $CustomFieldObj = new CustomField();
            $CustomFieldObj->update_custom_field($request, $blog->id);

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-ANB', $blog->id, $user_id, config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('blog.admin.index')->with('success', __('common.blog_add_success_msg'));

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
        return view('admin.blogs.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $page_title = __('common.edit_blog');
        $blogs = Blog::where('id', '!=', $id)->where('post_type', '=', config('blog.post_type'))->get();
        $users = User::get();
        $blog = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user', 'feature_img', 'video')->where('post_type', '=', config('blog.post_type'))->findorFail($id);
        $blogCatArr = !empty(old('data.BlogCategory')) ? old('data.BlogCategory') : array_column($blog->blog_categories->toArray(), 'id');
        $categoryArr = (new BlogCategory())->generateCategoryTreeListCheckbox(Null, ' ', $blogCatArr);
        $parentCategoryArr = (new BlogCategory())->generateCategoryTreeArray(Null, '&nbsp;&nbsp;&nbsp;');
        $tags = array_column($blog->blog_tags->toArray(), 'title');
        $blog_tags = implode(',', $tags);

        $cptTaxoScreenOption = $this->taxonomies_by_cpt(true);
        $screenOption = array_merge(config('blog.ScreenOption'),$cptTaxoScreenOption);
        return view('admin.blogs.edit', compact('blogs', 'users', 'blog', 'categoryArr', 'parentCategoryArr', 'blog_tags', 'page_title', 'screenOption'));
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
                'data.Blog.title'           => 'required',
                'data.Blog.content'         => ['required', new EditorEmptyCheckRule],
                'data.Blog.publish_on'      => 'required',
                'data.Blog.editslug'            => 'required|unique:blogs,slug,'.$id,
                'data.BlogMeta.0.value'     => 'mimes:jpg,png,jpeg,gif,svg,webp',
            ];

        $validationMsg = [
            'data.Blog.title.required'      => __('common.title_field_required'),
            'data.Blog.content.required'    => __('common.blog_content_field_required'),
            'data.Blog.publish_on.required' => __('common.published_on_field_required'),
            'data.Blog.slug.unique'         => __('common.slug_already_taken'),
            'data.BlogMeta.0.value.mimes'   => __('common.feature_image_validation'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blog               = Blog::where('post_type', '=', config('blog.post_type'))->findorFail($id);
        $blogArr            = $request->input('data.Blog');
        $blogArr['slug']    = $request->input('data.Blog.editslug');
        $blog->fill($blogArr)->save();
        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();
       
        /* for Blog options save */
        if (!empty($request->file('blog-options'))) {
            foreach($request->file('blog-options') as $imgKey => $imgValue)
            {
                $fileFullName = [];
            
                if (is_array($imgValue)) {
                    foreach ($imgValue as $key => $image) {

                        /* Multiple Image Upload */
                        if (is_array($image)) {

                            foreach ($image as $fieldName => $value) {
                                $fileName = $value->hashName();
                                $value->storeAs('public/blog-options', $value->hashName());
                                $request_value[$imgKey][$key][$fieldName] = $fileName;
                            }
                            $fileFullName = $request_value[$imgKey];

                        }
                        /* Single Image Upload */
                        else{
                            $fileName = $image->hashName();
                            $image->storeAs('public/blog-options', $image->hashName());
                            $fileFullName = !empty($fileFullName) ? $fileFullName.','.$fileName : $fileName;
                        }

                    }

                    $fileName = $fileFullName;
                }
                else {
                    $fileName = time().'.'.$imgValue->getClientOriginalName();
                    $imgValue->storeAs('public/blog-options', $fileName);
                }

                $request->merge([
                    'blog-options' => array_merge($request->input('blog-options'), [$imgKey => $fileName])
                ]);
            }
        }

        if (!empty($request->input('blog-options'))) {
            $blog_options = serialize(array_filter($request->input('blog-options'), function($value) {
                return ($value !== null && $value !== false && $value !== ''); 
            }));
            $blog_metas = array_merge($blog_metas,[['title'=>'w3_blog_options' ,'value'=>$blog_options]]);
        }
        /* for Blog options save */

        $blog_tags  = !empty($request->input('data.BlogTag')) ? explode(',', $request->input('data.BlogTag')) : '';
        $user_id = Auth::id();
        if($blog)
        {
            BlogSeo::updateOrCreate(
                ['blog_id' => $blog->id],
                [
                    'blog_id'           => $blog->id,
                    'page_title'        => $request->input('data.BlogSeo.page_title'),
                    'meta_keywords'     => $request->input('data.BlogSeo.meta_keywords'),
                    'meta_descriptions' => $request->input('data.BlogSeo.meta_descriptions'),
                    'blog_url'          => $request->input('data.BlogSeo.blog_url'),
                ]
            );

            $BlogTagIds = array();

            if(!empty($blog_tags))
            {
                foreach ($blog_tags as $blog_tag)
                {
                    $BlogTag = BlogTag::where('title', '=', $blog_tag)->where('user_id', '=', $user_id)->first();

                    if(!empty($BlogTag))
                    {
                        $BlogTagIds[] = $BlogTag->id;
                    }
                    else
                    {
                        $BlogTag = new BlogTag();
                        $BlogTag->title = $blog_tag;
                        $BlogTag->slug = $blog_tag;
                        $BlogTag->user_id = $user_id;
                        $BlogTag->save();
                        $BlogTagIds[] = $BlogTag->id;
                    }

                }
            }

            $blog->blog_categories()->sync($request->input('data.BlogCategory'));
            $blog->blog_taxo_categories()->sync($request->input('data.TaxoCategory'));
            $blog->blog_tags()->sync($BlogTagIds);

            if(!empty($blog_metas))
            {
                $blogMetaIds = array_column($blog_metas, 'meta_id');
                BlogMeta::where('blog_id', '=', $id)->whereNotIn('id', $blogMetaIds)->delete();

                foreach ($blog_metas as $blog_meta) {

                    if($blog_meta['title'] != ''){
                        if($blog_meta['title'] != 'ximage' && $blog_meta['title'] != '')
                        {
                            $blog->blog_meta()->create($blog_meta);
                        }
                        else
                        {
                            if(!empty($blog_meta['value']))
                            {
                                $OriginalName = $blog_meta['value']->getClientOriginalName();
                                $fileName = time().'_'.$OriginalName;
                                $blog_meta['value']->storeAs('public/blog-images/', $fileName);
                                if($blog_meta['old_value'] && Storage::exists('public/blog-images/'.$blog_meta['old_value']))
                                {
                                    Storage::delete('public/blog-images/'.$blog_meta['old_value']);
                                }
                                $blog_meta['value'] = $fileName;
                            }
                            else
                            {
                                if(Storage::exists('public/blog-images/'.$blog_meta['old_value']))
                                {
                                    $blog_meta['value'] = $blog_meta['old_value'];
                                }
                            }
                            $blog->blog_meta()->create($blog_meta);
                        }
                    }

                }
            }

            $CustomFieldObj = new CustomField();
            $CustomFieldObj->update_custom_field($request, $blog->id);

            /* Send Event Notification */
			$notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-UB', $blog->id, $user_id, config('constants.superadmin'));
            /* End Send Event Notification */

			return redirect()->route('blog.admin.index')->with('success', __('common.blog_update_success_msg'));

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

        $blog           = Blog::where('post_type', '=', config('blog.post_type'))->findOrFail($id);
        
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('BLOG-DB', $blog->id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        $res            = $blog->delete();
        if($res)
        {
            Comment::where('object_type', '=' ,'1')->where('object_id', '=' ,$id)->delete();

            return redirect()->back()->with('success', __('common.blog_delete_success_msg'));
        }
        return redirect()->back()->with('error', __('common.something_went_wrong'));
    }

    public function admin_trash_status($id)
    {
        $blog           = Blog::where('post_type', '=', config('blog.post_type'))->findOrFail($id);
        $blog->status   = 3;
        $res            = $blog->save();

        if($res)
        {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-TB', $blog->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->back()->with('success', __('common.blog_trashed_success_msg'));
        }
        return redirect()->back()->with('error', __('common.something_went_wrong'));
    }

    public function restore_blog($id)
    {
        $blog           = Blog::where('post_type', '=', config('blog.post_type'))->findOrFail($id);
        $blog->status   = 1;
        $res            = $blog->update();

        if($res)
        {
            return redirect()->back()->with('success', __('common.blog_restored_success_msg'));
        }
        return redirect()->back()->with('error', __('common.something_went_wrong'));
    }

    public function trash_list(Request $request)
    {
        $page_title = __('common.trashed_blogs');
        $resultQuery = Blog::query();


        $resultQuery->join('users', 'blogs.user_id', '=', 'users.id');
        $resultQuery->select('blogs.*','users.name as user_name');
        $resultQuery->where('status', '=', 3);
        $resultQuery->where('post_type', '=', config('blog.post_type'));

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        if($sortWith == 'users')
        {
            $resultQuery->orderBy('users.'.$sortBy, $direction);
        }
        else{
            $resultQuery->orderBy('blogs.'.$sortBy, $direction);
        }

        $blogs = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.blogs.trashed_blogs', compact('blogs', 'page_title'));
    }

    public function blogCategoryTree($id = Null, $level = 0)
    {
        $parents    = BlogCategory::where('parent_id', '=', $id)->get();
        $res        = !empty($res) ? $res : array();
        $blank = "";
        if(!empty($parents))
        {
            $level++;
            for($i=0; $i< $level; $i++) {
                $blank .= " ";
                foreach($parents as $value)
                {
                    $title = $blank.$value->title;
                    $res[] = $title;
                    array_merge($res, $this->blogCategoryTree($value->id, $level));
                }
            }
        }
        return $res;
    }

    public function remove_feature_image($id)
    {
        $blog_meta  = BlogMeta::where('title', '=', 'ximage')->where('blog_id', '=', $id)->first();
        if(!empty($blog_meta->value) && Storage::exists('public/blog-images/'.$blog_meta->value))
        {
            Storage::delete('public/blog-images/'.$blog_meta->value);
            return $blog_meta->delete();
        }
    }

}
