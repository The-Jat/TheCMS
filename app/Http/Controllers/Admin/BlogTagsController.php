<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogTag;
use App\Models\Notification;
use Auth;

class BlogTagsController extends Controller
{
    public function list(Request $request, $id='')
    {
        $page_title = __('common.blog_tag_list');
        $blog_tags    = BlogTag::withCount('blog')->paginate(config('Reading.nodes_per_page'));
        $blogTag       = BlogTag::find($id);
        $newTag           = false;
        if(empty($blogTag))
        {
            $blogTag = new BlogTag();
            $newTag = true;
        }

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required',
                'slug'             => 'required|unique:blog_tags,slug,'.$id,
            ];

            $validationMsg = [
                'title.required'    => __('common.title_field_required'),
                'title.required'    => __('common.slug_field_required'),
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
            return redirect()->route('blog_tag.admin.list')->with('error', __('common.something_went_wrong'));
        }
        return view('admin.blog_tags.list', compact('blog_tags', 'blogTag','page_title'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $page_title = __('common.all_blog_tags');

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
        return view('admin.blog_tags.index', compact('blog_tags','page_title'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('common.add_blog_tag');
        $blog_tags = BlogTag::get();
        return view('admin.blog_tags.create', compact('blog_tags','page_title'));

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
                'data.BlogTag.slug'       => 'required|unique:blog_tags,slug',
            ];

        $validationMsg = [
            'data.BlogTag.title.required'     => __('common.title_field_required'),
            'data.BlogTag.slug.required'      => __('common.slug_field_required'),
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

            return redirect()->route('blog_tag.admin.index')->with('success', __('common.blog_tag_add_success'));
        }
        return redirect()->back()->with('error', __('common.something_went_wrong'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_show($id)
    {
        return view('admin.blog_tags.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $page_title = __('common.edit_blog_tag');
        $blog_tag = BlogTag::findorFail($id);
        $blog_tags = BlogTag::get();
        return view('admin.blog_tags.edit', compact('blog_tags', 'blog_tag','page_title'));
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
            'data.BlogTag.title.required'      => __('common.title_field_required'),
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

            return redirect()->route('blog_tag.admin.index')->with('success', __('common.blog_tag_update_success'));
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

        $blogTag = BlogTag::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('BLOG-DBT', $id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */
            
        $res            = $blogTag->delete();

        if($res)
        {

            return redirect()->back()->with('success', __('common.blog_tag_delete_success'));
        }
        return redirect()->back()->with('error', __('common.something_went_wrong'));
    }
}
