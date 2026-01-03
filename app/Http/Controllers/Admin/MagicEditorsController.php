<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Http\Traits\DzMeSettings;
use App\Http\Traits\DzCptTrait;
use App\helper\HelpDesk;
use App\helper\DzHelper;
use Hexadog\ThemesManager\Facades\ThemesManager;
use MagicEditorElements;

class MagicEditorsController extends Controller
{
    use DzMeSettings, DzCptTrait ;

    public function __construct() {
        $this->themeSettings();
    }

    public function themeSettings() {

        $themeElementsObj = new MagicEditorElements;
        $themeElementsObj->__init();
        $this->setting_config = $themeElementsObj->setting_config;
        $this->required_widgets = $themeElementsObj->required_widgets; 
    }

    public function admin_use_me(Request $request)
    {
        $currentTheme = DzHelper::getFrontendThemeName();

        if (!empty($request->type) && $request->type == 'widgets') {
            $allElements = $this->required_widgets;
        }else{
            $allElements = $this->setting_config;
        }

		
        $allElementsCategories  = array_unique(array_column($allElements, 'category', 'base'));
		return view('admin.magic_editor.admin_use_me', compact('allElements', 'allElementsCategories'));
    }

    public function admin_edit_section(Request $request, $elementId=null) {


        $elementData = array();

        if($request->isMethod('post') && !empty($request->input('elementData')))
        {
            $elementData = $request->input('elementData');
        }
        $elementId = $request->input('elementId');
        $element_index = $request->input('element_index');
        
        $element = array();

        if(!empty($elementId))
        {
            if (!empty($request->type) && $request->type == 'widgets') {
                $allElements = $this->required_widgets;
            }else{
                $allElements = $this->setting_config;
            }
            $element = $allElements[$elementId];
            $elementTabs = array_values(array_unique(array_column($element['params'], 'group')));
        }
		
        return view('admin.magic_editor.admin_edit_section', compact('element', 'elementData', 'element_index', 'elementTabs'));
    }

    public function admin_update_element(Request $request) {


        $AllRequest = array_filter($request->except('_token'));
        $MEFieldsValue = $request->input('magic-editor');

        
        
        if (!empty($request->file('magic-editor'))) {
            foreach($request->file('magic-editor') as $imgKey => $imgValue)
            {
                $fileFullName = [];
            
                if (is_array($imgValue)) {
                    foreach ($imgValue as $key => $image) {

                        /* Multiple Image Upload */
                        if (is_array($image)) {

                            foreach ($image as $fieldName => $value) {
                                if (is_array($value)) {

                                    foreach ($value as $subFieldName => $subValue) {
                                        $fileName = $subValue->hashName();
                                        $subValue->storeAs('public/magic-editor', $fileName);
                                        $MEFieldsValue[$imgKey][$key][$fieldName][$subFieldName] = $fileName;
                                    }
                                
                                }
                                /* Single Image Upload */
                                else{
                                    $fileName = $value->hashName();
                                    $value->storeAs('public/magic-editor', $value->hashName());
                                    $MEFieldsValue[$imgKey][$key][$fieldName] = $fileName;
                                }
                                $fileFullName = $MEFieldsValue[$imgKey];
                            }

                        }
                        /* Single Image Upload */
                        else{
                            $fileName = $image->hashName();
                            $image->storeAs('public/magic-editor', $image->hashName());
                            $fileFullName = !empty($fileFullName) ? $fileFullName.','.$fileName : $fileName;
                        }

                    }

                    $fileName = $fileFullName;
                }
                else {
                    $fileName = time().'.'.$imgValue->getClientOriginalName();
                    $imgValue->storeAs('public/magic-editor', $fileName);
                }

                $request->merge([
                    'magic-editor' => array_merge($request->input('magic-editor'), [$imgKey => $fileName])
                ]);
            }
        }

        $MEFieldsValue = $request->input('magic-editor');
        
        foreach ($MEFieldsValue as $key => $value) {
            if (!empty($value['%KEY%'])) {
                unset($MEFieldsValue[$key]['%KEY%']);
            }
            if ($value === null || $value === '') {
                unset($MEFieldsValue[$key]);
            }
        }

        unset($AllRequest['magic-editor']);
        $AllRequest = array_merge($AllRequest,$MEFieldsValue);
        $result = array('data' => json_encode($AllRequest));

        echo json_encode($result);
        exit();

    }

    public function admin_remove_image(Request $request)
    {

        if($request->isMethod('post') && !empty($request->imageName) && !empty($request->allImagesName))
        {
            $imageName =  $request->imageName;
            $allImagesName = explode(',', $request->allImagesName);

            $filepath = storage_path('app/public/magic-editor/').$request->imageName;
            if (($key = array_search($imageName, $allImagesName)) !== false) {

                unset($allImagesName[$key]);
                if(\File::exists($filepath))
                {
                    \File::delete($filepath);
                }
            }
            $allImagesName = implode(',', $allImagesName);
            echo json_encode(array('status' => true, 'result' => $allImagesName));
        }
        else
        {
            echo json_encode(array('status' => false));
        }
    }

    public function get_page_content(Request $request, $page_id=null) 
    {
        $settingsElement = $editorElement = array();
        $content = Page::Where('id', $page_id)->value('content');

        if(empty($content))
        {
            echo __('Page not found.');
            exit;
        }
        
        $decodeContent = htmlspecialchars_decode($content);
                
        if(strpos($decodeContent, '<%ME%>') > 0 || strpos($decodeContent, '<%ME-EL%>') > 0)
        {
            $elementData = explode('<%ME%>', $decodeContent);
            $elementData = array_filter($elementData);

            $allElements = $this->setting_config;
            
            /* Page Section Elements Loop Start */
            foreach($elementData as $key => $elements)
            {
                $tempElement = $conditions = $fields = $contain = array();
                $elements = str_replace('"', '', rtrim(ltrim($elements, '['), ']'));
                
                $chanksEl = explode('<%ME-EL%>' , $elements);
                $totalCountChanks = count($chanksEl);
                $element_category = isset($allElements[$chanksEl[0]]['category']) ? $allElements[$chanksEl[0]]['category'] : '';                
                
                /* Elements Key Values Sepretion Start */
                for($i = 1; $i < $totalCountChanks; $i++ )
                {
                    $fields = explode("=", $chanksEl[$i]);
                    
                    if(!empty($fields[0]) && !empty($fields[1]))
                    {
                        $tempElement['base'] = $chanksEl[0];
                        if($fields[0] == 'grouped')
                        {
                            $grouped = urldecode($fields[1]);
                            $tempElement[$fields[0]][] = (array) json_decode($grouped);
                        }
                        else
                        {
                            $tempElement[$fields[0]] = $fields[1];
                        }
                    }
                }

                $settingsElement[$tempElement['base']] = $tempElement;
            }
            
            $content = $settingsElement;
            /* Page Section Elements Loop End */
            
        }
        else
        {
            $content = $decodeContent;
        }
        
        $data = array('Result'=>array(
                            'status' => true,
                            'data' => $content
                            )
                      );

        echo "<pre>".json_encode($data, JSON_PRETTY_PRINT)."<pre/>";
        exit;
    }

    public function get_all_cpt()
    {
        return Blog::WherePublishBlog(config('w3cpt.post_type'))->pluck('title', 'id')->toArray();
    }

    public function get_post_by_cpt($post_type)
    {
        return Blog::WherePublishBlog($post_type)->pluck('title', 'id')->toArray();
    }

    public function get_post_taxonomy($taxonomy)
    {
        return BlogCategory::where(['type' => $taxonomy])->pluck('title', 'id')->toArray();
    }

    public function get_post_by_category(Request $request)
    {

        $categoryId = $request->content;
        $param_name = $request->param_name;
        $resultQuery = Blog::query();

        if($categoryId) {
            $resultQuery->whereHas('blog_categories',function($query) use($categoryId){
                $query->where('blog_categories.slug', '=', $categoryId);
            });
        }
        $contentObj = $resultQuery->get();
        return view('admin.magic_editor.Elements.ajax_container', compact('contentObj','param_name'));
    }

    public function get_post_by_cpt_category(Request $request)
    {

        $fieldArray = array();
        $categoryId = $request->content;
        $param_name = $request->param_name;
        $element_id = $request->element_id;
        $elementData = $request->elementData;
        $resultQuery = \Modules\W3CPT\Entities\Blog::query();

        if($categoryId) {
            $resultQuery->whereHas('blog_categories',function($query) use($categoryId){
                $query->where('slug', '=', $categoryId)
                ->where('status', '!=', 3 );
            });
        }
        $fieldOptions = $resultQuery->pluck('title','slug')->toArray();
        $allElements = $this->setting_config;
        $element = $allElements[$element_id];
        
        
        foreach($element['params'] as $value)
        {
            if($value['param_name'] == $param_name)
            {
                $fieldArray = $value;
                break;
            }   
        }

        return view('admin.magic_editor.Elements.ajax_container', compact('fieldOptions','fieldArray','elementData','param_name'));
    }

    public function get_cpt_categories(Request $request)
    {
        $taxonomyArr = array();
        $fieldArray = array();
        $post_type = $request->content;
        $element_id = $request->element_id;
        $elementData = $request->elementData;
        $param_name = $request->param_name;
        $cpt_taxonomies = $this->getTaxonomiesByPostType($post_type);

        if ($cpt_taxonomies) {
            foreach ($cpt_taxonomies as $value) {
                $taxonomyArr[] = $value['cpt_tax_name'];
            } 
        }
        $fieldOptions = \Modules\W3CPT\Entities\BlogCategory::whereIn('type', $taxonomyArr)->pluck('title','slug');
		
		$allElements = $this->setting_config;
        $element = $allElements[$element_id];
		
		
		foreach($element['params'] as $value)
		{
			if($value['param_name'] == $param_name)
			{
				$fieldArray = $value;
				break;
			}	
		}

        return view('admin.magic_editor.Elements.ajax_container', compact('fieldOptions','fieldArray','elementData','param_name'));
    }

    public function ajax_load_more(Request $request)
    {
		$el_view = $request->ajax_view;
        
        if(config('Theme.select_theme'))
        {
            ThemesManager::set(config('Theme.select_theme'));
            $blogs = HelpDesk::elementPostsByArgs($request->all());
            if ($request->ajax()) {
                $html = view('website_builder.'.$el_view, compact('blogs'))->render();
                $hasMorePages = $blogs->currentPage() < $blogs->lastPage();

                return response()->json([
                    'html' => $html,
                    'has_more_pages' => $hasMorePages,
                ]);
            }
        }
    }

    public function add_element(Request $request)
    {
        return view('admin.magic_editor.add_element');
    }

}
