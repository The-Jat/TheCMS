<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogBlogCategory;
use App\Models\BlogTag;
use App\Models\BlogBlogTag;
use App\Models\BlogMeta;
use App\Models\BlogSeo;
use App\Models\Page;
use App\Models\PageMeta;
use App\Models\PageSeo;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Configuration;
use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\CustomFieldType;
use Modules\CustomField\Entities\CustomMeta;
use Modules\W3CPT\Entities\Blog as W3cptBlog;
use Modules\W3CPT\Entities\BlogCategory as W3cptBlogCategory;
use Modules\W3CPT\Entities\TermRelationship;
use Modules\W3CPT\Entities\BlogTag as W3cptBlogTag;
use Modules\W3CPT\Entities\BlogBlogTag as W3cptBlogBlogTag;
use Modules\W3CPT\Entities\BlogMeta as W3cptBlogMeta;
use Modules\W3CPT\Entities\BlogSeo as W3cptBlogSeo;
use App\Helper\DzHelper;
use XMLWriter;

trait DzImportTrait {

    public function importData($xml, $user_id) {

        /*================ Get data from saved xml file and Save to database ================*/

        if(!empty($xml->configurations)){
            $config = New Configuration();
            foreach($xml->configurations->configurations as $configurationsXml) {
                $key = (string)$configurationsXml->name;
                $value = (string)$configurationsXml->value;
                if (str_contains($value, 'http')) {
                    $content = DzHelper::extractImagesFromContent($value);
                    $value = $content;
                }
                $config->saveConfig($key, $value);
            }

        } 

        if (isset($xml->pages->pages)) {

            function checkAndInsertPage(&$pageXml, $parent_id=Null, $user_id, &$xml)  {

                $pageJson = json_decode(json_encode($pageXml), TRUE);
                $content = DzHelper::extractImagesFromContent($pageJson['content']);

                $pageJson['content'] = $content;
                $pageJson['user_id'] = $user_id;
                $pageJson['parent_id'] = $parent_id;
                $page = Page::create($pageJson);
                $pageNewId = $page->id;

                if ($pageXml->children->children) {
                    checkAndInsertPage($pageXml->children->children, $pageNewId, $user_id, $xml);
                }

                /*========== For replace page item_id in MenuItems ==========*/
                if (isset($xml->menus->menus)) {
                    foreach ($xml->menus->menus as $menuXml) {
                        foreach ($menuXml->menu_items->menu_items as $item) {
                            if ((string)$item->type == 'Page' && (int)$pageXml->id == (int) $item->item_id) {
                                $item->item_id = $page->id;
                            }
                        }
                    }
                }

                /*========== For replace page item_id in MenuItems ==========*/

                if (isset($pageXml->page_metas->page_metas)) {
                    foreach($pageXml->page_metas->page_metas as $page_meta) {

                        $pageMetaJson = json_decode(json_encode($page_meta), TRUE);
                        
                        if (!empty($pageMetaJson['value'])) {

                            if ($pageMetaJson['title'] == 'w3_page_options') {
                                $content = DzHelper::extractImagesFromContent($pageMetaJson['value']);
                                $pageMetaJson['value'] = $content;
                            }
                            else if(str_contains($pageMetaJson['value'], 'http')) {
                                $pageMetaJson['value'] = DzHelper::downloadAndSaveImage($pageMetaJson['value']);
                            }
                        }

                        $pageMetaJson['page_id'] = $page->id;
                        $pageMeta = PageMeta::create($pageMetaJson);
                    }
                }

                if (isset($pageXml->page_seo->id)) {

                    $pageSeoJson = json_decode(json_encode($pageXml->page_seo), TRUE);
                    $pageSeoJson['page_id'] = $page->id;
                    $pageSeo = PageSeo::create($pageSeoJson);
                }

                /*========== For create Custom Fields of Pages If exist  ==========*/
                if (isset($pageXml->custom_fields->custom_fields)) {

                    foreach($pageXml->custom_fields->custom_fields as $custom_field) {
                        
                        if (!CustomField::where('key',$custom_field->key)->exists()) {

                            $customFieldJson = json_decode(json_encode($custom_field), TRUE);
                            $customField = CustomField::create($customFieldJson);
                            $customFieldId = $customField->id;
                            $customFieldOldId = $custom_field->id;

                            foreach ($xml->pages->pages as $allPages) {
                                foreach ($allPages->custom_fields->custom_fields as $CustomField) {
                                    if ((int) $CustomField->parent_id == (int)$customFieldOldId) {
                                        $CustomField->parent_id = $customFieldId;
                                    }
                                }
                            }

                        }
                        else {
                            $customFieldId = CustomField::where('key',$custom_field->key)->first()->id;
                        }

                        if (!CustomFieldType::where('custom_field_id',$customFieldId)->where('custom_field_type','pages')->exists()) {
                            
                            $customFieldTypeId = CustomFieldType::create([
                                'custom_field_id' => $customFieldId,
                                'custom_field_type'  => 'pages',
                            ])->id;
                        }else{
                            $customFieldTypeId = CustomFieldType::where('custom_field_id',$customFieldId)->where('custom_field_type','pages')->first()->id;
                        }

                        $custom_meta = json_decode(json_encode($custom_field->custom_metas), TRUE);

                        if(str_contains(@$custom_meta['value'], 'http')) {
                            $custom_meta['value'] = DzHelper::extractImagesFromContent($custom_meta['value']);
                        }

                        if (isset($custom_meta['value'])) {
                            $customMeta = CustomMeta::create([
                                'object_id' => $page->id,
                                'custom_field_type_id' => $customFieldTypeId,
                                'custom_field_id' => $customFieldId,
                                'value'  => @$custom_meta['value'],
                            ]);
                        }
                        
                    }
                }
            }

            foreach($xml->pages->pages as $pageXml) {

                checkAndInsertPage($pageXml, (int)$pageXml->parent_id, $user_id, $xml);
            }

        }

        if (isset($xml->blogs->blogs)) {

            $this->insertBlog($xml->blogs->blogs, $user_id, $xml);
        }

        if (isset($xml->w3cpt_blogs->w3cpt_blogs, $user_id)) {

            $this->insertW3cptBlog($xml->w3cpt_blogs->w3cpt_blogs, $user_id, $xml);
        }

        if (isset($xml->menus->menus)) {
            
            $menusLocations = config('Site.menu_location') ? unserialize(config('Site.menu_location')) : config('menu.menu_location');
            
            foreach($xml->menus->menus as $menuXml) {

                $menuJson = json_decode(json_encode($menuXml), TRUE);
                $menuJson['user_id'] = $user_id;
                $menu = Menu::create($menuJson);

                /*========== save menuId in Configuration for menu Locations =======*/

                foreach($menusLocations as $location => $value)
                {
                    if($menu->slug == 'primary-menu' && $menusLocations[$location]['title'] == 'Desktop Horizontal Menu'){
                        
                        $menusLocations[$location]['menu'] = $menu->id;
                    
                    }else if($menu->slug == 'footer-menu' && $menusLocations[$location]['title'] == 'Footer Menu'){
                        
                        $menusLocations[$location]['menu'] = $menu->id;
                    
                    }else if($menu->slug == 'secodary-menu' && $menusLocations[$location]['title'] == 'Desktop Expanded Menu'){
                        
                        $menusLocations[$location]['menu'] = $menu->id;
                    }
                }

                $menuLocationArr = serialize($menusLocations);
                $config = New Configuration();
                $config->saveConfig('Site.menu_location', $menuLocationArr);

                /* Configuration Export & Import also required.  */
                
                /*========== save menuId in Configuration for menu Locations =======*/

                if ($menuXml->menu_items->menu_items) {

                    $map_old_parent = [];
                    foreach($menuXml->menu_items->menu_items as $menu_item) {

                        $menuItemJson = json_decode(json_encode($menu_item), TRUE);
                        $menuItemJson['menu_id'] = $menu->id;
                        $menuItem = MenuItem::create($menuItemJson);
                        $newId = $menuItem->id;
                        $oldId = (int) $menu_item->id;
                        $map_old_parent[$oldId] = $newId;
                        
                        foreach ($menuXml->menu_items->menu_items as $item) {
                            if ((int) $item->parent_id == $oldId) {
                                $item->parent_id = $newId;
                            }
                        }
                    }
                    foreach ($map_old_parent as $oldId => $newId) {
                        MenuItem::where('parent_id', $oldId)
                            ->update(['parent_id' => $newId]);
                    }
                }
            }
        }
        /*================ Get data from saved xml file and Save to database ================*/

        return __('common.data_import_success');
    }

    private function insertBlog($blogs, $user_id, $xml)
    {
        foreach($blogs as $blogXml) {

            /*========== Check Xml Blog by slug in Database ==========*/
                
            /*========== Save Blog to database ==========*/
            $blogJson = json_decode(json_encode($blogXml), TRUE);
            $blogJson['user_id'] = $user_id;
            $blog = Blog::create($blogJson);
            /*========== Save Blog to database ==========*/

            /*========== For replace blog id to item_id in MenuItems ==========*/
            if (isset($xml->menus->menus)) {
                foreach ($xml->menus->menus as $menuXml) {
                    foreach ($menuXml->menu_items->menu_items as $item) {
                        if ((string) $item->type == 'Post' && (int)$blogXml->id == (int) $item->item_id) {
                            $item->item_id = $blog->id;
                        }
                    }
                }
            }
            /*========== For replace blog id to item_id in MenuItems ==========*/

            /*========== For create BlogMeta If exist ==========*/
            if (isset($blogXml->blog_meta->blog_meta)) {
                foreach($blogXml->blog_meta->blog_meta as $blog_meta) {
                    
                    $blogMetaJson = json_decode(json_encode($blog_meta), TRUE);
                    $blogMetaJson['blog_id'] = $blog->id;

                    if (!empty($blogMetaJson['value'])) {

                        if ($blogMetaJson['title'] == 'w3_blog_options') {
                            $content = DzHelper::extractImagesFromContent($blogMetaJson['value']);
                            $blogMetaJson['value'] = $content;
                        }
                        else if(str_contains($blogMetaJson['value'], 'http')) {
                            $blogMetaJson['value'] = DzHelper::downloadAndSaveImage($blogMetaJson['value']);
                        }
                    }

                    $blogMeta = BlogMeta::create($blogMetaJson);
                }
            }
            /*========== For create BlogMeta If exist ==========*/

            /*========== For create BlogSeo If exist ==========*/
            if (isset($blogXml->blog_seo->id)) {

                $blogSeoJson = json_decode(json_encode($blogXml->blog_seo), TRUE);
                $blogSeoJson['blog_id'] = $blog->id;
                $blogSeo = BlogSeo::create($blogSeoJson);
            }
            /*========== For create BlogSeo If exist ==========*/

            /*========== For create BlogCategory If exist ==========*/
            if (isset($blogXml->blog_categories->blog_categories)) {

                foreach($blogXml->blog_categories->blog_categories as $blog_category) {
                    
                    if (!BlogCategory::whereSlug($blog_category->slug)->exists()) {

                        $blogCategoryJson = json_decode(json_encode($blog_category), TRUE);

                        if (!empty($blogCategoryJson['image']) && str_contains($blogCategoryJson['image'], 'http')) {
                            $blogCategoryJson['image'] = DzHelper::downloadAndSaveImage($blogCategoryJson['image']);
                        }
                        $blogCategoryJson['user_id'] = $user_id;
                        $blogCategory = BlogCategory::create($blogCategoryJson);
                        $categoryId = $blogCategory->id;
                        $categoryOldId = $blog_category->id;

                        foreach ($xml->blogs->blogs as $allBlogs) {
                            foreach ($allBlogs->blog_categories->blog_categories as $category) {
                                if ((int) $category->parent_id == (int)$categoryOldId) {
                                    $category->parent_id = $categoryId;
                                }
                            }
                        }

                        if (isset($xml->menus->menus)) {
                            foreach ($xml->menus->menus as $menuXml) {
                                foreach ($menuXml->menu_items->menu_items as $item) {
                                    if ((string)$item->type == 'Category' && ((int)$categoryOldId == (int) $item->item_id)) {
                                        $item->item_id = $categoryId;
                                    }
                                }
                            }
                        }
                    }
                    else {
                        if (isset($blog_category->image) && !empty($blog_category->image)) {
                            $category = BlogCategory::whereSlug($blog_category->slug)->update(['image' => DzHelper::downloadAndSaveImage($blog_category->image)]);
                        }
                        $categoryId = BlogCategory::whereSlug($blog_category->slug)->first()->id;
                    }
                    
                    foreach($blog_category->pivot as $pivot) {
                        $blogBlogCategory = BlogBlogCategory::create([
                            'blog_id'           => $blog->id,
                            'blog_category_id'  => $categoryId,
                        ]);
                    }
                }
            }
            /*========== For create Custom Fields of Blogs If exist  ==========*/
            if (isset($blogXml->custom_fields->custom_fields)) {

                foreach($blogXml->custom_fields->custom_fields as $custom_field) {
                    
                    if (!CustomField::where('key',$custom_field->key)->exists()) {

                        $customFieldJson = json_decode(json_encode($custom_field), TRUE);
                        $customField = CustomField::create($customFieldJson);
                        $customFieldId = $customField->id;
                        $customFieldOldId = $custom_field->id;

                        foreach ($xml->blogs->blogs as $allBlogs) {
                            foreach ($allBlogs->custom_fields->custom_fields as $CustomField) {
                                if ((int) $CustomField->parent_id == (int)$customFieldOldId) {
                                    $CustomField->parent_id = $customFieldId;
                                }
                            }
                        }

                    }
                    else {
                        $customFieldId = CustomField::where('key',$custom_field->key)->first()->id;
                    }

                    if (!CustomFieldType::where('custom_field_id',$customFieldId)->where('custom_field_type','blogs')->exists()) {
                        
                        $customFieldTypeId = CustomFieldType::create([
                            'custom_field_id' => $customFieldId,
                            'custom_field_type'  => 'blogs',
                        ])->id;
                    }else{
                        $customFieldTypeId = CustomFieldType::where('custom_field_id',$customFieldId)->where('custom_field_type','blogs')->first()->id;
                    }

                    $custom_meta = json_decode(json_encode($custom_field->custom_metas), TRUE);
                    
                    if(str_contains(@$custom_meta['value'], 'http')) {
                        $custom_meta['value'] = DzHelper::extractImagesFromContent($custom_meta['value']);
                    }

                    if (isset($custom_meta['value'])) {
                        $customMeta = CustomMeta::create([
                            'object_id' => $blog->id,
                            'custom_field_type_id' => $customFieldTypeId,
                            'custom_field_id' => $customFieldId,
                            'value'  => @$custom_meta['value'],
                        ]);
                    }
                    
                }
            }

            if (isset($blogXml->blog_tags->blog_tags)) {

                foreach($blogXml->blog_tags->blog_tags as $blog_tag) {

                    if (!BlogTag::whereSlug($blog_tag->slug)->exists()) {

                        $blogTagJson = json_decode(json_encode($blog_tag), TRUE);
                        $blogTagJson['user_id'] = $user_id;
                        $blogTag = BlogTag::create($blogTagJson);
                        $tagId = $blogTag->id;
                        $tagOldId = $blog_tag->id;

                        if (isset($xml->menus->menus)) {
                            foreach ($xml->menus->menus as $menuXml) {
                                foreach ($menuXml->menu_items->menu_items as $item) {
                                    if ((string)$item->type == 'Tag' && ((int)$tagOldId == (int) $item->item_id)) {
                                        $item->item_id = $tagId;
                                    }
                                }
                            }
                        }
                    }
                    else {
                        $tagId = BlogTag::whereSlug($blog_tag->slug)->first()->id;
                    }
                        
                    foreach($blog_tag->pivot as $pivot) {
                        $blogBlogTag = BlogBlogTag::create([
                            'blog_id'       => $blog->id,
                            'blog_tag_id'   => $tagId,
                        ]);
                    }
                }
            }
        }
    }

    private function insertW3cptBlog($blogs, $user_id, $xml)
    {
        foreach($blogs as $blogXml) {

            /*========== Check Xml Blog by slug in Database ==========*/
                
            /*========== Save Blog to database ==========*/
            $blogJson = json_decode(json_encode($blogXml), TRUE);
            $blogJson['user_id'] = $user_id;
            $blogJson['content'] = !empty($blogJson['content']) ? DzHelper::extractImagesFromContent($blogJson['content']) : null;
            $blog = W3cptBlog::create($blogJson);
            /*========== Save Blog to database ==========*/

            /*========== For replace blog id to item_id in MenuItems ==========*/
            if (isset($xml->menus->menus)) {
                foreach ($xml->menus->menus as $menuXml) {
                    foreach ($menuXml->menu_items->menu_items as $item) {
                        if ((string) $item->type == $blog->post_type && (int)$blogXml->id == (int) $item->item_id) {
                            $item->item_id = $blog->id;
                        }
                    }
                }
            }
            /*========== For replace blog id to item_id in MenuItems ==========*/

            /*========== For create BlogMeta If exist ==========*/
            if (isset($blogXml->blog_meta->blog_meta)) {
                foreach($blogXml->blog_meta->blog_meta as $blog_meta) {
                    
                    $blogMetaJson = json_decode(json_encode($blog_meta), TRUE);
                    if (!empty($blogMetaJson['value'])) {

                            if ($blogMetaJson['title'] == 'w3_blog_options') {
                                $content = DzHelper::extractImagesFromContent($blogMetaJson['value']);
                                $blogMetaJson['value'] = $content;
                            }
                            else if(str_contains($blogMetaJson['value'], 'http')) {
                                $blogMetaJson['value'] = DzHelper::downloadAndSaveImage($blogMetaJson['value']);
                            }
                        }
                    $blogMetaJson['blog_id'] = $blog->id;
                    $blogMeta = W3cptBlogMeta::create($blogMetaJson);
                }
            }
            /*========== For create BlogMeta If exist ==========*/

            /*========== For create BlogSeo If exist ==========*/
            if (isset($blogXml->blog_seo->id)) {

                $blogSeoJson = json_decode(json_encode($blogXml->blog_seo), TRUE);
                $blogSeoJson['blog_id'] = $blog->id;
                $blogSeo = W3cptBlogSeo::create($blogSeoJson);
            }
            /*========== For create BlogSeo If exist ==========*/

            /*========== For create BlogCategory If exist ==========*/
            if (isset($blogXml->blog_categories->blog_categories)) {

                foreach($blogXml->blog_categories->blog_categories as $blog_category) {
                    
                    if (!W3cptBlogCategory::whereSlug($blog_category->slug)->exists()) {

                        $blogCategoryJson = json_decode(json_encode($blog_category), TRUE);
                        $blogCategoryJson['user_id'] = $user_id;
                        $blogCategory = W3cptBlogCategory::create($blogCategoryJson);
                        $categoryId = $blogCategory->id;
                        $categoryOldId = $blog_category->id;

                        foreach ($xml->blogs->blogs as $allBlogs) {
                            foreach ($allBlogs->blog_categories->blog_categories as $category) {
                                if ((int) $category->parent_id == (int)$categoryOldId) {
                                    $category->parent_id = $categoryId;
                                }
                            }
                        }

                        if (isset($xml->menus->menus)) {
                            foreach ($xml->menus->menus as $menuXml) {
                                foreach ($menuXml->menu_items->menu_items as $item) {
                                    if ((string)$item->type == 'Category' && ((int)$categoryOldId == (int) $item->item_id)) {
                                        $item->item_id = $categoryId;
                                    }
                                }
                            }
                        }
                    }
                    else {
                        if (isset($blog_category->image) && !empty($blog_category->image)) {
                            $category = W3cptBlogCategory::whereSlug($blog_category->slug)->update(['image' => DzHelper::downloadAndSaveImage($blog_category->image)]);
                        }
                        $categoryId = W3cptBlogCategory::whereSlug($blog_category->slug)->first()->id;
                    }
                    
                    foreach($blog_category->pivot as $pivot) {
                        $blogBlogCategory = TermRelationship::create([
                            'object_id' => $blog->id,
                            'term_id'   => $categoryId,
                        ]);
                    }
                }
            }

            /*========== For create Custom Fields of CPTs If exist  ==========*/
            if (isset($blogXml->custom_fields->custom_fields)) {

                foreach($blogXml->custom_fields->custom_fields as $custom_field) {
                    
                    if (!CustomField::where('key',$custom_field->key)->exists()) {

                        $customFieldJson = json_decode(json_encode($custom_field), TRUE);
                        $customField = CustomField::create($customFieldJson);
                        $customFieldId = $customField->id;
                        $customFieldOldId = $custom_field->id;

                        foreach ($xml->blogs->blogs as $allBlogs) {
                            foreach ($allBlogs->custom_fields->custom_fields as $CustomField) {
                                if ((int) $CustomField->parent_id == (int)$customFieldOldId) {
                                    $CustomField->parent_id = $customFieldId;
                                }
                            }
                        }

                    }
                    else {
                        $customFieldId = CustomField::where('key',$custom_field->key)->first()->id;
                    }

                    if (!CustomFieldType::where('custom_field_id',$customFieldId)->where('custom_field_type','cpt_'.$blog->post_type)->exists()) {
                        
                        $customFieldTypeId = CustomFieldType::create([
                            'custom_field_id' => $customFieldId,
                            'custom_field_type'  => 'cpt_'.$blog->post_type,
                        ])->id;
                    }else{
                        $customFieldTypeId = CustomFieldType::where('custom_field_id',$customFieldId)->where('custom_field_type','cpt_'.$blog->post_type)->first()->id;
                    }

                    $custom_meta = json_decode(json_encode($custom_field->custom_metas), TRUE);

                    if(str_contains(@$custom_meta['value'], 'http')) {
                        $custom_meta['value'] = DzHelper::extractImagesFromContent($custom_meta['value']);
                    }
                        
                    if (isset($custom_meta['value'])) {
                        $customMeta = CustomMeta::create([
                            'object_id' => $blog->id,
                            'custom_field_type_id' => $customFieldTypeId,
                            'custom_field_id' => $customFieldId,
                            'value'  => @$custom_meta['value'],
                        ]);
                    }
                    
                }
            }

            if (isset($blogXml->blog_tags->blog_tags)) {

                foreach($blogXml->blog_tags->blog_tags as $blog_tag) {

                    if (!W3cptBlogTag::whereSlug($blog_tag->slug)->exists()) {

                        $blogTagJson = json_decode(json_encode($blog_tag), TRUE);
                        $blogTagJson['user_id'] = $user_id;
                        $blogTag = W3cptBlogTag::create($blogTagJson);
                        $tagId = $blogTag->id;
                        $tagOldId = $blog_tag->id;

                        if (isset($xml->menus->menus)) {
                            foreach ($xml->menus->menus as $menuXml) {
                                foreach ($menuXml->menu_items->menu_items as $item) {
                                    if ((string)$item->type == 'Tag' && ((int)$tagOldId == (int) $item->item_id)) {
                                        $item->item_id = $tagId;
                                    }
                                }
                            }
                        }
                    }
                    else {
                        $tagId = W3cptBlogTag::whereSlug($blog_tag->slug)->first()->id;
                    }
                        
                    foreach($blog_tag->pivot as $pivot) {
                        $blogBlogTag = W3cptBlogBlogTag::create([
                            'blog_id'       => $blog->id,
                            'blog_tag_id'   => $tagId,
                        ]);
                    }
                }
            }
        }
    }

    public function exportData($request, $filename)
    {
        
        $directory   = storage_path('app/public/system-export-data/');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        if ($request->content == 'all_content') {
            $content['w3cms']['blogs'] = Blog::where('post_type', '=', config('blog.post_type'))->with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'custom_fields')->orderBy('created_at', 'asc')->get()->toArray();

            $content['w3cms']['pages'] = Page::with('page_metas', 'page_seo', 'children', 'custom_fields')->orderBy('created_at', 'asc')->get()->toArray();

            $content['w3cms']['menus'] = Menu::with('menu_items')->orderBy('created_at', 'asc')->get()->toArray();
            $content['w3cms']['w3cpt_blogs'] = W3cptBlog::where('post_type', '!=', config('blog.post_type'))->with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'custom_fields')->orderBy('created_at', 'asc')->get()->toArray();
        }
        elseif ($request->content == 'posts') {
            $resultQuery = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags')->orderBy('created_at', 'asc');
            
            if($request->filled('start_date') && $request->filled('end_date')) {
                $resultQuery->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
            }
            if($request->category_id != 0) {
                $resultQuery->whereHas('blog_categories',function($query) use($request){
                    $query->where('blog_categories.id', '=', $request->input('category_id'));
                });
            }
            if($request->post_user_id != 0) {
                $resultQuery->where('user_id', '=', $request->input('post_user_id'));
            }
            if($request->post_status != 0) {
                $resultQuery->where('status', '=', $request->input('post_status'));
            }
            
            $content['w3cms']['blogs'] = $resultQuery->get()->toArray();
        }
        elseif ($request->content == 'pages') {
            $resultQuery = Page::with('page_metas', 'page_seo')->orderBy('created_at', 'asc');
            
            if($request->filled('page_start_date') && $request->filled('page_end_date')) {
                $resultQuery->whereBetween('created_at', [$request->input('page_start_date'), $request->input('page_end_date')]);
            }
            if($request->page_user_id != 0) {
                $resultQuery->where('user_id', '=', $request->page_user_id);
            }
            if($request->page_status != 0) {
                $resultQuery->where('status', '=', $request->page_status);
            }

            $content['w3cms']['pages'] = $resultQuery->get()->toArray();
        }
        elseif ($request->content == 'menus') {
            $content['w3cms']['menus'] = Menu::with('menu_items')->orderBy('created_at', 'asc')->get()->toArray();
        }

        try {

            $xml = new XMLWriter();
            $xml->openURI($directory.$filename);
            $xml->startDocument('1.0', 'UTF-8');
            $startText = "<!--  This is a .xss file generated by w3cms as an export of your site.  -->
<!--  It contains information about your site's posts, pages, categories, menus and other content.  -->
<!--  You may use this file to transfer that content from one site to another.  -->
<!--  This file is not intended to serve as a complete backup of your site.  -->
<!--  To import this information into a w3cms site follow these steps:  -->
<!--  1. Log in to that site as an administrator.  -->
<!--  2. Go to Tools: Import in the w3cms admin panel.  -->
<!--  3. Upload this file using the form provided on that page.  -->
<!--  4. You will first select the author on that page.  -->
<!--  5. w3cms will then import each of the posts, pages, comments, categories, etc.  -->
<!--     contained in this file into your site.  -->
<!--  File imported Date : ".date('F j, Y, g:i a').".  -->
";
            $xml->text($startText);
            $xml->setIndent(true);
            $xml->setIndentString("\t");

            /*======= recursive function for array to xml convert with child =======*/
            function array_to_xml($content, &$xml, $table=Null) {      
                foreach($content as $key => $value) {

                    if(is_array($value)) {
                        if (!is_string($key)) {
                            $xml->startElement($table);
                            array_to_xml($value, $xml);
                            $xml->endElement();
                        }
                        else {
                            $xml->startElement($key);
                            $table = $key;
                            array_to_xml($value, $xml, $table);
                            $xml->endElement();
                        }
                    }
                    else {
                        if (!empty($value)) {
                            $xml->startElement($key);
                            $xml->text($value);
                            $xml->endElement();
                        }
                    }
                }     
            }

            array_to_xml($content, $xml);

            $xml->endElement();
            $xml->endDocument();
            $xml->flush();

            /*==== XML file is stored under /storage/app/public/system-export-data/content.xml =======*/
            $file = $directory.$filename;
            $headers = array('Content-Type: text/xml');

            return \Response::download($file, $filename, $headers);
        }
        catch(Exception $e)
        {
            echo $e;
        }
    }

}