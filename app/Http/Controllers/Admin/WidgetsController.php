<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;


class WidgetsController extends Controller
{
	public function index(Request $request) {
        $page_title = __('common.all_widgets');

        $blogQuery = Blog::query();
		$blogQuery->where('status', '!=', 3);

		$widgetsQuery = clone $blogQuery;
		$widgets = $widgetsQuery->where('post_type', '=', 'widgets')->get();

		$blocksQuery = clone $blogQuery;
		$blocksQuery->join('blog_metas', 'blogs.id', '=', 'blog_metas.blog_id');
		$blocksQuery->select('blogs.*', 'blog_metas.value as type');
		$blocks = $blocksQuery->where('post_type', '=', 'sidebars')->orderBy('type','ASC')->get();
		
        return view('admin.widget.index', compact('page_title','widgets','blocks'));
		
	}

	public function create(Request $request) {
        $page_title = __('common.add_widget');
        return view('admin.widget.create', compact('page_title'));
		
	}

	public function store(Request $request) {

        $validation = [
            'title'           => 'required',
            'content'         => 'required',
            'slug'            => 'required|unique:blogs,slug',
        ];

        $validationMsg = [
            'content.required'    => __('Please add Some Content.'),
        ];

        $this->validate($request, $validation, $validationMsg);
		$user_id 	= \Auth::id();

        $blogData['title'] = $request->title;
        $blogData['slug'] = $request->slug;
        $blogData['content'] = $request->content;
        $blogData['user_id'] = $user_id;

        $blogData['post_type'] = 'widgets';
        $blogData['status'] = 1;
        $blogData['publish_on'] = date('Y-m-d H:i:s');

        $blog       = Blog::create($blogData);

        if($blog)
		{
			return redirect()->route('admin.widgets.index')->with('success', __('common.widget_stored_successfully'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	public function edit(Request $request,$id) {
        $page_title = __('common.edit_widget');
		$widget = Blog::findorFail($id);

        return view('admin.widget.edit', compact('page_title','widget'));
	}

	public function update(Request $request,$id) {
		$validation = [
            'title'           => 'required',
            'content'         => 'required',
            'slug'            => 'required|unique:blogs,slug,' . $id,
        ];

        $validationMsg = [
            'content.required'    => __('Please add Some Content.'),
        ];

        $this->validate($request, $validation, $validationMsg);

		$blog = Blog::find($id);

        $blogData = [
	        'title' => $request->title,
	        'slug' => $request->slug,
	        'content' => $request->content,
	    ];

        $res = $blog->update($blogData);
        if($res)
		{
			return redirect()->route('admin.widgets.index')->with('success', __('common.widget_updated_successfully'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	public function destroy(Request $request,$id) {
		$widget           = Blog::findOrFail($id);
		$res            = $widget->delete();

		if($res)
		{
			return redirect()->route('admin.widgets.index')->with('success', __('common.widget_delete_success'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	public function destroy_block(Request $request,$id) {
		$block           = Blog::findOrFail($id);
		$res            = $block->delete();

		if($res)
		{
			return redirect()->route('admin.widgets.index')->with('success', __('common.block_delete_success'));
		}
		return redirect()->back()->with('error', __('common.something_went_wrong'));
	}

	public function create_or_update_block(Request $request, $id = null) {
	    
	    if (empty($request->title) || empty($request->slug)) {
            return redirect()->back()->with('error', __('common.check_form_again'));	
	    }

	    $validation = [
	        'title' => 'required',
	        'slug' => 'required|unique:blogs,slug,' . $id, // Unique except for the current record if updating
	    ];
	    $validationMsg = [];

	    $this->validate($request, $validation, $validationMsg);

	    $user_id = \Auth::id();
	    $blogData = [
	        'title' => $request->title,
	        'slug' => $request->slug,
	        'user_id' => $user_id,
	        'post_type' => 'sidebars',
	        'status' => 1,
	        'publish_on' => date('Y-m-d H:i:s'),
	    ];

	    if ($id) {

	        $blog = Blog::find($id);
	        if ($blog) {
	            $blog->update($blogData);

	            $blog->blog_meta()->updateOrCreate(
	                ['title' => 'type'], 
	                ['value' => $request->type]
	            );

	            return redirect()->route('admin.widgets.index')->with('success', __('common.block_updated_successfully'));
	        } else {
	            return redirect()->back()->with('error', __('common.blog_not_found'));
	        }
	    } else {
	        $blog = Blog::create($blogData);

	        $blog_meta = [
	            'title' => 'type',
	            'value' => $request->type
	        ];
	        $blog->blog_meta()->create($blog_meta);

	        if ($blog) {
	            return redirect()->route('admin.widgets.index')->with('success', __('common.block_stored_successfully'));
	        } else {
	            return redirect()->back()->with('error', __('common.something_went_wrong'));
	        }
	    }
	}


	public function update_block(Request $request) {

		$items = json_encode($request->item_ids);
		$res = Blog::where('slug', $request->sidebar_id)->update(['content' => $items]);
	}

}
