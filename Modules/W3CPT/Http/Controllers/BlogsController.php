<?php

namespace Modules\W3CPT\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\W3CPT\Entities\Blog;
use Modules\W3CPT\Entities\BlogCategory;
use Modules\W3CPT\Entities\BlogBlogCategory;
use Modules\W3CPT\Entities\BlogTag;
use Modules\W3CPT\Entities\BlogBlogTag;
use Modules\W3CPT\Entities\BlogMeta;
use Modules\W3CPT\Entities\BlogSeo;
use Modules\CustomField\Entities\CustomField;
use App\Models\User;
use App\Rules\EditorEmptyCheckRule;
use App\Models\Notification;
use Storage;
use Validate;
use Auth;

class BlogsController extends ModuleController
{	

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {        

        $post_type = $this->post_type;
        $page_title = $post_type['cpt_labels']['name'];
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
                    $query->where('terms.id', '=', $request->input('category'));
                });
            }
            if($request->filled('tag')) {
                $resultQuery->whereHas('blog_tags',function($query) use($request){
                    $query->where('blog_tags.id', '=', $request->input('tag'));
                });
            }
        }
        $resultQuery->join('users', 'blogs.user_id', '=', 'users.id');
        $resultQuery->select('blogs.*','users.name as user_name');
        $resultQuery->where('status', '!=', 3)->where('post_type', '=', $post_type['name']);

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
        $status = config('blog.status');

        return view('w3cpt::admin.blogs.index', compact('blogs','blog_categories','blog_tags','users','page_title', 'status', 'post_type'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $post_type = $this->post_type;
        $page_title = $post_type['cpt_labels']['name'];
        $screenOption = $this->screenOption($post_type);
        $blogs = Blog::get();
        $users = User::get();
        $blogCatArr = !empty(old('data.BlogCategory')) ? old('data.BlogCategory') : array();
        $categoryArr = (new BlogCategory())->generateCategoryTreeListCheckbox(Null, ' ', $blogCatArr);
        $parentCategoryArr = (new BlogCategory())->generateCategoryTreeArray(Null, '&nbsp;&nbsp;&nbsp;');
        return view('w3cpt::admin.blogs.create', compact('users', 'blogs', 'categoryArr', 'parentCategoryArr', 'page_title', 'screenOption', 'post_type', 'blogCatArr'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $screenOption = array_keys($this->screenOption($this->post_type));

        if(!in_array('Title', $screenOption))
        {
            $req = $request->all();
            $req['data']['Blog']['title'] = __('No Title');
            $req['data']['Blog']['slug'] = \Str::slug(__('No Title'));
            $request->merge($req);
        }

        $validation = [
            'data.Blog.title'           => 'required',
            'data.Blog.publish_on'      => 'required',
            'data.BlogMeta.0.value'     => 'mimes:jpg,png,jpeg,gif,svg,webp',
        ];

        $validationMsg = [
            'data.Blog.title.required'      => __('The title field is required.'),
            'data.Blog.publish_on.required' => __('The published on field is required.'),
            'data.Blog.slug.unique'         => __('The slug has already been taken.'),
            'data.BlogMeta.0.value.mimes'   => __('The feature image must be a file of type: jpg, png, jpeg, gif.'),
        ];
        
        $this->validate($request, $validation, $validationMsg);
        $blogData   = $request->input('data.Blog');
        $blogData['user_id'] = $request->input('data.Blog.user_id') ? $request->input('data.Blog.user_id') : Auth::id();
        $blogData['post_type'] = $this->post_type['cpt_name'];
        $blog       = Blog::create($blogData);
        $blog_metas = isset($request->data['BlogMeta']) ? collect($request->data['BlogMeta'])->sortKeys()->all() : collect();

        /* for Blog options save */
        if (!empty($request->file('blog-options'))) {
            foreach($request->file('blog-options') as $imgKey => $imgValue)
            {
                if (is_array($imgValue)) {
                    foreach ($imgValue as $image) {
                        $fileName = $image->hashName();
                        $image->storeAs('public/blog-options', $image->hashName());
                        $fileFullName[] = $fileName;
                    }
                    $fileName = implode(",",$fileFullName);
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
                    $BlogTag = BlogTag::where('title', '=', $blog_tag)->where('user_id', '=', Auth::id())->first();

                    if(!empty($BlogTag))
                    {
                        $BlogTagIds[] = $BlogTag->id;
                    }
                    else
                    {
                        $BlogTag = new BlogTag();
                        $BlogTag->title = $blog_tag;
                        $BlogTag->slug = $blog_tag;
                        $BlogTag->user_id = Auth::id();
                        $BlogTag->save();
                        $BlogTagIds[] = $BlogTag->id;
                    }

                }
            }

            $blog->blog_categories()->sync($request->input('data.BlogCategory'));
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
            $notificationObj->notification_entry('BLOG-ANB', $blog->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('cpt.blog.admin.index', ['post_type' => $this->post_type['cpt_name']])->with('success', $this->post_type['cpt_labels']['name'].' '.__('w3cpt::common.added_successfully'));

        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $post_type = $this->post_type;
        $page_title = $post_type['cpt_labels']['name'];
        $screenOption = $this->screenOption($post_type);
        $blogs = Blog::where('id', '!=', $id)->get();
        $users = User::get();
        $blog = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user', 'feature_img', 'video')->findorFail($id);
        $blogCatArr = !empty(old('data.BlogCategory')) ? old('data.BlogCategory') : array_column($blog->blog_categories->toArray(), 'id');
        $categoryArr = (new BlogCategory())->generateCategoryTreeListCheckbox(Null, ' ', $blogCatArr);
        $parentCategoryArr = (new BlogCategory())->generateCategoryTreeArray(Null, '&nbsp;&nbsp;&nbsp;');
        $tags = array_column($blog->blog_tags->toArray(), 'title');
        $blog_tags = implode(',', $tags);
        return view('w3cpt::admin.blogs.edit', compact('blogs', 'users', 'blog', 'categoryArr', 'parentCategoryArr', 'blog_tags', 'page_title', 'screenOption', 'post_type', 'blogCatArr'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_update(Request $request, $id)
    {

        $blog               = Blog::findorFail($id);
        $screenOption = array_keys($this->screenOption($this->post_type));

        if(!in_array('Title', $screenOption))
        {
            $req = $request->all();
            $req['data']['Blog']['title'] = $blog->title;
            $req['data']['Blog']['slug'] = $request->input('data.Blog.editslug') ? $request->input('data.Blog.editslug') : $blog->slug;
            $request->merge($req);
        }

        $validation = [
                'data.Blog.title'           => 'required',
                'data.Blog.publish_on'      => 'required',
                'data.BlogMeta.0.value'     => 'mimes:jpg,png,jpeg,gif,svg,webp',
            ];

        $validationMsg = [
            'data.Blog.title.required'      => __('The title field is required.'),
            'data.Blog.publish_on.required' => __('The published on field is required.'),
            'data.BlogMeta.0.value.mimes'   => __('The feature image must be a file of type: jpg, png, jpeg, gif.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogArr            = $request->input('data.Blog');
        $blogArr['slug']    = $request->input('data.Blog.editslug') ? $request->input('data.Blog.editslug') : $blog->slug;
        $blog->fill($blogArr)->save();
        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();

        /* for Blog options save */
        if (!empty($request->file('blog-options'))) {
            foreach($request->file('blog-options') as $imgKey => $imgValue)
            {
                if (is_array($imgValue)) {
                    foreach ($imgValue as $image) {
                        $fileName = $image->hashName();
                        $image->storeAs('public/blog-options', $image->hashName());
                        $fileFullName[] = $fileName;
                    }
                    $fileName = implode(",",$fileFullName);
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
                    $BlogTag = BlogTag::where('title', '=', $blog_tag)->where('user_id', '=', Auth::id())->first();

                    if(!empty($BlogTag))
                    {
                        $BlogTagIds[] = $BlogTag->id;
                    }
                    else
                    {
                        $BlogTag = new BlogTag();
                        $BlogTag->title = $blog_tag;
                        $BlogTag->slug = $blog_tag;
                        $BlogTag->user_id = Auth::id();
                        $BlogTag->save();
                        $BlogTagIds[] = $BlogTag->id;
                    }

                }
            }

            $blog->blog_categories()->sync($request->input('data.BlogCategory'));
            $blog->blog_tags()->sync($BlogTagIds);

            if(!empty($blog_metas))
            {   
                $blogMetaIds = array_column($blog_metas, 'meta_id');
                BlogMeta::where('blog_id', '=', $id)->whereNotIn('id', $blogMetaIds)->delete();

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

            $CustomFieldObj = new CustomField();
            $CustomFieldObj->update_custom_field($request, $blog->id);

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-UB', $blog->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('cpt.blog.admin.index', ['post_type' => $this->post_type['cpt_name']])->with('success', $this->post_type['cpt_labels']['name'].' '.__('w3cpt::common.updated_successfully'));

        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function admin_destroy($id)
    {
        $blog           = Blog::findOrFail($id);
        $res            = $blog->delete();
        if($res)
        {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-DB', $blog->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->back()->with('success', $this->post_type['cpt_labels']['name'].' '.__('w3cpt::common.deleted_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    public function admin_trash_status($id)
    {
        $blog           = Blog::findOrFail($id);
        $blog->status   = 3;
        $res            = $blog->save();

        if($res)
        {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-TB', $blog->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */
            
            return redirect()->back()->with('success', $this->post_type['cpt_labels']['name'].' '.__('w3cpt::common.moved_trash_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    public function restore_blog($id)
    {
        $blog           = Blog::findOrFail($id);
        $blog->status   = 1;
        $res            = $blog->update();

        if($res)
        {
            return redirect()->back()->with('success', $this->post_type['cpt_labels']['name'].' '.__('w3cpt::common.restored_successfully'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    public function trash_list(Request $request)
    {
        $post_type = $this->post_type;
        $page_title = $post_type['cpt_labels']['name'];
        $resultQuery = Blog::query();


        $resultQuery->join('users', 'blogs.user_id', '=', 'users.id');
        $resultQuery->select('blogs.*','users.name as user_name');
        $resultQuery->where('status', '=', 3);

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

        return view('w3cpt::admin.blogs.trashed_blogs', compact('blogs', 'post_type', 'page_title'));
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

    private function screenOption($post_type=Null)
    {
        $cpt_supports = !empty($post_type['cpt_supports']) ? unserialize($post_type['cpt_supports']) : array();
        $cpt_builtin_taxonomies = !empty($post_type['cpt_builtin_taxonomies']) ? unserialize($post_type['cpt_builtin_taxonomies']) : array();
        $cptScreenOption = array_intersect_key(config('w3cpt.ScreenOption.cpt_options'), array_flip($cpt_supports));
        $taxoScreenOption = array_intersect_key(config('w3cpt.ScreenOption.taxonomy_options'), array_flip($cpt_builtin_taxonomies));
        $cptTaxoScreenOption = $this->taxonomies_by_cpt(true);

        $newScreenOptions = array_merge($taxoScreenOption, $cptScreenOption, $cptTaxoScreenOption);

        return $newScreenOptions;
    }
}
