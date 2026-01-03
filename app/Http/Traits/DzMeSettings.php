<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Menu;
use App\Models\Blog;
use App\Models\BlogCategory;
use Hexadog\ThemesManager\Facades\ThemesManager;
use App\Helper\DzHelper;

trait DzMeSettings {


    /* Set Default Values */
    public $setting_config      = array();
    public $required_widgets    = array();
    public $all_cpt             = array();
    public $categories          = array();
    public $pages               = array();
    public $menus               = array();
    public $blogs               = array();
    public $limit               = 6;
    public $page_fields         = array(
                                    'title' => 'Title',
                                    'excerpt' => 'Excerpt',
                                    'publish_on' => 'Publish On',
                                    'modified' => 'Modified Date',
                                    'created' => 'Created Date'
                                );
    public $post_fields         = array(
                                    'title' => 'Title',
                                    'excerpt' => 'Excerpt',
                                    'publish_on' => 'Publish On',
                                    'modified' => 'Modified Date',
                                    'created' => 'Created Date'
                                );
    public $more_posts_fields = array(
                                    'BlogTag' => 'Tags',
                                    'FeatureImage' => 'Feature Image',
                                    'BlogSeo' => 'Seo Content',
                                    'User' => 'Author Details'
                                );

    public $more_pages_fields = array(
                                    'FeatureImage' => 'Feature Image',
                                    'ContentSeo' => 'Seo Content',
                                    'User' => 'Author Details'
                                );

    public $orderby_options = array(
                                'title' => 'Title',
                                'publish_on' => 'Publish On',
                                'created_at' => 'Created Date',
                                'rand' => 'Random'
                            );

    public $background_options = array(
                                'dark'  =>  'Dark',
                                'light' =>  'Light',
                                'white' =>  'White'
                            );

    public $order_options = array(
                            'ASC' => 'Ascending',
                            'DESC' => 'Descending',
                            'RAND' => 'Random'
                        );
    public $social_icons = array(
            'facebook'  => 'Facebook',
            'instagram' => 'Instagram',
            'whatsapp'  => 'Whatsapp',
            'twitter'   => 'Twitter',
            'youtube'   => 'YouTube',
            'linkedin'  => 'LinkedIn',
            'reddit'    => 'Reddit',
            'pinterest' => 'Pinterest',
            'google'   => 'Google+'
        );

    /* Set Default Values */
    public function initializeSettings(){

        $this->all_cpt             = $this->getAllPostTypes();
        $this->categories          = $this->getBlogCategoryList(); 
        $this->pages               = $this->getPagesList(); 
        $this->menus               = $this->getMenusList(); 
        $this->blogs               = $this->getBlogsList(config('blog.post_type'));
        $this->limit               = config('Reading.nodes_per_page', 6);
    }


    public function getBlogCategoryList(){
        $categories     = array();
        $blog_categories    = (new BlogCategory)->generateCategoryTreeArray(Null, "_", ['id', 'title', 'slug']);
        foreach ($blog_categories as $key => $value) {
            $categories[$value['slug']] =  $value['title'];
        }

        return $categories;
    }

    public function getAllPostTypes(){
        $all_cpt   = Blog::where('post_type', '=', config('w3cpt.post_type'))->pluck('title', 'slug')->toArray();
        return $all_cpt;
    }

    public function getCPTCategories($postType=''){

        $all_Categories = array();
        $taxonomyArr = array();

        if ($postType) {

            $blogObj = new \Modules\W3CPT\Entities\Blog;
            $cpt_taxonomies = $blogObj->getTaxonomiesByPostType($postType);
            if ($cpt_taxonomies) {
                foreach ($cpt_taxonomies as $value) {
                    $taxonomyArr[] = $value['cpt_tax_name'];
                }
            }
            return $all_Categories = \Modules\W3CPT\Entities\BlogCategory::whereIn('type', $taxonomyArr)->pluck('title', 'slug')->toArray();
        }

        return $all_Categories;
    }

    public function getBlogsList($post_type){
        $blogs = Blog::WherePublishBlog($post_type)->pluck('title', 'slug')->toArray();
        return $blogs;
    }

    public function getPagesList(){
        $pages = Page::pluck('title', 'id')->toArray();
        return $pages;
    }

    public function getMenusList(){
        $menus = Menu::pluck('title', 'slug')->toArray();
        return $menus;
    }

    /*
     * default_settings
     */
    public function default_settings() {

        /* w3cms default elements start */
        $default_settings['w3cms_post_element'] = array(
            'name' => 'Post Listing',
            'base' => 'w3cms_post_element',
            'class' => '',
            'category' => 'Global',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Posts Listing.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'SubTitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Categories",
                    "id"    => 'post_category_ids',
                    "default"         => array(),
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Post With Images Only',
                    'id'    => 'post_with_images',
                    'default'         => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Fields to Display",
                    "id"    => "post_fields",
                    "default"         => array(),
                    "options"       => $this->post_fields,
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "checkbox_multi",
                    "class"         => "",
                    "title"       => "Display More Fields",
                    "id"    => 'contain_post_fields',
                    "default"         => array(),
                    "options"       => $this->more_posts_fields,
                    "group"         => 'Advance'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'Pagination',
                    'id'    =>  'pagination',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'        =>    'text',
                    'title'     =>    'No. of Posts Per Page',
                    'id'  =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'       =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order By',
                    'id'    =>  'orderby',
                    'default'         =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order',
                    'id'    =>  'order',
                    'default'         =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'View All Link',
                    'id'    =>  'view_all',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Select Page',
                    'id'    =>  'page_id',
                    'default'         =>  array(),
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
            )
        );

        $default_settings['w3cms_page_element'] = array(
            'name' => 'Page Listing',
            'base' => 'w3cms_page_element',
            'class' => '',
            'category' => 'Global',
            'icon' => asset('/images/MagicEditor/theme-elements/global/page.png'),
            'description' => 'Shows Page.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Description',
                    "id"    => "description",
                    "group"         => 'General',
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Pages",
                    "id"    => 'page_ids',
                    "default"         => array(),
                    "options"       => $this->pages,
                    "desc"    => "Note: If select nothing then show All Pages.",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Page With Images Only',
                    'id'    => 'page_with_images',
                    'default'         => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Fields to Display",
                    "id"    => "page_fields",
                    "default"         => array(),
                    "options"       => $this->page_fields,
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "checkbox_multi",
                    "class"         => "",
                    "title"       => "Display More Fields",
                    "id"    => 'contain_page_fields',
                    "options"       => $this->more_pages_fields,
                    "group"         => 'Advance'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'Enable Pagination',
                    'id'    =>  'pagination',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>    'text',
                    'title'       =>    'No. of Pages Per Page',
                    'id'    =>    'No_of_pages',
                    'default'         =>    $this->limit,
                    'group'         =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order By',
                    'id'    =>  'orderby',
                    'default'         =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order',
                    'id'    =>  'order',
                    'default'         =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'View All Link',
                    'id'    =>  'view_all',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Select Page',
                    'id'    =>  'page_id',
                    'default'         =>  array(),
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
            ),
        );

        $default_settings['w3cms_category_element'] = array(
            'name' => 'Category Listing',
            'base' => 'w3cms_category_element',
            'class' => '',
            'category' => 'Global',
            'icon' => asset('/images/MagicEditor/theme-elements/global/categories.png'),
            'description' => 'Shows Categories.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Categories",
                    "id"    => 'category_ids',
                    'default'         =>  array(),
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Category With Images Only',
                    'id'    => 'category_with_images',
                    'default'         => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'Enable Pagination',
                    'id'    =>  'pagination',
                    'default'         =>  'true',
                    'group'         =>  'Pagination Section'
                ),
                array(
                    'type'          =>  'text',
                    'title'       =>  'No. of Category Per Page',
                    'id'    =>  'no_of_category',
                    'default'         =>  $this->limit,
                    'group'         =>  'Pagination Section'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order By',
                    'id'    =>  'orderby',
                    'default'         =>  array(),
                    'options'       =>  array(
                                            'title' => 'Title',
                                            'created_at' => 'Created Date',
                                            'rand' => 'Random'
                                        ),
                    'group'         =>  'Pagination Section'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order',
                    'id'    =>  'order',
                    'default'         =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination Section'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'View All Link',
                    'id'    =>  'view_all',
                    'default'         =>  'true',
                    'group'         =>  'Pagination Section'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Select Page',
                    'id'    =>  'page_id',
                    'default'         =>  array(),
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination Section',
                    'depend_on'     =>  'view_all'
                ),
            ),
        );

        $default_settings['w3cms_swiper_element'] = array(
            "name" => "Swiper Element",
            "base" => "w3cms_swiper_element",
            "class" => "",
            "category" => "Global",
            "icon" => asset("/images/MagicEditor/theme-elements/global/slider.png"),
            "description" => "Shows Swiper Banner.",
            "css" => "",
            "params" => array(
                array(
                    "type"          => "radio",
                    "class"         => "",
                    "title"       => "Select Content Type",
                    "id"    => "content_type",
                    "options"       => array(
                                            "blog"      => "Post",
                                            "category"  => "Category",
                                            "cpt"       => "CPT - Custom Post Type",
                                            "upload"    => "Upload Images",
                                        ),
                    "default"         => "upload",
                    "group"         => "General"
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Post Categories",
                    "id"    => "post_category_ids",
                    "default"         => array(),
                    "options"       => $this->categories,
                    "group"         => "General",
                    "depend_on"     => array(
                                        "content_type" => array(
                                            "value" => "blog",
                                            "operator" => "=="
                                            ),
                                        )
                ),
                array(
                    'type'        =>    'text',
                    'title'     =>    'No. of Posts',
                    'id'  =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'       =>    'General',
                    "depend_on"   => array(
                                        "content_type" => array(
                                            "value" => "blog",
                                            "operator" => "=="
                                            ),
                                        )
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order By',
                    'id'    =>  'orderby',
                    'default'         =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'General',
                    "depend_on"     => array(
                                        "content_type" => array(
                                            "value" => "blog",
                                            "operator" => "=="
                                            ),
                                        )
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order',
                    'id'    =>  'order',
                    'default'         =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'General',
                    "depend_on"     => array(
                                        "content_type" => array(
                                            "value" => "blog",
                                            "operator" => "=="
                                            ),
                                        )
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Categories",
                    "id"    => "category_ids",
                    "options"       => $this->categories,
                    "group"         => "General",
                    "depend_on"     => array(
                                        "content_type" => array(
                                            "value" => "category",
                                             "operator" => "=="
                                            )
                                        )
                ),
                array(
                    "type"          => "gallery",
                    "class"         => "",
                    "title"       => "Select multiple Swiper Images",
                    "id"    => "swiper_images",
                    "desc"   => "",
                    "group"         => "General",
                    "depend_on"     => array(
                                            "content_type" => array(
                                                "value" => "upload",
                                                 "operator" => "=="
                                                )

                                            )
                ),
                array(
                    "type"          => "select",
                    "class"         => "",
                    "title"       => "Select Post Type",
                    "id"    => "post_types",
                    "desc"   => "",
                    "options"       => $this->all_cpt,
                    "group"         => "General",
                    "ajax_url"      => \url('/').'/admin/magic_editors/get_cpt_categories',
                    "ajax_container"=> "post_type_catagoriesContainer",
                    "depend_on"     => array(
                                            "content_type" => array(
                                                "value" => "cpt",
                                                 "operator" => "=="
                                                )
                                            )
                ),
                array(
                    "type"          => "select",
                    "class"         => "",
                    "title"       => "Select Category of Post Type",
                    "id"    => "post_type_catagories",
                    "ajax_url"      => \url('/').'/admin/magic_editors/get_post_by_cpt_category',
                    "ajax_container"=> "item_idsContainer",
                    "group"         => "General",
                    "ajax_field"    => "true",
                    "depend_on"     => "post_types"
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Items",
                    "id"    => "item_ids",
                    "group"         => "General",
                    "ajax_field"    => "true",
                    "depend_on"     => "post_type_catagories"
                ),

                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slider Height (in px)",
                    "id"    => "slider_height",
                    "default"         => "",
                    "desc"    => "Note: slider container height in pexel(px) , Default - 400px, 0 for fullscreen.",
                    "group"         => "General"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Navigation (Next & Prev Buttons)",
                    "id"    => "navigation",
                    "default"         => "true",
                    "group"         => "Advance"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Pagination",
                    "id"    =>  "pagination",
                    "options"         =>  array(
                                            ""      =>"No Pagination",
                                            "bullets"   =>"Pagination Bullets",
                                            "fraction"  =>"Pagination Fraction",
                                            "progressbar"  =>"Pagination Progress Bar",
                                        ),
                    "group"         =>  "Advance",
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Dynamic Bullets",
                    "id"    => "dynamic_bullets",
                    "default"         => "true",
                    "group"         => "Advance",
                    "desc"   => "Note: it will only make Bullets pagination dynamic.",
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Show Scrollbar",
                    "id"    => "scrollbar",
                    "default"         => "true",
                    "desc"   => "Note: Not Works fine when Loop is True",
                    "group"         => "Advance"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Space Between (in px)",
                    "id"    => "space_between",
                    "desc"    => "Note: Add space between slides ( Default is 30px ).",
                    "group"         => "Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Keyboard control",
                    "id"    => "keyboard_control",
                    "default"         => "true",
                    "group"         => "Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Auto Play",
                    "id"    => "auto_play",
                    "default"         => "true",
                    "group"         => "Advance"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Auto Play Delay Time(in .ms)",
                    "id"    => "autoplay_delay",
                    "desc"   => "Note: Works when Auto Play Checked ( Default is 1500ms )",
                    "depend_on"     => "auto_play",
                    "group"         => "Advance"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Looping",
                    "id"    =>  "loop",
                    "options"         =>  array(
                                            "true"=>"True",
                                            "false"=>"False"
                                        ),
                    "group"         =>  "Advance",
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Slides Direction",
                    "id"    =>  "direction",
                    "default"         => "horizontal",
                    "options"         =>  array(
                                            "horizontal"=>"Horizontal",
                                            "vertical"  =>"Vertical",
                                        ),
                    "group"         =>  "Slide Related",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slides Per View",
                    "id"    => "slides_per_view",
                    "desc"   => "Note: Do Not Work with Fade, cards, Cube and Flip effect ( Default is 4 ). ",
                    "group"         => "Slide Related"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Centered Slides",
                    "id"    => "centered_slides",
                    "default"         => "true",
                    "group"         => "Slide Related"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Free Mode Slider",
                    "id"    => "free_mode",
                    "default"         => "true",
                    "group"         => "Slide Related"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Slider Effects",
                    "id"    =>  "effect",
                    "options"         =>  array(
                                            "fade"      =>  "Fade",
                                            "coverflow" =>  "Coverflow",
                                            "cube"      =>  "Cube",
                                            "flip"      =>  "Flip",
                                            "cards"      =>  "Cards",
                                        ),
                    "group"         =>  "Slide Related",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Sliding Speed (in .ms)",
                    "id"    => "speed",
                    "desc"   => "Note: Default value is 1500ms ).",
                    "group"         => "Slide Related"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Thumb Slider",
                    "id"    => "thumb_slider",
                    "default"         => "true",
                    "desc"   => "Note: Only works when Content Type is Upload Images.",
                    "group"         => "Slide Related"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Thumb Slider Per View",
                    "id"    => "thumb_slider_view",
                    "group"         => "Slide Related",
                    "depend_on"     => "thumb_slider",
                ),
            )
        );
        /* w3cms default elements end */

        
        return $default_settings;
    }

    /*
     * default_settings
     */
    public function default_widgets() {

        /* W3cms Widget elements Start*/
        $default_widgets['archives'] = array(
            'name' => 'Archives',
            'base' => 'archives',
            'class' => '',
            'category' => 'Widgets',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Archives Listing.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Show post counts',
                    'id'            => 'show_post_counts',
                    'value'         => 'true',
                    "group"         => 'General'
                ),
            )
        );

        $default_widgets['categories'] = array(
            'name' => 'Categories',
            'base' => 'categories',
            'class' => '',
            'category' => 'Widgets',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Categories Listing.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show post counts',
                    'id'    => 'show_post_counts',
                    'value'         => 'true',
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show hierarchy',
                    'id'    => 'show_hierarchy',
                    'value'         => 'true',
                    "group"         => 'General'
                ),
            )
        );

        $default_widgets['recent_posts'] = array(
            'name' => 'Recent Posts',
            'base' => 'recent_posts',
            'class' => '',
            'category' => 'Widgets',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Recent Posts.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Number of posts to show',
                    "id"    => "number_of_posts",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Display post date?',
                    'id'    => 'display_date',
                    'value'         => 'true',
                    "group"         => 'General'
                ),
            )
        );

        $default_widgets['search'] = array(
            'name' => 'search',
            'base' => 'search',
            'class' => '',
            'category' => 'Widgets',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows search.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
            )
        );

        $default_widgets['tags'] = array(
            'name' => 'Tags',
            'base' => 'tags',
            'class' => '',
            'category' => 'Widgets',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Tags.',
            'css' => '',
            'params' => array(
                array(
                    "type"      => "text",
                    "class"     => "",
                    "title"     => 'Title',
                    "id"        => "title",
                    "group"     => 'General'
                ),
            )
        );

        $default_widgets['html_content'] = array(
            'name' => 'HTML Content',
            'base' => 'html_content',
            'class' => '',
            'category' => 'Widgets',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows HTML Content.',
            'css' => '',
            'params' => array(
                array(
                    "type"      => "textarea",
                    "class"     => "",
                    "title"     => 'HTML Content',
                    "id"        => "html_content",
                    "group"     => 'General'
                ),
            )
        );
        /* W3cms Widget elements end*/
        
        return $default_widgets;
    }

    /*
    * Function : mergeThemesElements
    * Purpose : Function for merging theme elements to member variable $this->setting_config.
    */
    public function mergeThemesElements($elementsArray=array()) {
        
        $defaultElements = $this->default_settings();
        
        if (is_array($elementsArray) && !empty($elementsArray)) {
            $this->setting_config = array_merge($defaultElements, $elementsArray);
        }
        else{
            $this->setting_config = $defaultElements;
        }
    }

    /*
    * Function : mergeWidgetsElements
    * Purpose : Function for merging Widget elements to member variable $this->required_widgets.
    */
    public function mergeWidgetsElements($elementsArray=array()) {
        
        $defaultElements = $this->default_widgets();
        
        if (is_array($elementsArray) && !empty($elementsArray)) {
            $this->required_widgets = array_merge($defaultElements, $elementsArray);
        }
        else{
            $this->required_widgets = $defaultElements;
        }
    }

}
