<?php

namespace Themes\frontend\lemars\includes\MagicEditor;
use App\Http\Traits\DzMeSettings;
use Illuminate\Http\Request;

class ElementsClass {
    use DzMeSettings;

    public $theme_elements;
    public $widget_elements;

    public function __construct() {
        $this->initializeSettings();
        $this->setThemeElements();
        $this->setWidgetElements();
    }

    public function __init() {
        $this->mergeThemesElements($this->theme_elements);
        $this->mergeWidgetsElements($this->widget_elements);
    }

    public function setThemeElements() {

        /* w3cms lemars elements start */

        $this->theme_elements['contact_us_form_1'] = array(
            'name' => 'Contact Us',
            'base' => 'contact_us_form_1',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/themes/frontend/lemars/images/MagicEditor/theme-elements/lemars/contact_us_form_1.png'),
            'description' => 'Contact Us 3.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Show Image',
                    'id'            =>  'show_image',
                    'default'         =>  'true',
                    "description"   => "Note: It will show an input for image if it is Checked",
                    'group'         =>  'General'
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"         => 'Section Image',
                    "id"            => "image",
                    "group"         => 'General',
                    'depend_on'     =>  'show_image'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Address',
                    "id"            => "address",
                    "group"         => 'Advance',
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'E-mail',
                    "id"            => "email",
                    "group"         => 'Advance',
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Phone Number',
                    "id"            => "phone",
                    "group"         => 'Advance',
                ),
                array(
                    'type' => 'group',
                    'default' => '',
                    'id' => 'social_icon',
                    "title"       => 'Add More Social Icon',
                    'group' => 'Social Icons',
                    'params' => array(
                        array(
                            'type'          =>  'select',
                            "class"         =>  "",
                            'title'         =>  'Select icon',
                            'id'            =>  'icon',
                            'options'       =>  $this->social_icons,
                        ),
                        array(
                            "type"          => "text",
                            "class"         => "",
                            "title"         => 'Social Icon Link',
                            "id"            => "social_link",
                        ),
                    )
                )
            )
        );

        $this->theme_elements['post_listing_1'] = array(
            'name' => 'Post listing 1',
            'base' => 'post_listing_1',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/themes/frontend/lemars/images/MagicEditor/theme-elements/lemars/post_listing_1.png'),
            'description' => 'Shows Section of contact.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Subtitle',
                    "id"            => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Description',
                    "id"            => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Categories",
                    "id"            => 'post_category_ids',
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Post With Images Only',
                    'id'            => 'post_with_images',
                    'default'         => 'true',
                    "group"         => 'General'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination ( Load More Button )',
                    'id'            =>  'pagination',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>    'text',
                    'title'         =>    'No. of Posts Per Page',
                    'id'            =>    'no_of_posts',
                    'default'         =>     $this->limit,
                    'group'         =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Learn More Button',
                    'id'            =>  'view_all',
                    'default'         =>  'true',
                    "description"   =>  "Note: Works when Pagination is not Checked",
                    'group'         =>  'Pagination'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Btn Text',
                    "id"            => "btn_text",
                    "group"         => 'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Select Page',
                    'id'            =>  'page_id',
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
            )
        );

        $this->theme_elements['post_listing_2'] = array(
            'name' => 'Post Listing 2',
            'base' => 'post_listing_2',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/themes/frontend/lemars/images/MagicEditor/theme-elements/lemars/post_listing_2.png'),
            'description' => 'Shows Section of post listing.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Subtitle',
                    "id"            => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Description',
                    "id"            => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Categories",
                    "id"            => 'post_category_ids',
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Post With Images Only',
                    'id'            => 'post_with_images',
                    'default'         => 'true',
                    "group"         => 'General'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination ( Load More Button )',
                    'id'            =>  'pagination',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>    'text',
                    'title'         =>    'No. of Posts Per Page',
                    'id'            =>    'no_of_posts',
                    'default'         =>     $this->limit,
                    'group'         =>    'Pagination'
                ),

                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Learn More Button',
                    'id'            =>  'view_all',
                    'default'         =>  'true',
                    "description"   => "Note: Works when Pagination is not Checked",
                    'group'         =>  'Pagination'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Btn Text',
                    "id"            => "btn_text",
                    "group"         => 'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Select Page',
                    'id'            =>  'page_id',
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
            )
        );

        $this->theme_elements['slider_banner_1'] = array(
            'name' => 'Slider Banner 1',
            'base' => 'slider_banner_1',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/themes/frontend/lemars/images/MagicEditor/theme-elements/lemars/slider_banner_1.png'),
            'description' => 'Shows About Section.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"         => 'Banner Background Image',
                    "id"            => "image",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Categories",
                    "id"            => 'post_category_ids',
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          =>    'text',
                    'title'         =>    'No. of Posts',
                    'id'            =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'       =>    'General'
                ),

                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'General'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'options'       =>  $this->order_options,
                    'group'         =>  'General'
                ),
                array(
                    "type"          =>  "select",
                    "title"         =>  "Select Grabcursor",
                    "id"            =>  "grabCursor",
                    "options"         =>  array(
                                            "true"=>"True",
                                            "false"=>"False"
                                        ),
                    "group"         =>  "Slider Basic",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Space Between (in px)",
                    "description"   => "( Default is 30 )",
                    "id"            => "space_between",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => "Keyboard control",
                    "id"            => "keyboard_control",
                    "default"         => "true",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => "Auto Play",
                    "id"            => "auto_play",
                    "default"         => "true",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Auto Play Delay Time(in .ms)",
                    "id"            => "autoplay_delay",
                    "description"   => "Note: Works when Auto Play Checked",
                    "depend_on"     => "auto_play",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          =>  "select",
                    "title"         =>  "Looping",
                    "id"            =>  "loop",
                    "options"         =>  array(
                                            "true"=>"True",
                                            "false"=>"False"
                                        ),
                    "group"         =>  "Slider Basic",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Slides Per View",
                    "id"            => "slides_per_view",
                    "description"   => "Note: Do Not Work with Fade, cards, Cube and Flip effect.( Default is 1 )",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => "Centered Slides",
                    "id"            => "centered_slides",
                    "default"         => "true",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => "Free Mode Slider",
                    "id"            => "free_mode",
                    "default"         => "true",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          =>  "select",
                    "title"         =>  "Slider Effects",
                    "id"            =>  "effect",
                    "options"       =>  array(
                                            ""          =>  "No Effect",
                                            "fade"      =>  "Fade",
                                            "coverflow" =>  "Coverflow",
                                            "cube"      =>  "Cube",
                                            "flip"      =>  "Flip",
                                            "cards"      =>  "Cards",
                                        ),
                    "group"         =>  "Slider Advance",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Sliding Speed (in .ms)",
                    "id"            => "speed",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Slider Per View on min-width 575(px).( Default is 1 )",
                    "id"            => "breakpoint1",
                    "group"         => "Responsive",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Slider Per View on min-width 768(px).( Default is 1 )",
                    "id"            => "breakpoint2",
                    "group"         => "Responsive",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Slider Per View on min-width 992(px).( Default is 2 )",
                    "id"            => "breakpoint3",
                    "group"         => "Responsive",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => "Slider Per View on min-width 1200(px).( Default is 3 )",
                    "id"            => "breakpoint4",
                    "group"         => "Responsive",
                ),
            )
        );

        $this->theme_elements['content_box_1'] = array(
            'name' => 'Content Box 1',
            'base' => 'content_box_1',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/themes/frontend/lemars/images/MagicEditor/theme-elements/lemars/content_box_1.png'),
            'description' => 'Shows About Section.',
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
                    "type"          => "media",
                    "class"         => "",
                    "title"         => 'Image',
                    "id"            => "image",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"         => 'Content Left',
                    "id"            => "content1",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"         => 'Content Right',
                    "id"            => "content2",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Facebook Link',
                    "id"            => "facebook_link",
                    "group"         => 'Socials'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Instagram Link',
                    "id"            => "instagram_link",
                    "group"         => 'Socials'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Twitter Link',
                    "id"            => "twitter_link",
                    "group"         => 'Socials'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Whatsapp Link',
                    "id"            => "whatsapp_link",
                    "group"         => 'Socials'
                ),
            ),
        );

        $this->theme_elements['blog_listing'] = array(
            'name' => 'Blog Listing (Grid Type)',
            'base' => 'blog_listing',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/themes/frontend/lemars/images/MagicEditor/theme-elements/lemars/blog_listing.png'),
            'description' => 'Shows Map.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Categories",
                    "id"            => 'post_category_ids',
                    "default"       => array(),
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Show Sidebar',
                    'id'            => 'sidebar',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Post With Images Only',
                    'id'            => 'post_with_images',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Fields to Display",
                    "id"            => "post_fields",
                    "default"         => array(),
                    "options"       => $this->post_fields,
                    "group"         => 'Advance'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination',
                    'id'            =>  'pagination',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'radio',
                    'title'         =>  'Pagination Type',
                    'id'            =>  'pagination_type',
                    'options'       =>  ['default'=>'Default'],
                    'default'       =>  'load_more',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>    'text',
                    'title'         =>    'No. of Posts Per Page',
                    'id'            =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'         =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
            )
        );

        $this->theme_elements['blog_listing_2'] = array(
            'name' => 'Blog Listing (List Type)',
            'base' => 'blog_listing_2',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/themes/frontend/lemars/images/MagicEditor/theme-elements/lemars/blog_listing_2.png'),
            'description' => 'Shows Map.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Categories",
                    "id"            => 'post_category_ids',
                    "default"       => array(),
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Show Sidebar',
                    'id'            => 'sidebar',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Post With Images Only',
                    'id'            => 'post_with_images',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Fields to Display",
                    "id"            => "post_fields",
                    "default"         => array(),
                    "options"       => $this->post_fields,
                    "group"         => 'Advance'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination',
                    'id'            =>  'pagination',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'radio',
                    'title'         =>  'Pagination Type',
                    'id'            =>  'pagination_type',
                    'options'       =>  ['default'=>'Default'],
                    'default'       =>  'load_more',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>    'text',
                    'title'         =>    'No. of Posts Per Page',
                    'id'            =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'         =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
            )
        );

        /* w3cms lemars elements end */
    }

    public function setWidgetElements() {
        $this->widget_elements['recent_posts_2'] = array(
            'name' => 'Recent Posts 2',
            'base' => 'recent_posts_2',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Recent Posts.',
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
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Number of posts to show',
                    "id"            => "number_of_posts",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Display post date',
                    'id'            => 'display_date',
                    'default'         => 'true',
                    "group"         => 'General'
                ),
            )
        );

        $this->widget_elements['video_box'] = array(
            'name' => 'Video Box',
            'base' => 'video_box',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Video Box.',
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
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Video Box Url',
                    "id"            => "url",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"         => 'Image',
                    "id"            => "image",
                    "group"         => 'General',
                ),
            )
        );

        $this->widget_elements['widget_social_icon'] = array(
            'name' => 'Social Icons',
            'base' => 'widget_social_icon',
            'class' => '',
            'category' => 'Lemars',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Video Box.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
            )
        );

    }

}
?>