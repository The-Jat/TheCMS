<?php

namespace Modules\W3CPT\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Modules\W3CPT\Entities\Blog;
use App\Http\Traits\DzCptTrait;

class ModuleController extends Controller
{
    use ValidatesRequests, DzCptTrait;

    public $post_type;
    public $taxonomy;
    public $cptManager;

    function __construct(Request $request)
    {
        $post_type = $request->get('post_type') ? $request->get('post_type') : $request->input('post_type');
        $taxonomy = $request->get('taxonomy', Null);

        $this->post_type = $this->get_post_type_object($post_type);
        if($taxonomy != Null)
        {
            $this->taxonomy = $this->get_taxonomy_object($taxonomy);
        }

		if($this->post_type == Null && !request()->routeIs('cpt.blog_category.admin.admin_ajax_add_category'))
		{
			abort(404);
		}

		
    }
}
