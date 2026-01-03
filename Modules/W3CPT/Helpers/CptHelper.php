<?php

namespace Modules\W3CPT\Helpers;

use Modules\W3CPT\Entities\BlogCategory;
use Modules\W3CPT\Entities\Blog;
use App\Http\Traits\DzCptTrait;
use Exception;

class CptHelper
{

    public static function register_nav_menus()
    {
        $menus = (new Blog)->getAllCpt();
        return view('w3cpt::admin.w3cpt_menus.sidebar', compact('menus'));
    }

    public static function get_post_types($args=array())
    {
        return (new DzCptTrait)->get_post_types($args);
    }

    public static function cpt_categories_box($post_type=Null, $screenOption=array(), $blogCatArr=array())
    {
        $blogCategoryObj                = new BlogCategory();
        $blogCategoryObj->post_type     = $post_type;
        $categories                     = $blogCategoryObj->getCategoriesCheckboxByCpt($post_type);
        return view('w3cpt::admin.blogs.categories_box', compact('categories', 'blogCategoryObj', 'screenOption', 'post_type', 'blogCatArr'));
    }


}
