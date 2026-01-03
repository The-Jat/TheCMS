<?php
namespace App\Helper;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\PageMeta;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Configuration;
use App\Models\Page;
use App\Http\Traits\DzMeSettings;
use MagicEditorElements;

class HelpDesk
{
    use DzMeSettings;
    
	public static function configuration_menu()
	{
		$allprefix = array();
		$Configuration = new Configuration;
		$allprefixarray = $Configuration->getprefix();

		return $allprefixarray;
		
	}

	public static function user_img($value='')
	{
		$user_img = config('constants.user_default_img');

		if(!empty($value) && \Storage::exists('public/user-images/'.$value))
		if($value) {
			$user_img = asset('storage/user-images/'.$value);
		}
		return $user_img;
	}

	public static function get_page_meta($page_id='', $key='')
	{
		$data = PageMeta::where('page_id', '=', $page_id)->where('title', '=', $key)->first();
		return $data;
	}

	public static function shortcodeToHtml($shortcode = NULL,$type = NULL)
	{
		$type = $type ?? 'page';

		$html = "<div class='col-lg-12 mb-2 me-element-item'><div class='icon-bx-wraper left style-1 m-b30'><div class='d-flex align-items-center'><div class='icon-lg me-2'><img src='%ELEMENTIMAGE%' alt='Image'></div><h4 class='dz-title m-b15'><span>%ELEMENTNAME%</span></h4></div><div class='icon-content'><a href='javascript:void(0);' class='drag-handle btn btn-primary shadow btn-xs sharp me-1'><i class='fas fa-arrows-alt'></i></a><a href='javascript:void(0);' class='Me-EditElement btn btn-primary shadow btn-xs sharp me-1' data-element-type='".$type."' elementId='%ELEMENTID%' element-form-data='%ELEMENTFORMDATA%'><i class='fas fa-pencil-alt'></i></a><a href='javascript:void(0);' elementId='%ELEMENTID%' class='ME-DeleteElement btn btn-primary shadow btn-xs sharp me-1'><i class='fa fa-times'></i></a></div></div></div>";
		
		$elementsObj = new MagicEditorElements;
        $elementsObj->__init();
        if ($type == 'widgets') {
            $allElements = $elementsObj->required_widgets;
        }
        else {
            $allElements = $elementsObj->setting_config;
        }

		$tempElement = array();
		$section = '';
		$decodeContent = htmlspecialchars_decode($shortcode);
		
				
		if(strpos($decodeContent, '<%ME%>') > 0 || strpos($decodeContent, '<%ME-EL%>') > 0)
		{
			$shortcode = explode('<%ME%>', $decodeContent);
			foreach($shortcode as $elements)
			{

				$elements = rtrim(ltrim($elements, '['), ']');
				$chanksEl = explode('<%ME-EL%>' , $elements);
				$totalCountChanks = count($chanksEl);
				$tempElement = array();
				for($i = 1; $i < $totalCountChanks; $i++ )
				{
					$fields = explode("=", $chanksEl[$i], 2);
					$fieldsValue = trim($fields[1],'"');

					$tempElement['element_id'] = $chanksEl[0];
					
					if(!empty($fieldsValue) && is_object(json_decode($fieldsValue)))
					{
						$tempElement[$fields[0]][] = json_decode($fieldsValue,true);
					}
					else
					{
						if(isset($fieldsValue))
						{
							$tempElement[$fields[0]] = $fieldsValue;
						}
					}
				}
				$formdata = json_encode($tempElement, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );
				
				if(isset($allElements[$chanksEl[0]]))
				{
					$element = $allElements[$chanksEl[0]];
					$section .= str_replace(array('%ELEMENTNAME%', '%ELEMENTID%', '%ELEMENTIMAGE%', '%ELEMENTFORMDATA%'), array($element['name'], $element['base'], $element['icon'], $formdata), $html);
				}
				
			}
		}
		else
		{
			$section .= $decodeContent;
		}

		return $section;
	}

	public static function shortcodeContent($shortcode = NULL,$type=null)
	{

		$settingsElement = array();
        $currentTheme = config('Theme.select_theme') ? explode("/",config('Theme.select_theme'))[1] : '' ;
        $content = $shortcode;

        if(empty($content))
        {
            return __('Content not found.');
        }
        
        $decodeContent = htmlspecialchars_decode($content);

        if(strpos($decodeContent, '<%ME%>') > 0 || strpos($decodeContent, '<%ME-EL%>') > 0)
        {
            $elementData = explode('<%ME%>', $decodeContent);
            $elementData = array_filter($elementData);

           	$elementsObj = new MagicEditorElements;
	        $elementsObj->__init();
			$allElements = $elementsObj->setting_config;
            
            /* Page Section Elements Loop Start */
            foreach($elementData as $key => $elements)
            {
                $tempElement = $conditions = $fields = $contain = array();
                $elements = rtrim(ltrim($elements, '['), ']');
                $chanksEl = explode('<%ME-EL%>' , $elements);
                $totalCountChanks = count($chanksEl);
                
                /* Elements Key Values Sepretion Start */
                for($i = 1; $i < $totalCountChanks; $i++ )
                {

                    $fields = explode("=", $chanksEl[$i], 2);
					$fieldsValue = trim($fields[1],'"');
                    
                    if(!empty($fields[0]) && !empty($fieldsValue))
                    {
                        $tempElement['base'] = $chanksEl[0];
						
                        if(!empty($fieldsValue) && is_object(json_decode(urldecode($fieldsValue))))
						{
							$tempElement[$fields[0]][] = array_map('urldecode', json_decode(urldecode($fieldsValue), true));
						}
                        else
                        {
                            $tempElement[$fields[0]] = urldecode($fieldsValue);
                        }
                    }
                }

                if(empty($tempElement))
                {
                	$tempElement['base'] = $chanksEl[0];
                }

                $original = $tempElement['base'];
	            $count = 2;

	            while (array_key_exists($tempElement['base'], $settingsElement)) {
	                $tempElement['base'] = "{$original}-" . $count++;
	            }

                $settingsElement[$tempElement['base']] = $tempElement;

            }
            /* Page Section Elements Loop End */
            
            $content = $settingsElement;
            
        }
        else
        {
            $content = $decodeContent;
        }

        if(!empty($content) && is_array($content)){
	        foreach($content as $element_id => $args){
	        	$elName = explode('-', $element_id);
	        	if ($type == 'widget') {
	        		$view = 'w3elements.widgets.'.$elName[0];
	        	}else{
	        		$view = 'w3elements.pages.'.$elName[0];
	        	}

	        	if (view()->exists($view)) {
	        		echo view($view, compact('args'))->render();
	        	}else {
	        		echo '<p class="py-3">The Element('.$elName[0].') can not be Supported, Please go to Editor and Check the elements.<p>';
	        	}
	        }
    	}
    	else {
    		return $content;
    	}
	}

	public static function elementPostsByArgs($args = NULL)
	{

		$post_type = isset($args['post_type']) ? $args['post_type'] : config('blog.post_type');
		$limit = isset($args['no_of_posts']) ? $args['no_of_posts'] : config('Reading.nodes_per_page');
        $categories = isset($args['post_categories']) ? $args['post_categories'] : '';
        $categoryArray = explode(',', $categories);
        $categoryArray = array_values(array_filter($categoryArray));
        $post_with_images = isset($args['post_with_images']) ? true : false;
        $order = isset($args['order']) ? $args['order'] : 'DESC';
        $orderBy = isset($args['orderby']) ? $args['orderby'] : 'rand';
        $pagination = $args['pagination'] ?? false;

        if ($post_type == config('blog.post_type')) {
        	$resultQuery = Blog::query();
        }else{
        	$resultQuery = \Modules\W3CPT\Entities\Blog::query();
        }

	    if ($post_with_images) {
	    	$resultQuery->whereHas('blog_meta', function($query) {
	                $query->where('title', '=', 'ximage')->where('value', '!=', Null);
	            });
	    }

        $resultQuery->with('blog_seo', 'blog_categories', 'blog_tags', 'user')->where('status', '1')->where('post_type', '=', $post_type);


        if ($post_type == config('blog.post_type')) {
	        $resultQuery->withCount(['blog_comments' => function($query) {
	            $query->where('approve', '1');
	        }]);
	    }

        if (!empty(array_filter($categoryArray))) {
            $resultQuery->whereHas('blog_categories',function($query) use($categoryArray,$post_type){

        		if ($post_type == config('blog.post_type')) {
                	$query->whereIn('blog_categories.slug', $categoryArray);
                }else{
                	$query->whereIn('slug', $categoryArray);
                }
            });
        }

        if ($order == 'RAND' || $orderBy == 'rand') {
            $resultQuery->inRandomOrder();
        }else {
        	$resultQuery->orderBy($orderBy, $order);
        }
        
        return $blogs = $resultQuery->paginate($limit);
        
	}

	public static function elementPagesByArgs($args = NULL)
	{
		
            
        $pages = isset($args['page_ids']) ? $args['page_ids'] : '';
        $pageArray = explode(',', $pages);
        $pageArray = array_values(array_filter($pageArray));
        $page_with_images = isset($args['page_with_images']) ? true : false;
        $limit = isset($args['No_of_pages']) ? $args['No_of_pages'] : config('Reading.nodes_per_page');
        $order = isset($args['order']) ? $args['order'] : 'DESC';
        $orderBy = isset($args['orderby']) ? $args['orderby'] : 'rand';


        $resultQuery = Page::query();
        
        if ($page_with_images) {
	    	$resultQuery->whereHas('page_metas', function($query) {
	                $query->where('title', '=', 'ximage')->where('value', '!=', Null);
	            });
	    }

        if ($order == 'RAND' || $orderBy == 'rand') {
            $resultQuery->inRandomOrder();
        }else {
        	$resultQuery->orderBy($orderBy, $order);
        }

        return $pages = $resultQuery->paginate($limit);
	}

	public static function elementCategoriesByArgs($args = NULL)
	{
        
        $limit = isset($args['no_of_category']) ? $args['no_of_category'] : '6';
        $hierarchy = isset($args['hierarchy']) ? true : '';
        $order = isset($args['order']) ? $args['order'] : 'DESC';
        $orderBy = isset($args['orderby']) ? $args['orderby'] : 'rand';
        $category_with_images = isset($args['category_with_images']) ? true : false;
        $category_ids = isset($args['category_ids']) ? $args['category_ids'] : '';
        $categoryArray = explode(',', $category_ids);
        $categoryArray = array_values(array_filter($categoryArray));

        $resultQuery = BlogCategory::query();

	    if ($category_with_images) {
	    	$resultQuery->where('image', '!=', Null);
	    }

        if (!empty(array_filter($categoryArray))) {
            $resultQuery->whereIn('slug', $categoryArray);
        }
        
        if ($order == 'RAND' || $orderBy == 'rand') {
            $resultQuery->inRandomOrder();
        }
        else {
        	$resultQuery->orderBy($orderBy, $order);
        }

        return $categories = $resultQuery->paginate($limit);
	}

	public static function getPostMeta($blog_id, $key)
	{
		$blogObj = new Blog();
		return $blogObj->getBlogMeta($blog_id, $key);
	}

	public static function getCptPostsBySlug($slugs = NULL)
	{
		if ($slugs) {
			
			$slugArr = explode(',', $slugs);
			$slugArr = array_values(array_filter($slugArr));

			$resultQuery = \Modules\W3CPT\Entities\Blog::query();

			if (!empty(array_filter($slugArr))) {
	            $resultQuery->whereIn('slug', $slugArr);
	        }

			return $blogs = $resultQuery->get();
		}
		return array();
	}

	public static function getCptPostsByCategory($categoryIds = NULL,$post_type=null)
	{
		if ($categoryIds) {
			
			$catArr = explode(',', $categoryIds);
			$catArr = array_values(array_filter($catArr));

			$resultQuery = \Modules\W3CPT\Entities\Blog::query();

			if ($post_type) {
				$resultQuery->where('post_type',$post_type);
			}

			if (!empty(array_filter($catArr))) {
	            $resultQuery->whereHas('blog_categories',function($query) use($catArr){
					$query->whereIn('slug', $catArr)
					->where('status', '!=', 3 );
				});
	        }

			return $blogs = $resultQuery->get();
		}
		return array();
	}
}