<?php

namespace Modules\W3CPT\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\W3CPT\Entities\BlogTag;
use App\Models\Notification;
use Auth;

class BlogTagsController extends ModuleController
{
    public function list(Request $request, $id='')
    {
        $page_title = __('w3cpt::common.blog_tag_list');
        $blog_tags    = BlogTag::withCount('blog')->paginate(config('Reading.nodes_per_page'));
        $blogTag       = BlogTag::find($id);
        $newTag        = false;
        if(empty($blogTag))
        {
            $blogTag = new BlogTag();
            $newTag = true;
        }

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required',
                'slug'             => 'required',
            ];

            $validationMsg = [
                'title.required'    => __('w3cpt::common.title_field_required'),
                'title.required'    => __('w3cpt::common.slug_field_required'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $blogTag->user_id      = Auth::id();
            $blogTag->title        = $request->title;
            $blogTag->slug         = $request->slug;
            $res                   = $blogTag->save();
            $blogTag->save();

            if($res)
            {
                /* Send Event Notification */
                $notify_code = $newTag ? 'BLOG-ANBT' : 'BLOG-UBT';
                $notificationObj        = new Notification();
                $notificationObj->notification_entry($notify_code, $blogTag->id, Auth::id(), config('constants.superadmin'));
                /* End Send Event Notification */

                $msg = $newTag ? __('common.blog_tag_add_success') : __('common.blog_tag_update_success');
                return redirect()->route('blog_tag.admin.list')->with('success', $msg);
            }
            return redirect()->route('blog_tag.admin.list')->with('error', __('Something went wrong.'));
        }
        return view('w3cpt::admin.blog_tags.list', compact('blog_tags', 'blogTag','page_title'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $page_title = __('All Blog Tags');
        
        $blogs_tag_query = BlogTag::query();
        if($request->isMethod('get'))
        {
            if($request->filled('title')) {
                $blogs_tag_query->where('title', 'like', "%{$request->input('title')}%");
            }
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $blogs_tag_query->orderBy($sortBy, $direction);

        $blog_tags = $blogs_tag_query->withCount('blog')->paginate(config('Reading.nodes_per_page'));
        return view('w3cpt::admin.blog_tags.index', compact('blog_tags','page_title'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('Add New Blog Tag');
        $blog_tags = BlogTag::get();
        return view('w3cpt::admin.blog_tags.create', compact('blog_tags','page_title'));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $validation = [
                'data.BlogTag.title'      => 'required',
                'data.BlogTag.slug'       => 'required',
            ];

        $validationMsg = [
            'data.BlogTag.title.required'     => __('The title field is required.'),
            'data.BlogTag.slug.required'      => __('The slug field is required.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogTagReq                = $request->input('data.BlogTag');
        $blogTagReq['user_id']     = Auth::id();
        $blogTag                   = BlogTag::create($blogTagReq);
        if($blogTag)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-ANBT', $blogTag->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('blog_tag.admin.index')->with('success', __('Blog tag added successfully.'));
        }
        return redirect()->back()->with('error', __('Sorry, Something went wrong.'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_show($id)
    {
        return view('w3cpt::admin.blog_tags.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $page_title = __('Edit Blog Tag');
        $blog_tag = BlogTag::findorFail($id);
        $blog_tags = BlogTag::get();
        return view('w3cpt::admin.blog_tags.edit', compact('blog_tags', 'blog_tag','page_title'));
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
                'data.BlogTag.title'       => 'required',
            ];

        $validationMsg = [
            'data.BlogTag.title.required'      => __('The title field is required.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogTagReq                = $request->input('data.BlogTag');
        $blogTagReq['user_id']     = Auth::id();
        $blogTag                   = BlogTag::where('id', '=', $id)->update($blogTagReq);
        if($blogTag)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-UBT', $blogTag->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('blog_tag.admin.index')->with('success', __('w3cpt::common.blog_tag_add_success'));
        }
        return redirect()->back()->with('error', __('Sorry, Something went wrong.'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function admin_destroy($id)
    {
        $res = BlogTag::destroy($id);
        
        if($res)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-DBT', $id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->back()->with('success', __('Blog tag deleted successfully.'));
        }
        return redirect()->back()->with('error', __('Sorry, Something went wrong.'));
    }
}
