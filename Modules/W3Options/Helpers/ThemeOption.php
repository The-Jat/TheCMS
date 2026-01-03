<?php

namespace Modules\W3Options\Helpers;
use Modules\W3Options\OptionsClass\ThemeOptionsClass;
use ThemeBlogOptions;
use ThemePageOptions;
use DzHelper;
class ThemeOption
{

    static $field_id;
    static $field_type;
    static $field_class;
    static $field_heading;
    static $field_subtitle;
    static $field_description;
    static $field_options;
    static $field_placeholder;
    static $field_default;
    static $old_field_value;
    static $field_params;
    static $options_type;
    static $field_name;
    


    public static function CreateField($field = array(),$options_type=null)
    { 
        self::$options_type         = !empty($options_type)          ? $options_type    : 'theme-options';
        self::$field_type           = !empty($field['type'])         ? $field['type']    : '';
        self::$field_id             = !empty($field['id'])           ? $field['id']  : '';

        if (!empty($field['group-field']) && $field['group-field']) {
            $group_field_name = !empty($field['field_name']) ? $field['field_name'] : '';
            self::$field_name           = self::$options_type.$group_field_name;
        }else{
            self::$field_name           = self::$options_type.'['.self::$field_id.']';
        }
        
        self::$field_class          = !empty($field['class'])        ? $field['class'] : '';
        self::$field_class          = !empty($field['depend_on'])    ? self::$field_class.' hidden' : '';
        self::$field_heading        = !empty($field['title'])        ? DzHelper::admin_lang($field['title'])   : '';
        self::$field_subtitle       = !empty($field['subtitle'])     ? DzHelper::admin_lang($field['subtitle']) : '';
        self::$field_description    = !empty($field['desc'])         ? DzHelper::admin_lang($field['desc'])    : '';
        self::$field_options        = !empty($field['options'])      ? $field['options']     : array();
        self::$field_placeholder    = !empty($field['placeholder'])  ? $field['placeholder'] : '';
        self::$field_default        = isset($field['default'])      ? $field['default'] : '';
        self::$old_field_value      = isset($field['old_field_value'])  ? (is_array($field['old_field_value']) ? $field['old_field_value'] : urldecode($field['old_field_value'])) : self::$field_default;
        self::$field_params         = !empty($field['params'])      ? $field['params']     : array();

        if (self::$field_type == 'ace_editor') {
        }
        if (self::$field_type == 'background') {
            return self::Background($field);
        }
        if (self::$field_type == 'border') {
            return self::Border($field);
        }
        if (self::$field_type == 'box_shadow') {
            return self::BoxShadow($field);
        }
        if (self::$field_type == 'button_set') {
            return self::ButtonSet($field);
        }
        if (self::$field_type == 'checkbox') {
            return self::Checkbox($field);
        }
        if (self::$field_type == 'checkbox_multi') {
            return self::CheckboxMulti($field);
        }
        if (self::$field_type == 'color_gradient') {
            return self::ColorGradient($field);
        }
        if (self::$field_type == 'color_palette') {
        }
        if (self::$field_type == 'color_rgba') {
        }
        if (self::$field_type == 'color') {
            return self::Color($field);
        }
        if (self::$field_type == 'content') {
            return self::Content($field);
        }
        if (self::$field_type == 'date') {
            return self::Date($field);
        }
        if (self::$field_type == 'dimensions') {
            return self::Dimensions($field);
        }
        if (self::$field_type == 'divide') {
        }
        if (self::$field_type == 'editor') {
            return self::Editor($field);
        }
        if (self::$field_type == 'gallery') {
            return self::Gallery($field);
        }
        if (self::$field_type == 'image_select') {
            return self::ImageSelect($field);
        }
        if (self::$field_type == 'info') {
        }
        if (self::$field_type == 'link_color') {
            return self::LinkColor($field);
        }
        if (self::$field_type == 'media') {
            return self::Media($field);
        }
        if (self::$field_type == 'multi_text') {
        }
        if (self::$field_type == 'palette') {
        }
        if (self::$field_type == 'password') {
            return self::Password($field);
        }
        if (self::$field_type == 'radio') {
            return self::Radio($field);
        }
        if (self::$field_type == 'raw') {
        }
        if (self::$field_type == 'section') {
        }
        if (self::$field_type == 'select_image') {
            return self::SelectImage($field);
        }
        if (self::$field_type == 'select') {
            return self::Select($field);
        }
        if (self::$field_type == 'multi_select') {
            return self::MultiSelect($field);
        }
        if (self::$field_type == 'slider') {
            return self::Slider($field);
        }
        if (self::$field_type == 'slides') {
        }
        if (self::$field_type == 'sortable') {
        }
        if (self::$field_type == 'sorter') {
            return self::Sorter($field);
        }
        if (self::$field_type == 'spacing') {
            return self::Spacing($field);
        }
        if (self::$field_type == 'spinner') {
            return self::Spinner($field);
        }
        if (self::$field_type == 'switch') {
            return self::Switch($field);
        }
        if (self::$field_type == 'text') {
            return self::Text($field);
        }
        if (self::$field_type == 'textarea') {
            return self::Textarea($field);
        }
        if (self::$field_type == 'typography') {
            return self::Typography($field);
        }
        if (self::$field_type == 'group') {
            return self::Group($field);
        }
    }

    //****************  ThemeOptions Fields Start  ****************//

    /* Option Array = array(
        'id'       => 'opt-background',
        'type'     => 'background',
        'title'    => __('Body Background'),
        'subtitle' => __('Body background with image, color, etc.'),
        'desc'     => __('This is the description field, again good for additional info.'),
        'preview_height' => '20px',
        'default' => array(
            'background-attachment' => 'fixed',
            'background-clip' => 'border-box',
            'background-color' => 'sdfsdf',
            'background-image' => 'sdfsdf',
            'background-origin' => 'border-box',
            'background-position' => 'right top',
            'background-repeat' => 'no-repeat',
            'background-size' => 'cover',
            'media' => 'asdasd'
        ),
        'background-attachment' => true,
        'background-clip' => true,
        'background-color' => true,
        'background-image' => true,
        'background-origin' => true,
        'background-position' => true,
        'background-repeat' => true,
        'background-size' => true,
        'preview_media' => true
    ),*/
    static function Background($field)
    {
        $bgRepeatArr = array('no-repeat','repeat','repeat-x','repeat-y','inherit');
        $bgAttachmentArr = array('fixed', 'scroll', 'inherit');
        $bgPositionArr = array('left-top','left-center','left-bottom','center-top','center-center','center-bottom','right-top','right-center','right-bottom');
        $bgClipArr = array('inherit','border-box','content-box','padding-box');
        $bgOriginArr = array('inherit','border-box','content-box','padding-box');
        $bgSizeArr = array('inherit','cover','contain');
        
        $default_array = is_array(self::$old_field_value) ? self::$old_field_value : array() ;
        $default_bg_color = !empty($default_array['background-color']) ? $default_array['background-color'] : '' ;
        $default_bg_repeat = !empty($default_array['background-repeat']) ? $default_array['background-repeat'] : '' ;
        $default_bg_attachment = !empty($default_array['background-attachment']) ? $default_array['background-attachment'] : '' ;
        $default_bg_position = !empty($default_array['background-position']) ? $default_array['background-position'] : '' ;
        $default_bg_image = !empty($default_array['background-image']) ? $default_array['background-image'] : '' ;
        $default_bg_clip = !empty($default_array['background-clip']) ? $default_array['background-clip'] : '' ;
        $default_bg_origin = !empty($default_array['background-origin']) ? $default_array['background-origin'] : '' ;
        $default_bg_size = !empty($default_array['background-size']) ? $default_array['background-size'] : '' ;

        $background_attachment = isset($field['background-attachment']) ? $field['background-attachment']  : true ;
        $background_clip =       isset($field['background-clip'])      ? $field['background-clip']         : false ;
        $background_color =      isset($field['background-color'])     ? $field['background-color']        : true ;
        $background_image =      isset($field['background-image'])     ? $field['background-image']        : true ;
        $background_origin =     isset($field['background-origin'])    ? $field['background-origin']       : false ;
        $background_position =   isset($field['background-position'])  ? $field['background-position']     : true ;
        $background_repeat =     isset($field['background-repeat'])    ? $field['background-repeat']       : true ;
        $background_size =       isset($field['background-size'])      ? $field['background-size']         : true ;
        $preview_media =         isset($field['preview_media'])        ? $field['preview_media']           : false ;
        $preview_height =        !empty($field['preview_height'])       ? $field['preview_height']          : '200px' ;
        $html = array();

        $html[] =  '<div class="row">';
            
        if ($background_attachment) {
            $html[] =  '
            <div class="col-4 form-group">
                <label>Background Attachment</label>
                <select name="'.self::$field_name.'[background-attachment]" id="'.self::$field_id.'_background_attachment" class="form-control  w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">';
                $html[] = '<option value="">Background Attachment</option>';
                foreach ($bgAttachmentArr as $value) {
                    $attachmentChecked = ($value == $default_bg_attachment) ? 'selected="selected"' : '';
                    $html[] = '<option value="'.$value.'" '.$attachmentChecked.'>'.ucwords(str_replace('-',' ',$value)).'</option>';
                }
            $html[] = '
                </select>
            </div>';
        }
        if ($background_clip) {
            $html[] =  '
            <div class="col-4 form-group">
                <label>Background Clip</label>
                <select name="'.self::$field_name.'[background-clip]" id="'.self::$field_id.'_background_clip" class="form-control  w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">';
                $html[] = '<option value="">Background Clip</option>';
                foreach ($bgClipArr as $value) {
                    $clipChecked = ($value == $default_bg_clip) ? 'selected="selected"' : '';
                    $html[] = '<option value="'.$value.'" '.$clipChecked.'>'.ucwords(str_replace('-',' ',$value)).'</option>';
                }
                $html[] = '
                </select>
            </div>';
        }
        if ($background_repeat) {
            $html[] =  '
            <div class="col-4 form-group">
                <label>Background Repeat</label>
                <select name="'.self::$field_name.'[background-repeat]" id="'.self::$field_id.'_background_repeat" class="form-control  w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">';
                $html[] = '<option value="">Background Repeat</option>';
                    foreach ($bgRepeatArr as $value) {
                        $repeatChecked = ($value == $default_bg_repeat) ? 'selected="selected"' : '';
                        $html[] = '<option value="'.$value.'" '.$repeatChecked.'>'.ucwords(str_replace('-',' ',$value)).'</option>';
                    }
                $html[] = '
                </select>
            </div>';
        }
        if ($background_position) {
            $html[] =  '
            <div class="col-4 form-group">
                <label>Background Position</label>
                <select name="'.self::$field_name.'[background-position]" id="'.self::$field_id.'_background_position" class="form-control  w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">';
                    $html[] = '<option value="">Background Position</option>';
                    foreach ($bgPositionArr as $value) {
                        $positionChecked = ($value == $default_bg_position) ? 'selected="selected"' : '';
                        $html[] = '<option value="'.$value.'" '.$positionChecked.'>'.ucwords(str_replace('-',' ',$value)).'</option>';
                    }
                $html[] = '
                </select>
            </div>';
        }
        if ($background_origin) {
            $html[] =  '
            <div class="col-4 form-group">
                <label>Background Origin</label>
                <select name="'.self::$field_name.'[background-origin]" id="'.self::$field_id.'_background_origin" class="form-control  w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">';
                    $html[] = '<option value="">Background Origin</option>';
                    foreach ($bgOriginArr as $value) {
                        $originChecked = ($value == $default_bg_origin) ? 'selected="selected"' : '';
                        $html[] = '<option value="'.$value.'" '.$originChecked.'>'.ucwords(str_replace('-',' ',$value)).'</option>';
                    }
                $html[] = '
                </select>
            </div>';
        }
        if ($background_size) {
            $html[] =  '
            <div class="col-4 form-group">
                <label>Background Size</label>
                <select name="'.self::$field_name.'[background-size]" id="'.self::$field_id.'_background_size" class="form-control  w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">';
                    $html[] = '<option value="">Background Size</option>';
                    foreach ($bgSizeArr as $value) {
                        $sizeChecked = ($value == $default_bg_size) ? 'selected="selected"' : '';
                        $html[] = '<option value="'.$value.'" '.$sizeChecked.'>'.ucwords(str_replace('-',' ',$value)).'</option>';
                    }
                $html[] = '
                </select>
            </div>';
        }
        if ($background_image) {
            $html[] =  '
            <div class="col-4 form-group">
                <div class="img-parent-box">
                    <img class="mb-2 mw-100 img-for-onchange" width="auto" height="'.$preview_height.'" src="'.asset('images/noimage.jpg').'"  alt="Image">
                    <input type="file" name="'.self::$field_name.'[background-image]" class="ps-2 form-control img-input-onchange w3o-depend  '.self::$field_class.'" placeholder="Background Image" id="'.self::$field_id.'_background_image" accept="jpg,png,svg" data-depend-id="'.self::$field_id.'">
                    <input type="hidden" name="'.self::$field_name.'[background-image]" id="'.self::$field_id.'_bg_image_hidden" value="">
                </div>
            </div>';
        }
        if ($background_color) {
            $html[] =  '
            <div class="col-4 form-group">
                <div class="example">
                    <input name="'.self::$field_name.'[background-color]" id="'.self::$field_id.'_background_color" type="text" value="'.$default_bg_color.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
            
        $html[] ='</div>';
        return $html = implode(' ', $html);
    }

    /*Option Array = array(
        'id'       => 'header-border',
        'type'     => 'border',
        'title'    => __('Header Border Option ch'),
        'subtitle' => __('Only color validation can be done on this field type'),
        'output'   => array('.site-header'),
        'desc'     => __('This is the description field, again good for additional info.'),
        'all'      => true,
        'left'     => false,
        'right'    => false,
        'top'      => false,
        'bottom'   => false,
        'style'    => true,
        'color'    => true,
        'default'  => array(
            'border-color'  => '#1e73be', 
            'border-style'  => 'solid', 
            'border-top'    => '3px', 
            'border-right'  => '3px', 
            'border-bottom' => '3px', 
            'border-left'   => '3px',
            'border-width'   => 5
        )
    ),*/
    static function Border($field)
    {
        $borderStyleArr = array('solid','dotted','dashed','none');

        $default_array = is_array(self::$old_field_value) ? self::$old_field_value : array() ;
        $default_border_color = !empty($default_array['border-color']) ? $default_array['border-color'] : '' ;
        $default_border_style = !empty($default_array['border-style']) ? $default_array['border-style'] : '' ;
        $default_border_top = !empty($default_array['border-top']) ? $default_array['border-top'] : '' ;
        $default_border_right = !empty($default_array['border-right']) ? $default_array['border-right'] : '' ;
        $default_border_bottom = !empty($default_array['border-bottom']) ? $default_array['border-bottom'] : '' ;
        $default_border_left = !empty($default_array['border-left']) ? $default_array['border-left'] : '' ;
        $default_border_all = !empty($default_array['border-all']) ? $default_array['border-all'] : '' ;
        $default_width = !empty($default_array['width']) ? $default_array['width'] : '' ;

        $border_all = isset($field['all']) ? $field['all']  : true ;
        $border_left = isset($field['left']) ? $field['left']  : true ;
        $border_right = isset($field['right']) ? $field['right']  : true ;
        $border_top = isset($field['top']) ? $field['top']  : true ;
        $border_bottom = isset($field['bottom']) ? $field['bottom']  : true ;
        $border_style = isset($field['style']) ? $field['style']  : true ;
        $border_color = isset($field['color']) ? $field['color']  : true ;
        
        $html[] = '<div class="row">';

        if ($border_top) {
            $html[] ='
            <div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-up"></i></span>
                    <input name="'.self::$field_name.'[border-top]" id="'.self::$field_id.'_border_top" type="text" value="'.$default_border_top.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($border_right) {
            $html[] ='
            <div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-right"></i></span>
                    <input name="'.self::$field_name.'[border-right]" id="'.self::$field_id.'_border_right" type="text" value="'.$default_border_right.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($border_bottom) {
            $html[] ='<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-down"></i></span>
                    <input name="'.self::$field_name.'[border-bottom]" id="'.self::$field_id.'_border_bottom" type="text" value="'.$default_border_bottom.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($border_left) {
            $html[] ='<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-left"></i></span>
                    <input name="'.self::$field_name.'[border-left]" id="'.self::$field_id.'_border_left" type="text" value="'.$default_border_left.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($border_all) {
            $html[] ='
            <div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-expand-arrows-alt"></i></span>
                    <input name="'.self::$field_name.'[border-all]" id="'.self::$field_id.'_border_all" type="text" value="'.$default_border_all.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($border_color) {
            $html[] = '<div class="col-3">
                <div class="example">
                    <input name="'.self::$field_name.'[border-color]" id="'.self::$field_id.'_border_color" type="text" value="'.$default_border_color.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($border_style) {
            $html[] = '<div class="col-3">
                <select name="'.self::$field_name.'[border-style]" id="'.self::$field_id.'_border-style" class="form-control  w3o-depend  '.self::$field_class.'"  data-depend-id="'.self::$field_id.'">';
                $html[] = '<option value="">Border Style</option>';
                foreach ($borderStyleArr as $value) {
                    $styleChecked = ($value == $default_border_style) ? 'selected="selected"' : '';
                    $html[] = '<option value="'.$value.'" '.$styleChecked.'>'.ucwords(str_replace('-',' ',$value)).'</option>';
                }
            $html[] = '
                </select>
            </div>';
        }

        $html[] = '</div>';
        return $html = implode(' ', $html);

    }

    /* Option Array = array(
        'id'       => 'opt-color-box-shadow',
        'type'     => 'box_shadow',
        'output'   => array( '.site-header' ),
        'title'       => __( 'Box Shadow' ),
        'subtitle'    => __( 'Site Header Box Shadow with inset and drop shadows.' ),
        'desc'        => __( 'This is the description field, again good for additional info.' ),
        'inset-shadow' => false,
        'drop-shadow' => false,
        'default' => array(
                    'inset-shadow' => array(
                        'checked'=>true,
                        'color'=>'#dddddd',
                        'horizontal'=>'15',
                        'vertical'=>'15',
                        'blur'=>'15',
                        'spread'=>'15',
                    ),
                )
    ),*/
    static function BoxShadow($field)
    {
        $default_array = is_array(self::$old_field_value) ? self::$old_field_value : array() ;
        $inset_shadow = isset($field['inset-shadow']) ? $field['inset-shadow'] : true ;
        $drop_shadow = isset($field['inset-shadow']) ? $field['inset-shadow'] : true ;
        $preview_color = isset($field['preview_color']) ? $field['preview_color'] : '#f1f1f1' ;
        
        $defaultInsetShadowArr = !empty($default_array['inset-shadow']) ? $default_array['inset-shadow'] : array() ;
        $inset_checked = isset($defaultInsetShadowArr['checked']) ? $defaultInsetShadowArr['checked'] : true ;
        $inset_checked = ($inset_checked == true) ? 'checked="checked"' : '' ;
        $inset_color = !empty($defaultInsetShadowArr['color']) ? $defaultInsetShadowArr['color'] : '#b5b5b5' ;
        $inset_horizontal = !empty($defaultInsetShadowArr['horizontal']) ? $defaultInsetShadowArr['horizontal'] : '' ;
        $inset_vertical = !empty($defaultInsetShadowArr['vertical']) ? $defaultInsetShadowArr['vertical'] : '' ;
        $inset_blur = !empty($defaultInsetShadowArr['blur']) ? $defaultInsetShadowArr['blur'] : 0 ;
        $inset_spread = !empty($defaultInsetShadowArr['spread']) ? $defaultInsetShadowArr['spread'] : '' ;
        
        $defaultDropShadowArr = !empty($default_array['drop-shadow']) ? $default_array['drop-shadow'] : array() ;
        $drop_checked = isset($defaultDropShadowArr['checked']) ? $defaultDropShadowArr['checked'] : true ;
        $drop_checked = ($drop_checked == true) ? 'checked="checked"' : '' ;
        $drop_color = !empty($defaultDropShadowArr['color']) ? $defaultDropShadowArr['color'] : '#b5b5b5' ;
        $drop_horizontal = !empty($defaultDropShadowArr['horizontal']) ? $defaultDropShadowArr['horizontal'] : '' ;
        $drop_vertical = !empty($defaultDropShadowArr['vertical']) ? $defaultDropShadowArr['vertical'] : '' ;
        $drop_blur = !empty($defaultDropShadowArr['blur']) ? $defaultDropShadowArr['blur'] : 0 ;
        $drop_spread = !empty($defaultDropShadowArr['spread']) ? $defaultDropShadowArr['spread'] : '' ;


        $html[] = '<div class="row BoxShadowContainer" >';

        if ($inset_shadow) {
            $html[] = '
            <div class="col-6">
                <div class="form-check form-group ">
                    <input name="'.self::$field_name.'[inset-shadow][checked]" value="0" type="hidden">
                    <input name="'.self::$field_name.'[inset-shadow][checked]" class="w3o-depend  '.self::$field_class.' inset-shadow form-check-input" value="1" type="checkbox" id="'.self::$field_id.'_inset_shadow" '.$inset_checked.' data-depend-id="'.self::$field_id.'">
                    <label class="control-label form-check-label" for="'.self::$field_id.'_inset_shadow">Inset Shadow</label>
                </div>
                <div class="form-group ">
                    <input name="'.self::$field_name.'[inset-shadow][color]" id="'.self::$field_id.'_inset_shadow_color" type="text" value="'.$inset_color.'" class="as_colorpicker inset-shadow-color form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_inset_shadow_horizontal">Inset Shadow Horizontal : <span class="inset-horizontal-value"></span></label>
                    <input name="'.self::$field_name.'[inset-shadow][horizontal]" class="w3o-depend  '.self::$field_class.' inset-shadow-horizontal w-100" value="'.$inset_horizontal.'" type="range" id="'.self::$field_id.'_inset_shadow_horizontal" min="-50" max="50" data-depend-id="'.self::$field_id.'">
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_inset_shadow_vertical">Inset Shadow Vertical : <span class="inset-vertical-value"></span></label>
                    <input name="'.self::$field_name.'[inset-shadow][vertical]" class="w3o-depend  '.self::$field_class.' inset-shadow-vertical w-100" value="'.$inset_vertical.'" type="range" id="'.self::$field_id.'_inset_shadow_vertical" min="-50" max="50" data-depend-id="'.self::$field_id.'">
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_inset_shadow_blur">Inset Shadow Blur : <span class="inset-blur-value"></span></label>
                    <input name="'.self::$field_name.'[inset-shadow][blur]" class="w3o-depend  '.self::$field_class.' inset-shadow-blur w-100" value="'.$inset_blur.'" type="range" id="'.self::$field_id.'_inset_shadow_blur" min="0" max="50" data-depend-id="'.self::$field_id.'">
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_inset_shadow_spread">Inset Shadow Spread : <span class="inset-spread-value"></span></label>
                    <input name="'.self::$field_name.'[inset-shadow][spread]" class="w3o-depend  '.self::$field_class.' w-100 inset-shadow-spread" value="'.$inset_spread.'" type="range" id="'.self::$field_id.'_inset_shadow_spread" min="-50" max="50" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }

        if ($drop_shadow) {
            $html[] = '
            <div class="col-6">
                <div class="form-check form-group ">
                    <input name="'.self::$field_name.'[drop-shadow][checked]" value="0" type="hidden">
                    <input name="'.self::$field_name.'[drop-shadow][checked]" class="w3o-depend  '.self::$field_class.' drop-shadow form-check-input" value="1" type="checkbox" id="'.self::$field_id.'_drop_shadow" '.$drop_checked.' data-depend-id="'.self::$field_id.'">
                    <label class="control-label form-check-label" for="'.self::$field_id.'_drop_shadow">Drop Shadow</label>
                </div>
                <div class="form-group ">
                    <input name="'.self::$field_name.'[drop-shadow][color]" id="'.self::$field_id.'_drop_shadow_color" type="text" value="'.$drop_color.'" class="as_colorpicker drop-shadow-color form-control w3o-depend  '.self::$field_class.'" >
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_drop_shadow_horizontal">Drop Shadow Horizontal : <span class="drop-horizontal-value"></span></label>
                    <input name="'.self::$field_name.'[drop-shadow][horizontal]" class="w3o-depend  '.self::$field_class.' drop-shadow-horizontal w-100" value="'.$drop_horizontal.'" type="range" id="'.self::$field_id.'_drop_shadow_horizontal" min="-50" max="50" data-depend-id="'.self::$field_id.'">
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_drop_shadow_vertical">Drop Shadow Vertical : <span class="drop-vertical-value"></span></label>
                    <input name="'.self::$field_name.'[drop-shadow][vertical]" class="w3o-depend  '.self::$field_class.' drop-shadow-vertical w-100" value="'.$drop_vertical.'" type="range" id="'.self::$field_id.'_drop_shadow_vertical" min="-50" max="50" data-depend-id="'.self::$field_id.'">
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_drop_shadow_blur">Drop Shadow Blur : <span class="drop-blur-value"></span></label>
                    <input name="'.self::$field_name.'[drop-shadow][blur]" class="w3o-depend  '.self::$field_class.' drop-shadow-blur w-100" value="'.$drop_blur.'" type="range" id="'.self::$field_id.'_drop_shadow_blur" min="0" max="50" data-depend-id="'.self::$field_id.'">
                </div>
                <div class="form-group ">
                    <label class="control-label mb-0" for="'.self::$field_id.'_drop_shadow_spread">Drop Shadow Spread : <span class="drop-spread-value"></span></label>
                    <input name="'.self::$field_name.'[drop-shadow][spread]" class="w3o-depend  '.self::$field_class.' drop-shadow-spread w-100" value="'.$drop_spread.'" type="range" id="'.self::$field_id.'_drop_shadow_spread" min="-50" max="50" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }

        $html[] = '
            <div class="col-12">
                <div class="ShadowBoxPreview mw-100 mb-3 transition-fast" style="height:150px;width:100%;background:'.$preview_color.';">

                </div>
            </div>
        </div>';

        return $html = implode(' ', $html);
    }

    /* Option Array = array(
        'id'       => 'button-set-single',
        'type'     => 'button_set',
        'title'    => __('Button Set, Single'),
        'subtitle' => __('No validation can be done on this field type'),
        'desc'     => __('This is the description field, again good for additional info.'),
        //Must provide key => value pairs for options
        'options' => array(
            '1' => 'Opt 1', 
            '2' => 'Opt 2', 
            '3' => 'Opt 3'
         ), 
        'default' => '2'
    ) */
    static function ButtonSet($field = array())
    {
        $multi = isset($field['multi']) ? $field['multi'] : false;
        $field_value_arr = is_array(self::$old_field_value) && ($multi == true) ? self::$old_field_value : array() ;
        $field_value = !is_array(self::$old_field_value) && ($multi == false) ? self::$old_field_value : '' ;
        $button_set_class = $multi == true ? 'checkbox' : 'radio' ;
        $html = array();

        if(!empty(self::$field_options)){

            $html[] = '<div class="btn-group dz-btn-group" role="group" aria-label="Basic '.$button_set_class.' toggle button group">';
                
            foreach(self::$field_options as $optionKey => $optionValue){
                if ($multi == true) {
                    $checked = in_array($optionKey, $field_value_arr) ? 'checked="checked"' : '';
                    $active = in_array($optionKey, $field_value_arr) ? 'active' : '';
                    
                    $html[] = '
                        <input type="checkbox" class="w3o-depend  '.self::$field_class.' btn-check" name="'.self::$field_name.'[]" id="'.self::$field_id.'_'.$optionKey.'" value="'.$optionKey.'" '.$checked.'  data-depend-id="'.self::$field_id.'">
                        <label class="btn btn-outline-primary" for="'.self::$field_id.'_'.$optionKey.'">'.$optionValue.'</label>';
                }
                else {
                    $checked = $optionKey == $field_value ? 'checked="checked"' : '';
                    $active = $optionKey == $field_value ? 'active' : '';
                    
                    $html[] = '
                        <input type="radio" class="w3o-depend  '.self::$field_class.' btn-check" name="'.self::$field_name.'" id="'.self::$field_id.'_'.$optionKey.'" value="'.$optionKey.'" '.$checked.'  data-depend-id="'.self::$field_id.'">
                        <label class="btn btn-outline-primary" for="'.self::$field_id.'_'.$optionKey.'">'.$optionValue.'</label>';

                }
            }

            $html[] = '</div>';
            return $html = implode(' ', $html);
            
        }else{
            return 'No items of this type were found.';
        }
    }

    /* Option Array = array(
        'id'       => 'opt_checkbox',
        'type'     => 'checkbox',
        'title'    => __('Checkbox Option'), 
        'subtitle' => __('No validation can be done on this field type'),
        'desc'     => __('This is the description field, again good for additional info.'),
        'default'  => '1'// 1 = on | 0 = off
    ),*/
    static function Checkbox($field)
    {
        $checkbox_value = $field['default'] ??  1 ;
        $checkbox_old_value = self::$old_field_value ??  '' ;

        $checked = ($checkbox_old_value == $checkbox_value) ? 'checked="checked"' : '';
        
        return '<div class="form-check checkbox">
                    <input name="'.self::$field_name.'" value="0" type="hidden">
                    <input name="'.self::$field_name.'" class="w3o-depend  '.self::$field_class.' form-check-input" value="'.$checkbox_value.'" type="checkbox" id="'.self::$field_id.'" '.$checked.' data-depend-id="'.self::$field_id.'">
                </div>';
        
    }

    /* Option Array = array(
        'id' => 'checkbox_multi_field',
        'type' => 'checkbox_multi',
        'title' => __( 'checkbox multi field' ),
        'subtitle' => __( 'this is a multi checkbox' ),
        'desc' => __( 'multi checkbox' ),
        'class' => 'additional-class',
        'options' => array(
            'male' => 'Male',
            'female' => 'Female',
            'child' => 'Child'
        ),
        'default' => array('female')
    ),*/
    static function CheckboxMulti($field)
    {
        $checkboxFields = is_array(self::$field_options) ? self::$field_options : array();
        $old_field_value = is_array(self::$old_field_value) ? self::$old_field_value : explode(',', self::$old_field_value) ;

        if(!empty($checkboxFields)){

            foreach ($checkboxFields as $checkboxKey => $checkboxValue) {

                $checked = (in_array($checkboxKey, $old_field_value)) ? 'checked="checked"' : '';
                
                $html[] = '<div class="form-check checkbox">
                                <input name="'.self::$field_name.'[]" class="w3o-depend  '.self::$field_class.' form-check-input" value="'.$checkboxKey.'" type="checkbox" id="'.self::$field_id.'_'.$checkboxKey.'" '.$checked.' data-depend-id="'.self::$field_id.'">
                                <label class="control-label form-check-label" for="'.self::$field_id.'_'.$checkboxKey.'">'.$checkboxValue.'</label>
                            </div>';
            }
            return $html = implode(' ', $html);
        }else{
            return 'No items of this type were found.';
        }
    }

    /* Option Array = array(
        'id'       => 'opt-color',
        'type'     => 'color',
        'title'    => __('Body Background Color'), 
        'subtitle' => __('Pick a background color for the theme (default: #fff).'),
        'default'  => '#FFFFFF',
    )*/ 
    static function Color($field)
    {
        $old_field_value = self::$old_field_value;

        return '<div class="example">
                    <input name="'.self::$field_name.'" id="'.self::$field_id.'" type="text" value="'.$old_field_value.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>';
    }

    /* Option Array = array(
        'id'       => 'opt-color',
        'type'     => 'color_gradient',
        'title'    => __('Body Background Color'), 
        'subtitle' => __('Pick a background color for the theme (default: #fff).'),
        'default'  => '#ff0000',
    ),*/
    static function ColorGradient($field)
    {
        $old_field_value = self::$old_field_value;

        return '<div class="example">
                    <input name="'.self::$field_name.'" id="'.self::$field_id.'" type="text" value="'.$old_field_value.'" class="as_colorpicker_gradient form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>';
    }

    /* Option Array = array(
        'id'          => 'opt-date',
        'type'        => 'date',
        'title'       => __('Date Option'), 
        'subtitle'    => __('No validation can be done on this field type'),
        'desc'        => __('This is the description field, again good for additional info.'),
        'placeholder' => 'Click to enter a date'
    )*/ 
    static function Date($field)
    {
        $old_field_value = self::$old_field_value;
        return '<input type="text" class="w3o-depend  '.self::$field_class.' datetimepicker form-control" name="'.self::$field_name.'" id="'.self::$field_id.'" value="'.$old_field_value.'" data-depend-id="'.self::$field_id.'">';
    }

    /* Option Array = array(
        'id'       => 'opt_dimensions',
        'type'     => 'dimensions',
        'title'    => __('Dimensions (Width/Height) Option'),
        'subtitle' => __('Allow your users to choose width, height, and/or unit.'),
        'desc'     => __('Enable or disable any piece of this field. Width, Height, or Units.'),
        'units'    => array('em','px','%'),
        'default'  => array(
            'Width'   => '200', 
            'Height'  => '100'
        ),
    )*/
    static function Dimensions($field)
    {
        $unit_options = !empty($field['units']) && is_array($field['units']) ? $field['units'] : array('px');
        
        $width = isset($field['width']) ? $field['width'] : true;
        $height = isset($field['height']) ? $field['height'] : true;
        
        $default_units = is_array(self::$old_field_value) && !empty(self::$old_field_value['units']) ? self::$old_field_value['units'] : 'px';
        $default_width = is_array(self::$old_field_value) && !empty(self::$old_field_value['width']) ? self::$old_field_value['width'] : 0;
        $default_height = is_array(self::$old_field_value) && !empty(self::$old_field_value['height']) ? self::$old_field_value['height'] : 0;
        $html = array();

        $html[] = '<div class="row">';
        if ($height) {
            $html[] = '<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-arrows-left-right"></i></span>
                    <input name="'.self::$field_name.'[height]" id="'.self::$field_id.'_height" type="text" value="'.$default_height.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($width) {
            $html[] = '<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-arrows-up-down"></i></span>
                    <input name="'.self::$field_name.'[width]" id="'.self::$field_id.'_width" type="text" value="'.$default_width.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
            
        $html[] = '<div class="col-3">
                <select name="'.self::$field_name.'[units]" id="'.self::$field_id.'_units" class="form-control  w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">';
                $html[] = '<option value="">Units</option>';
        if (!empty($unit_options)) {
            foreach ($unit_options as $option) {
                $checked = ($default_units == $option) ? 'selected' : '';
                $html[] = '<option value="'.$option.'" '.$checked.'>'.$option.'</option>';
            }
        }

        $html[] = '</select>
            </div>
        </div>';

        return $html = implode(' ', $html);
    }

    /* Option Array = array(
        'id'               => 'editor-text',
        'type'             => 'editor',
        'title'            => __('Editor Text'), 
        'subtitle'         => __('Subtitle text would go here.'),
        'default'          => 'Powered by W3cms.',
    ),*/
    static function Editor($field)
    {
        return '<div class="form-group">
                    <textarea name="'.self::$field_name.'" class="form-control ThemeOptionsEditor h-auto w3o-depend  '.self::$field_class.'" id="'.self::$field_id.'" rows="10" data-depend-id="'.self::$field_id.'">
                        '.self::$old_field_value.'
                    </textarea>
                </div>';
    }

    /* Option Array = array(
        'id'               => 'editor-text',
        'type'             => 'editor',
        'title'            => __('Editor Text'), 
        'subtitle'         => __('Subtitle text would go here.'),
        'default'          => 'Powered by W3cms.',
    ),*/
    static function Gallery($field)
    {
        $fieldValues = !empty(self::$old_field_value) ? self::$old_field_value : '' ;
        $fieldValuesArr = !empty($fieldValues) ? explode(',', $fieldValues) : '' ;
        $placeholder = !empty($field['placeholder']) ? $field['placeholder'] : 'No media selected';
        $mode = !empty($field['mode']) ? $field['mode'] : 'image/*';
        $height = !empty($field['height']) ? $field['height'] : 'auto';
        $width = !empty($field['width']) ? $field['width'] : '150';
        $alt = !empty($field['alt']) ? $field['alt'] : 'Image';
        
        $html[] = '<div class="img-parent-box">';

        if(!empty($fieldValuesArr)){
            $html[] = '<div class="row mb-2">';

            foreach ($fieldValuesArr as $fieldValue) {
                if (file_exists(storage_path('app/public/'.self::$options_type.'/'.$fieldValue))) {
                    $html[] = '
                    <div class="col-sm-4 RemoveElementImage custom-image-delete">
                        <img src="'.asset('storage/'.self::$options_type.'/'.$fieldValue).'" class="mw-100 img-for-onchange rounded object-fit-cover" alt="'.$alt.'" width="'.$width.'" height="'.$height.'">
                        <!-- <a href="'.url('/').'/admin/magic_editors/remove_image" class="RemoveElementImage delete-btn text-danger" rel="'.self::$field_id.'_hidden" val="'.$fieldValue.'"><i class="fa fa-times"></i></a> -->
                    </div>';
                }
            }
            $html[] = '</div>';
        }else{
            $html[] = '<img class="mb-2 mw-100 img-for-onchange" width="'.$width.'" height="'.$height.'" src="'.asset('images/noimage.jpg').'"  alt="'.$alt.'">';
        }

        $html[] = '
                <input type="hidden" name="'.self::$field_name.'" id="'.self::$field_id.'_hidden" value="'.$fieldValues.'">
                <input type="file" name="'.self::$field_name.'[]" class="ps-2 form-control img-input-onchange w3o-depend  '.self::$field_class.'" placeholder="'.$placeholder.'" id="'.self::$field_id.'" accept="'.$mode.'"  data-depend-id="'.self::$field_id.'" multiple />
            </div>
            ';

        return $html = implode(' ', $html);
    }

    /* Option Array = array(
        'id'       => 'opt-layout',
        'type'     => 'image_select',
        'title'    => __('Main Layout'), 
        'subtitle' => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.'),
        'options'  => array(
            '1'      => array(
                'alt'   => '1 Column', 
                'img'   => ReduxFramework::$_url.'assets/img/1col.png'
            ),
            '2'      => array(
                'alt'   => '2 Column Left', 
                'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
            ),
            '3'      => array(
                'alt'   => '2 Column Right', 
                'img'  => ReduxFramework::$_url.'assets/img/2cr.png'
            ),
        ),
        'default' => '2'
    ) */
    static function ImageSelect($field)
    {
        $radioFields = is_array(self::$field_options) ? self::$field_options : array();
        $radioFieldsVal = is_array(self::$old_field_value) ? self::$old_field_value : explode(',', self::$old_field_value) ;
        $height = !empty($field['height']) ? $field['height'] : 'auto';
        $width = $height == 'auto' ? '100%' : 'auto';
        $html = array();

        if (!empty($radioFields)) {
            foreach ($radioFields as $radioKey => $radioValue){
                if (is_array($radioValue) && !empty($radioValue)){

                    $checked = (in_array($radioKey, $radioFieldsVal)) ? 'checked="checked"' : '';
                    $img_title = !empty($radioValue['title']) ? '<span class="label-title">'.$radioValue['title'].'</span>' : ''; 
                    
                    $html[] = '<div class="radio dz-mediaradio">
                        <input name="'.self::$field_name.'" value="'.$radioKey.'" class="w3o-depend  '.self::$field_class.' form-check-input" type="radio" id="'.self::$field_id.'_'.$radioKey.'" '.$checked.' data-depend-id="'.self::$field_id.'">
                        <label class="control-label" for="'.self::$field_id.'_'.$radioKey.'">
                            <img src="'.($radioValue['img'] ?? asset('images/noimage.jpg')).'" class="object-fit-contain mw-100" width="'.$width.'" height="'.$height.'" style="max-height:150px">
                            '.$img_title.'
                        </label>
                    </div>';
                } else {
                    $checked = (in_array($radioKey, $radioFieldsVal)) ? 'checked="checked"' : '';

                    $html[] ='<div class="radio dz-mediaradio">
                        <input name="'.self::$field_name.'" value="'.$radioKey.'" class="w3o-depend  '.self::$field_class.' form-check-input" type="radio" id="'.self::$field_id.'_'.$radioKey.'" '.$checked.' data-depend-id="'.self::$field_id.'">
                        <label class="control-label" for="'.self::$field_id.'_'.$radioKey.'">
                            <img src="'.$radioValue.'" class="object-fit-contain mw-100" width="'.$width.'" height="'.$height.'">
                        </label>
                    </div>';
                }
            }

            return $html = implode(' ', $html);
        }else{
            return 'No items of this type were found.';
        }
    }

    /* Option Array = array(
        'id'       => 'opt-link-color',
        'type'     => 'link_color',
        'title'    => __('Links Color Option'),
        'subtitle' => __('Only color validation can be done on this field type'),
        'desc'     => __('This is the description field, again good for additional info.'),
        'default'  => array(
            'regular'  => '#1e73be', // blue
            'hover'    => '#dd3333', // red
            'active'   => '#8224e3',  // purple
            'visited'  => '#8224e3',  // purple
        )
    )*/ 
    static function LinkColor($field)
    {
        $regular = isset($field['regular']) ? $field['regular'] : true;
        $hover = isset($field['hover']) ? $field['hover'] : true;
        $active = isset($field['active']) ? $field['active'] : true;
        $visited = isset($field['visited']) ? $field['visited'] : true;

        $default_regular = is_array(self::$old_field_value) && !empty(self::$old_field_value['regular']) ? self::$old_field_value['regular'] : 0;
        $default_hover = is_array(self::$old_field_value) && !empty(self::$old_field_value['hover']) ? self::$old_field_value['hover'] : 0;
        $default_active = is_array(self::$old_field_value) && !empty(self::$old_field_value['active']) ? self::$old_field_value['active'] : 0;
        $default_visited = is_array(self::$old_field_value) && !empty(self::$old_field_value['visited']) ? self::$old_field_value['visited'] : 0;

        $html[] = '<div class="row">';

        if ($regular) {
            $html[] = '
            <div class="col-sm-3">
                <label class="control-label form-check-label" for="'.self::$field_id.'_regular">Regular</label>
                <input name="'.self::$field_name.'[regular]" id="'.self::$field_id.'_regular" type="text" value="'.$default_regular.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
            </div>';
        }
        if ($hover) {
            $html[] = '
            <div class="col-sm-3">
                <label class="control-label form-check-label" for="'.self::$field_id.'_hover">Hover</label>
                <input name="'.self::$field_name.'[hover]" id="'.self::$field_id.'_hover" type="text" value="'.$default_hover.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
            </div>';
        }
        if ($active) {
            $html[] = '
            <div class="col-sm-3">
                <label class="control-label form-check-label" for="'.self::$field_id.'_active">Active</label>
                <input name="'.self::$field_name.'[active]" id="'.self::$field_id.'_active" type="text" value="'.$default_active.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
            </div>';
        }
        if ($visited) {
            $html[] = '
            <div class="col-sm-3">
                <label class="control-label form-check-label" for="'.self::$field_id.'_visited">Visited</label>
                <input name="'.self::$field_name.'[visited]" id="'.self::$field_id.'_visited" type="text" value="'.$default_visited.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
            </div>';
        }

        $html[] = '</div>';

        return $html = implode(' ', $html);
    }

    /* Option Array = array(
        'id'       => 'opt-media',
        'type'     => 'media', 
        'url'      => true,
        'title'    => __('Media w/ URL'),
        'desc'     => __('Basic media uploader with disabled URL input field.'),
        'subtitle' => __('Upload any media using the WordPress native uploader'),
        'default'  => array(
            'url'=>'https://s.wordpress.org/style/images/codeispoetry.png'
        ),
    )*/ 
    static function Media($field)
    {
        $fieldValue = !is_array(self::$old_field_value) && !empty(self::$old_field_value) ? self::$old_field_value : '' ;
        $placeholder = !empty($field['placeholder']) ? $field['placeholder'] : 'No media selected';
        $mode = !empty($field['mode']) ? $field['mode'] : 'image/*';
        $height = !empty($field['height']) ? $field['height'] : 'auto';
        $width = !empty($field['width']) ? $field['width'] : '150';
        $alt = !empty($field['alt']) ? $field['alt'] : 'Image';
        
        $html[] = '<div class="img-parent-box">';

        if(!empty($fieldValue) && file_exists(storage_path('app/public/'.self::$options_type.'/'.$fieldValue))){

            $html[] = '
            <div class="mb-2 ">
                <img src="'.asset('storage/'.self::$options_type.'/'.$fieldValue).'" class="mw-100 img-for-onchange rounded object-fit-cover" alt="'.$alt.'" width="'.$width.'" height="'.$height.'">
            </div>';
        }else{
            $html[] = '<img class="mb-2 mw-100 img-for-onchange" width="'.$width.'" height="'.$height.'" src="'.asset('images/noimage.jpg').'"  alt="'.$alt.'">';
        }

        $html[] = '
                <input type="file" name="'.self::$field_name.'" class="ps-2 form-control img-input-onchange w3o-depend  '.self::$field_class.'" placeholder="'.$placeholder.'" id="'.self::$field_id.'" accept="'.$mode.'"  data-depend-id="'.self::$field_id.'">
                <input type="hidden" name="'.self::$field_name.'" id="'.self::$field_id.'_hidden" value="'.$fieldValue.'">
            </div>
            ';

        return $html = implode(' ', $html);
    }

    /* Option Array = array(
        'id'       => 'select_box_id',
        'type'     => 'select',
        'title'    => __( 'Select Option'), 
        'subtitle' => __( 'No validation can be done on this field type'),
        'desc'     => __( 'This is the description field, again good for additional info.'),
        'options'  => array(
            '1' => 'Opt 1',
            '2' => 'Opt 2',
            '3' => 'Opt 3'),
        'default'  => '2'
    ),*/
    static function Select($field)
    {
        $old_field_value = is_array(self::$old_field_value) ? self::$old_field_value : explode(',', self::$old_field_value) ;
        $html = array();

        if(!empty(self::$field_options)){
            
            $html[] = '<select name="'.self::$field_name.'" id="'.self::$field_id.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                    <option value="">'.$field['title'].'</option>';
                 
            foreach(self::$field_options as $dropdownKey => $dropdownVal){
                $checked = (in_array($dropdownKey, $old_field_value)) ? 'selected="selected"' : '';

                $html[] = '<option value="'.$dropdownKey.'" '.$checked.'>'.$dropdownVal.'</option>';
            }

            $html[] = '</select>';
            return $html = implode(' ', $html);
        }else{
            return 'No items of this type were found.';
        }

    }

    /* Option Array = array(
        'id'       => 'multi_select_box_id',
        'type'     => 'multi_select',
        'title'    => __( 'Multi Select Option'), 
        'subtitle' => __( 'No validation can be done on this field type'),
        'desc'     => __( 'This is the description field, again good for additional info.'),
        'options'  => array(
            '1' => 'Opt 1',
            '2' => 'Opt 2',
            '3' => 'Opt 3'),
        'default'  => array('2','3')
    ),*/
    static function MultiSelect($field)
    {
        
        $old_field_value = is_array(self::$old_field_value) ? self::$old_field_value : explode(',', self::$old_field_value) ;
        $html = array();

        if(!empty(self::$field_options) && is_array(self::$field_options)){
            
            $html[] = '<select name="'.self::$field_name.'[]" id="'.self::$field_id.'" class="form-control w3o-depend  '.self::$field_class.'"  multiple="multiple"  style="height:100px;" data-depend-id="'.self::$field_id.'">
                    <option value="">Select '.$field['title'].'</option>';
                 
            foreach(self::$field_options as $dropdownKey => $dropdownVal){
                $checked = (in_array($dropdownKey, $old_field_value)) ? 'selected="selected"' : '';

                $html[] = '<option value="'.$dropdownKey.'" '.$checked.'>'.$dropdownVal.'</option>';
            }

            $html[] = '</select>';
            return $html = implode(' ', $html);
        }else{
            return 'No items of this type were found.';
        }
    }

    /* Option Array = array(
        'id'        => 'opt-slider-label',
        'type'      => 'slider',
        'title'     => __('Slider Example 1'),
        'subtitle'  => __('This slider displays the value as a label.'),
        'desc'      => __('Slider description. Min: 1, max: 500, step: 1, default value: 250'),
        "default"   => 250,
        "default" => array(// for 2 handles
            1 => 100,
            2 => 300,
        ),
        "min"       => 1,
        "step"      => 1,
        "max"       => 500,
        'display_value' => 'label',
        'handles' => 2, 

    )*/
    static function Slider($field)
    {
        $displayValueArr = array('none','label','text','select');

        $default_value = !is_array(self::$old_field_value) ? self::$old_field_value : 0 ;
        $min = isset($field['min']) && is_int($field['min']) ? $field['min'] : 0 ;
        $max = isset($field['max']) && is_int($field['max']) ? $field['max'] : 0 ;
        $step = isset($field['step']) && is_int($field['step']) ? $field['step'] : 0 ;
        $display_value = isset($field['display_value']) && in_array($field['display_value'], $displayValueArr) ? $field['display_value'] : 'text' ;
        $handles = isset($field['handles']) && ($field['handles'] == 1 || $field['handles'] == 2) ? $field['handles'] : 1 ;
        


        return '
        <div class="row" >
            <div class="col-6">
                <div class="form-group d-flex gap-3 align-items-center">
                    <span class="">'.$default_value.'</span>
                    <input name="'.self::$field_name.'" class="w3o-depend  '.self::$field_class.' w-100 w3options-slider" value="'.$default_value.'" type="range" id="'.self::$field_id.'" min="'.$min.'" max="'.$max.'" step="'.$step.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>
        </div>';
    }

    /* Option Array = array(
        'id'          => 'opt-password',
        'type'        => 'password',
        'username'    => true,
        'title'       => __( 'SMTP Account' ),
        'placeholder' => 'Password Here ...',
        'default'     => '123456'
    )*/
    static function Password($field)
    {
        $placeholder = !empty($field['placeholder']) ? $field['placeholder'] : '';

        return '<input name="'.self::$field_name.'" class="w3o-depend  '.self::$field_class.' form-control " placeholder="'.$placeholder.'" value="'.self::$old_field_value.'" type="password" id="'.self::$field_id.'" data-depend-id="'.self::$field_id.'">';
    }

    /* Option Array = array(
        'id' => 'radio_field',
        'type' => 'radio',
        'title' => __( 'radio box' ),
        'subtitle' => __( 'radio_field subt' ),
        'desc' => __( 'radio_field desc' ),
        'class' => 'radio_field_class',
        'options' => array(
            '1' => 'dsds',
            '2' => 'ds',
            '3' => 'sds'
        ),
        'default' => '2'
    ),*/
    static function Radio($field)
    {
        $radioDataFields = !empty($field['data']) && is_array($field['data']) ? $field['data'] : array();
        $radioFields = !empty(self::$field_options) && is_array(self::$field_options) ? self::$field_options : $radioDataFields ;
        $radioFieldsVal = !is_array(self::$old_field_value) ? self::$old_field_value : '' ;
        $html = array();

        if (!empty($radioFields)) {

            foreach ($radioFields as $radioKey => $radioValue) {
                $checked = ($radioKey == $radioFieldsVal) ? 'checked="checked"' : '';
                    
                $html[] = '
                <div class="radio">
                    <input name="'.self::$field_name.'" class="form-check-input w3o-depend  '.self::$field_class.'" value="'.$radioKey.'" type="radio" id="'.self::$field_id.'_'.$radioKey.'" '.$checked.' data-depend-id="'.self::$field_id.'">
                    <label class="control-label form-check-label" for="'.self::$field_id.'_'.$radioKey.'">'.$radioValue.'</label>
                </div>';
            }

            return $html = implode(' ', $html);
        }else{
            return 'No items of this type were found.';
        }
    }

    /* Option Array = array(
        'id'       => 'opt-select-image',
        'type'     => 'select_image',
        'title'    => __('Select Image'),
        'subtitle' => __('A preview of the selected image will appear underneath the select box.'),
        'desc'     => __('This is the description field, again good for additional info.'),
        'options'  => array(
            array (
                 'alt'  => 'Image Name 1',
                 'img'  => asset('themes/frontend/finbiz/images/contact/01.png'),
            ),
            array (
                 'alt'  => 'Image Name 2',
                 'img'  => asset('themes/frontend/finbiz/images/coming-soon/style-1.png'),
            )
        ),
        'default'  => asset('themes/frontend/finbiz/images/coming-soon/style-1.png'),
    ),*/
    static function SelectImage($field)
    {
        if (!empty(self::$field_options)) {
            $old_values = !is_array(self::$old_field_value)  ? self::$old_field_value : '' ;

            $html[] = '<div class="SelectImageContainer">
                    <select name="'.self::$field_name.'" id="'.self::$field_id.'" class="form-control w-auto  w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">';

            $html[] = '<option value="">'.$field['title'].'</option>';
            foreach (self::$field_options as $option) {
                $img = !empty($option['img']) ? $option['img'] : '';
                $title = !empty($option['alt']) ? $option['alt'] : '';
                $checked = ($img == $old_values) ? 'selected="selected"' : '';

                $html[] = '<option value="'.$img.'" '.$checked.'>'.$title.'</option>';
            }

            $image = !empty($field['default']) ? $field['default'] : asset('images/noimage.jpg') ;

            $html[] = '</select>
                    <img class="mw-100 d-block my-3" src="'.$image.'" width="auto" height="200px">
            </div>';

            return $html = implode(' ', $html);
        }else {
            return 'No items of this type were found.';
        }
    }

    /* Option Array = array(
        'id' => 'switch_field',
        'type' => 'switch',
        'title' => __('Switch Field') ,
        'subtitle' => __('Show or hide the button.') ,
        'on' => __('Enabled') ,
        'off' => __('Disabled') ,
        'default' => false,
    ),*/
    static function Switch($field)
    {
        $on_text = !empty($field['on']) ? $field['on'] : 'on';   
        $off_text = !empty($field['off']) ? $field['off'] : 'off'; 
        $on_checked = self::$old_field_value == true || self::$old_field_value == 1 ? 'checked' : '';   
        $off_checked = self::$old_field_value == false || self::$old_field_value == 0 ? 'checked' : '';   
          

        return $html = '
                    <div class="btn-group dz-btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="w3o-depend  '.self::$field_class.' btn-check" value="1" name="'.self::$field_name.'" id="'.self::$field_id.'_on" '.$on_checked.' data-depend-id="'.self::$field_id.'">
                        <label class="btn btn-outline-primary" for="'.self::$field_id.'_on">'.$on_text.'</label>

                        <input type="radio" class="btn-check w3o-depend  '.self::$field_class.'" value="0" name="'.self::$field_name.'" id="'.self::$field_id.'_off" '.$off_checked.' data-depend-id="'.self::$field_id.'">
                        <label class="btn btn-outline-primary" for="'.self::$field_id.'_off">'.$off_text.'</label>
                    </div>';
    }

    /* Option Array = array(
        'id'      => 'homepage-blocks',
        'type'    => 'sorter',
        'title'   => 'Homepage Layout Manager',
        'desc'    => 'Organize how you want the layout to appear on the homepage',
        'options' => array(
            'enabled'  => array(
                'highlights' => 'Highlights',
                'slider'     => 'Slider',
                'staticpage' => 'Static Page',
                'services'   => 'Services'
            ),
            'disabled' => array(
            )
        ),
    )*/
    static function Sorter($field)
    {
        $blocksArray = !empty(self::$old_field_value) && is_array(self::$old_field_value) ? self::$old_field_value : self::$field_options;
     
        $html = '<div class="w3options-sorter-section">';
        
        if (!empty($blocksArray) && is_array($blocksArray)) {
            foreach ($blocksArray as $blockTitle => $elementsArr) {
                $html .= '
                <div class="w3options-sorter-block">
                    <h4 class="block-title">'.$blockTitle.'</h4>
                        <input type="hidden" name="'.self::$field_name.'['.$blockTitle.']" value="">

                    <ul data-id="'.$blockTitle.'" class="sorter-list w3options-sorter-list" data-field-name="'.self::$field_name.'">';
                        if (!empty($elementsArr) && is_array($elementsArr)) {
                            foreach ($elementsArr as $elementsKey => $elementsTitle) {
                                $html .= '<li class="sorter-item" data-id="'.$elementsKey.'">'.$elementsTitle.'
                                    <input type="hidden" name="'.self::$field_name.'['.$blockTitle.']['.$elementsKey.']" value="'.$elementsTitle.'">
                                </li>';
                            }
                        }
                    $html .= '</ul>
                </div>';
            }
        }
            
        $html .= '</div>';

        return $html;
    }

    /* Option Array = array(
        'id'             => 'opt-spacing',
        'type'           => 'spacing',
        'mode'           => 'margin',
        'units'          => array('em', 'px'),
        'title'          => __('Padding/Margin Option'),
        'subtitle'       => __('Allow your users to choose the spacing or margin they want.'),
        'desc'           => __('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.'),
        'all'            => true,
        'default'            => array(
            'margin-top'     => '1px', 
            'margin-right'   => '2px', 
            'margin-bottom'  => '3px', 
            'margin-left'    => '4px',
            'units'          => 'em', 
        )
    ),*/
    static function Spacing($field)
    {
        $default_array = is_array(self::$old_field_value) ? self::$old_field_value : array() ;
        $display_units = isset($field['display_units']) ? $field['display_units']  : true ;
        $units = !empty($field['units']) && is_array($field['units']) ? $field['units']  : array('px') ;
        $mode = !empty($field['mode']) ? $field['mode']  : 'padding' ;
        
        $top = isset($field['top']) ? $field['top']  : true ;
        $bottom = isset($field['bottom']) ? $field['bottom']  : true ;
        $left = isset($field['left']) ? $field['left']  : true ;
        $right = isset($field['right']) ? $field['right']  : true ;
        $all = isset($field['all']) ? $field['all']  : false ;

        $default_all = !empty($default_array['all']) ? $default_array['all'] : 0;
        $default_right = !empty($default_array['right']) ? $default_array['right'] : 0;
        $default_left = !empty($default_array['left']) ? $default_array['left'] : 0;
        $default_bottom = !empty($default_array['bottom']) ? $default_array['bottom'] : 0;
        $default_top = !empty($default_array['top']) ? $default_array['top'] : 0;
        $default_units = !empty($default_array['units']) ? $default_array['units'] : 'px';
        

        $html[] = '<div class="row">
        <input type="hidden" name="'.self::$field_name.'[mode]" value="'.$mode.'">
        ';
        if ($top) {
            $html[] = '<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-up"></i></span>
                    <input name="'.self::$field_name.'[top]" id="'.self::$field_id.'_top" type="text" value="'.$default_top.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($right) {
            $html[] = '<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-right"></i></span>
                    <input name="'.self::$field_name.'[right]" id="'.self::$field_id.'_right" type="text" value="'.$default_right.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($bottom) {
            $html[] = '<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-down"></i></span>
                    <input name="'.self::$field_name.'[bottom]" id="'.self::$field_id.'_bottom" type="text" value="'.$default_bottom.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($left) {
            $html[] = '<div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-arrow-left"></i></span>
                    <input name="'.self::$field_name.'[left]" id="'.self::$field_id.'_left" type="text" value="'.$default_left.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($all) {
            $html[] = '
            <div class="col-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"><i class="fas fa-expand-arrows-alt"></i></span>
                    <input name="'.self::$field_name.'[all]" id="'.self::$field_id.'_all" type="text" value="'.$default_all.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        if ($display_units) {
            $html[] = '
            <div class="col-3">
                <select name="'.self::$field_name.'[units]" id="'.self::$field_id.'_units" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'" data-depend-id="'.self::$field_id.'">
                    <option value=""> Select Unit</option>';
                    foreach ($units as $unit) {
                        $checked = ($default_units == $unit) ? 'selected' : '';
                        $html[] = '<option value="'.$unit.'" '.$checked.'>'.$unit.'</option>';
                    }
            $html[] = '
                </select>
            </div>';
        }

        $html[] = '</div>';
        return $html = implode(' ', $html);
    }

    /* Option Array = array(
        'id'       => 'opt-spinner',
        'type'     => 'spinner', 
        'title'    => __('JQuery UI Spinner Example 1'),
        'subtitle' => __('No validation can be done on this field type'),
        'desc'     => __('JQuery UI spinner description. Min:20, max: 100, step:20, default value: 40'),
        'default'  => '40',
        'min'      => '20',
        'step'     => '20',
        'max'      => '100',
    )*/
    static function Spinner($field)
    {
        $min = !empty($field['min']) ? $field['min']  : 0;
        $max = !empty($field['max']) ? $field['max']  : 1;
        $step = !empty($field['step']) ? $field['step']  : 1;

        return '<input name="'.self::$field_name.'" class="w3o-depend  '.self::$field_class.' ThemeOptionsSpinner" data-min="'.$min.'" data-max="'.$max.'" data-step="'.$step.'" value="'.self::$old_field_value.'" id="'.self::$field_id.'" data-depend-id="'.self::$field_id.'">';
    }

    static function Text($field)
    {
        return "<input name='".self::$field_name."' class='w3o-depend  ".self::$field_class." form-control ' value='".self::$old_field_value."' type='text' id='".self::$field_id."' data-depend-id='".self::$field_id."'>";
    }

    static function Textarea($field)
    {
        $rows = !empty($field['rows']) ? $field['rows'] : 4;   

        return '<textarea name="'.self::$field_name.'" class="form-control w3o-depend  '.self::$field_class.'" rows="'.$rows.'" id="'.self::$field_id.'" data-depend-id="'.self::$field_id.'">'.self::$old_field_value.'</textarea>';
    }

    static function Typography($field)
    {
        $unitsArr = array('px', 'em', 'rem', '%', 'in', 'cm', 'mm', 'ex', 'pt', 'pc', 'vh', 'vw', 'vmin', 'vmax', 'ch');
        $textAlignArr = array('inherit', 'left', 'right', 'center', 'justify', 'initial');
        $textTransformArr = array('none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit');
        $default_array = is_array(self::$old_field_value) ? self::$old_field_value : array() ;
        
        $fonts = !empty($field['fonts']) && is_array($field['fonts']) ? $field['fonts'] : array('font_1'=>'font 1','font_2'=>'font 2') ;
        $weights = !empty($field['weights']) && is_array($field['weights']) ? $field['weights'] : array() ;
        $units = !empty($field['units']) && !is_array($field['units']) && in_array($field['units'], $unitsArr) ? $field['units'] : 'px';
        $font_size_unit = !empty($field['font-size-unit']) ? $field['font-size-unit']  : $units ;
        $line_size_unit = !empty($field['line-size-unit']) ? $field['line-size-unit']  : $units ;
        $word_spcaing_unit = !empty($field['word-spcaing-unit']) ? $field['word-spcaing-unit']  : $units ;
        $letter_spacing_unit = isset($field['letter-spacing-unit']) ? $field['letter-spacing-unit']  : $units ;
        $preview_font_size = isset($field['preview']['font-size']) ? $field['preview']['font-size']  : '33px' ;
        $preview_text = isset($field['preview']['text']) ? $field['preview']['text']  : 'testing' ;
        $margin_top_unit = isset($field['margin-top-unit']) ? $field['margin-top-unit']  : $units ;
        $margin_bottom_unit = isset($field['margin-bottom-unit']) ? $field['margin-bottom-unit']  : $units ;
        $font_backup = isset($field['font-backup']) ? $field['font-backup']  : false ;
        $font_style = isset($field['font-style']) ? $field['font-style']  : true ;
        $font_weight = isset($field['font-weight']) ? $field['font-weight']  : true ;
        $font_size = isset($field['font-size']) ? $field['font-size']  : true ;
        $font_family = isset($field['font-family']) ? $field['font-family']  : true ;
        $subsets = isset($field['subsets']) ? $field['subsets']  : true ;
        $line_height = isset($field['line-height']) ? $field['line-height']  : true ;
        $word_spacing = isset($field['word-spacing']) ? $field['word-spacing']  : false ;
        $letter_spacing = isset($field['letter-spacing']) ? $field['letter-spacing']  : true ;
        $text_align = isset($field['text-align']) ? $field['text-align']  : true ;
        $text_transform = isset($field['text-transform']) ? $field['text-transform']  : false ;
        $color = isset($field['color']) ? $field['color']  : true ;
        $margin_top = isset($field['margin-top']) ? $field['margin-top']  : false ;
        $margin_bottom = isset($field['margin-bottom']) ? $field['margin-bottom']  : false ;
        $text_shadow = isset($field['text-shadow']) ? $field['text-shadow']  : false ;
        $all_styles = isset($field['all_styles']) ? $field['all_styles']  : true ;
        $font_family_clear = isset($field['font_family_clear']) ? $field['font_family_clear']  : true ;
        

        $default_font_family = !empty($default_array['font-family']) ? $default_array['font-family'] : '';
        $default_font_backup = !empty($default_array['font-backup']) ? $default_array['font-backup'] : '';
        $default_font_weight = !empty($default_array['font-weight']) ? $default_array['font-weight'] : '';
        $default_subsets = !empty($default_array['subsets']) ? $default_array['subsets'] : '';
        $default_text_align = !empty($default_array['text-align']) ? $default_array['text-align'] : '';
        $default_text_transform = !empty($default_array['text-transform']) ? $default_array['text-transform'] : '';
        $default_font_size = !empty($default_array['font-size']) ? $default_array['font-size'] : '';
        $default_line_height = !empty($default_array['line-height']) ? $default_array['line-height'] : '';
        $default_word_spacing = !empty($default_array['word-spacing']) ? $default_array['word-spacing'] : '';
        $default_letter_spacing = !empty($default_array['letter-spacing']) ? $default_array['letter-spacing'] : '';
        $default_margin_top = !empty($default_array['margin-top']) ? $default_array['margin-top'] : '';
        $default_margin_bottom = !empty($default_array['margin-bottom']) ? $default_array['margin-bottom'] : '';
        $default_font_color = !empty($default_array['font-color']) ? $default_array['font-color'] : '';

        $html[] = '<div class="row">';

        if ($font_family) {
            $html[] = '<div class="col-md-4 form-group">
                <label class="control-label" for="'.self::$field_id.'_font_family">Font Family</label>
                <select name="'.self::$field_name.'[font-family]" id="'.self::$field_id.'_font_family" class="form-control  w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                    <option value=""> Select font family</option>';
                    if (!empty($fonts)) {
                        foreach ($fonts as $key => $value) {
                            $checked = ($key == $default_font_family) ? 'selected="selected"' : '';
                            $html[] = '<option value="'.$key.'" '.$checked.'>'.$value.'</option>';
                        }
                    }
            $html[] = '</select>
            </div>';
        }
        if ($font_backup) {
            $html[] = '<div class="col-md-4 form-group">
                <label class="control-label" for="'.self::$field_id.'_font_backup">Font Backup</label>
                <select name="'.self::$field_name.'[font-backup]" id="'.self::$field_id.'_font_backup" class="form-control  w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                <option value=""> Select font backup</option>';
                    if (!empty($fonts)) {
                        foreach ($fonts as $key => $value) {
                            $checked = ($key == $default_font_backup) ? 'selected="selected"' : '';
                            $html[] = '<option value="'.$key.'" '.$checked.'>'.$value.'</option>';
                        }
                    }
            $html[] = '</select>
            </div>';
        }
        if ($font_weight) {
             $html[] = '<div class="col-md-4 form-group">
                <label class="control-label" for="'.self::$field_id.'_font_weight">Font Weight</label>
                <select name="'.self::$field_name.'[font-weight]" id="'.self::$field_id.'_font_weight" class="form-control  w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                    <option value=""> Select font weight</option>';
                    if (!empty($fonts)) {
                        foreach ($weights as $key => $value) {
                            $checked = ($key == $default_font_weight) ? 'selected="selected"' : '';
                            $html[] = '<option value="'.$key.'" '.$checked.'>'.$value.'</option>';
                        }
                    }
            $html[] = '</select>
            </div>';
        }
        if ($subsets) {
            $html[] = '<div class="col-md-4 form-group">
                <label class="control-label" for="'.self::$field_id.'_subsets">Font Subsets</label>
                <select name="'.self::$field_name.'[subsets]" id="'.self::$field_id.'_subsets" class="form-control  w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                    <option value="latin">Latin</option>
                </select>
            </div>';
        }
        if ($text_align) {
             $html[] = '<div class="col-md-4 form-group">
                <label class="control-label" for="'.self::$field_id.'_text_align">Text Align</label>
                <select name="'.self::$field_name.'[text-align]" id="'.self::$field_id.'_text_align" class="form-control  w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                    <option value=""> Select text align</option>';
                    foreach ($textAlignArr as $value) {
                        $checked = ($value == $default_text_align) ? 'selected="selected"' : '';
                        $html[] = '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
                    }
            $html[] = '</select>
            </div>';
        }
        if ($text_transform) {
            $html[] = '<div class="col-md-4 form-group">
                <label class="control-label" for="'.self::$field_id.'_text_transform">Text Transform</label>
                <select name="'.self::$field_name.'[text-transform]" id="'.self::$field_id.'_text_transform" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">';
            $html[] = '<option value=""> Select text transform</option>';
                    foreach ($textTransformArr as $value) {
                        $checked = ($value == $default_text_transform) ? 'selected="selected"' : '';
                        $html[] = '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
                    }
            $html[] = '</select>
            </div>';
        }
        if ($font_size) {
            $html[] = '<div class="col-3 form-group">
                <label class="control-label" for="'.self::$field_id.'_font_size">Text size</label>
                <div class="input-group input-group-sm mb-3">
                    <input name="'.self::$field_name.'[font-size]" id="'.self::$field_id.'_font_size" type="text" value="'.$default_font_size.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                    <span class="input-group-text">'.$units.'</span>
                </div>
            </div>';
        }
        if ($line_height) {
            $html[] = '<div class="col-3 form-group">
                <label class="control-label" for="'.self::$field_id.'_line_height">Line Height</label>
                <div class="input-group input-group-sm mb-3">
                    <input name="'.self::$field_name.'[line-height]" id="'.self::$field_id.'_line_height" type="text" value="'.$default_line_height.'" class="form-control w3o-depend  '.self::$field_class.' " data-depend-id="'.self::$field_id.'">
                    <span class="input-group-text">'.$units.'</span>
                </div>
            </div>';
        }
        if ($word_spacing) {
            $html[] = '<div class="col-3 form-group">
                <label class="control-label" for="'.self::$field_id.'_word_spacing">Word Spacing</label>
                <div class="input-group input-group-sm mb-3">
                    <input name="'.self::$field_name.'[word-spacing]" id="'.self::$field_id.'_word_spacing" type="text" value="'.$default_word_spacing.'" class="form-control w3o-depend  '.self::$field_class.' " data-depend-id="'.self::$field_id.'">
                    <span class="input-group-text">'.$units.'</span>
                </div>
            </div>';
        }
        if ($letter_spacing) {
            $html[] = '<div class="col-3 form-group">
                <label class="control-label" for="'.self::$field_id.'_letter_spacing">Letter Spacing</label>
                <div class="input-group input-group-sm mb-3">
                    <input name="'.self::$field_name.'[letter-spacing]" id="'.self::$field_id.'_letter_spacing" type="text" value="'.$default_letter_spacing.'" class="form-control w3o-depend  '.self::$field_class.' " data-depend-id="'.self::$field_id.'">
                    <span class="input-group-text">'.$units.'</span>
                </div>
            </div>';
        }
        if ($margin_top) {
            $html[] = '<div class="col-3 form-group">
                <label class="control-label" for="'.self::$field_id.'_margin_top">Margin Top</label>
                <div class="input-group input-group-sm mb-3">
                    <input name="'.self::$field_name.'[margin-top]" id="'.self::$field_id.'_margin_top" type="text" value="'.$default_margin_top.'" class="form-control w3o-depend  '.self::$field_class.' " data-depend-id="'.self::$field_id.'">
                    <span class="input-group-text">'.$units.'</span>
                </div>
            </div>';
        }
        if ($margin_bottom) {
            $html[] = '<div class="col-3 form-group">
                <label class="control-label" for="'.self::$field_id.'_margin_bottom">Margin Bottom</label>
                <div class="input-group input-group-sm mb-3">
                    <input name="'.self::$field_name.'[margin-bottom]" id="'.self::$field_id.'_margin_bottom" type="text" value="'.$default_margin_bottom.'" class="form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                    <span class="input-group-text">'.$units.'</span>
                </div>
            </div>';
        }
        if ($color) {
            $html[] = '<div class="col-3 form-group">
                <div class="input-group input-group-sm mb-3">
                    <label class="control-label form-check-label" for="'.self::$field_id.'_font_color">Font Color</label>
                    <input name="'.self::$field_name.'[font-color]" id="'.self::$field_id.'_font_color" type="text" value="'.$default_font_color.'" class="as_colorpicker form-control w3o-depend  '.self::$field_class.'" data-depend-id="'.self::$field_id.'">
                </div>
            </div>';
        }
        $html[] = '</div>';
        return $html = implode(' ', $html);
    }

    static function Group($field)
    {
        $html[] = '<div class="W3OptionsGroupedSectionWapper">';
        
        $groups = !empty(self::$old_field_value) && is_array(self::$old_field_value) ? ['%KEY%' => array()] + self::$old_field_value : ['%KEY%' => array()];
        $group_fields = self::$field_params;

        foreach ($groups as $key => $group) {
            $html[] = '
            <div class="W3OptionsGroupedSection p-3 pb-0 mb-3 border" '.$key.'>
                <i class="fas fa-times delete-group"></i>
                <div class="row">';
                foreach ($group_fields as $group_field) {

                    if (!empty($group_field['default'])) {
                        unset($group_field['default']);
                    }
                    $fieldId = !empty($field['id']) ? $field['id'] : 'grouped';
                    $groupFieldId = !empty($group_field['id']) ? $group_field['id'] : '';
                    $group_title  = !empty($group_field['title'])   ? $group_field['title']   : '';
                    $group_hint_title  = !empty($field['hint']['title'])   ? $field['hint']['title']   : '';
                    $group_hint_content    = !empty($field['hint']['content'])     ? $field['hint']['content']     : '';
                    
                    if (!empty($groupFieldId)) {
                        $field_key = !empty($group) ? $key : '%KEY%' ;
                        $group_field['id'] = $fieldId.'['.$field_key.']['.$groupFieldId.']';
                        $group_field['field_name'] = '['.$fieldId.']['.$field_key.']['.$groupFieldId.']';

                        
                    }
                    if (!empty($group) && isset($group[$groupFieldId])) {
                        $group_field['old_field_value'] = $group[$groupFieldId];
                    }
                    

                    $group_field['group-field'] = true;

                    $html[] = '
                    <div class="col-12 form-group">
                        <label class="d-block"> '.$group_title.' </label>';
                        if (!empty($group_field['hint'])){
                            $html[] = '
                            <div class="bootstrap-popover d-inline-block">
                                <a href="javascript: void(0);" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-html="true" data-bs-placement="right" data-bs-content="'.$group_hint_content.'" title="'.$group_hint_title.'"><i class="fas fa-question-circle"></i></a>
                            </div>';
                        }

                    $html[] = self::CreateField($group_field,self::$options_type);
                    $html[] = '
                    </div>';
                }
            
            $html[] = '
                </div>
            </div>';
        }

        $html[] = '
            
        <button type="button" class="btn btn-primary addMoreGroupedSection mb-2" id="pricing_box">Add More</button>
        </div>
        ';
        // dd(implode('', $html));
        return $html = implode('', $html);
    }

    //****************  ThemeOptions Fields End  ****************//

    /*
    * Used for showing Cpt Options in Create and Edit Time in Admin.
    */
    static function AttachCPTOptions($cpt_name=null,$blog_id=null)
    {
        if (empty($cpt_name) && empty($blog_id)) {
            return false;
        }
        $sections = array();
        $options_data = array();
        if (!empty($blog_id)) {
            $blog_options = \HelpDesk::getPostMeta($blog_id, 'w3_blog_options');
            $options_data = !empty($blog_options) ? unserialize($blog_options) : array();
        }

        $BlogOptionsClassObj = new ThemeBlogOptions;
        $sections = $BlogOptionsClassObj->getSections($cpt_name);
    
        if (isset($sections) && !empty($sections)){
            // return view('w3options::theme-options.blog_options', compact('sections','options_data'));
            return view('w3options::theme-options.cpt_options', compact('sections','options_data','cpt_name'));
        }else{
            return null;
        }
        
        
    }
    /*
    * Used for showing Blog Options in Create and Edit Time in Admin.
    */
    static function AttachBlogOptions($blog_id=null)
    {
        $sections = array();
        $options_data = array();

        if (!empty($blog_id)) {
            $blog_options = \HelpDesk::getPostMeta($blog_id, 'w3_blog_options');
            $options_data = !empty($blog_options) ? unserialize($blog_options) : array();
        }

        $BlogOptionsClassObj = new ThemeBlogOptions;
        $sections = $BlogOptionsClassObj->getSections('post');

        if (isset($sections) && !empty($sections)){
            return view('w3options::theme-options.blog_options', compact('sections','options_data'));
        }else{
            return null;
        }
        
    }

    /*
    * Used for showing Page Options in Create and Edit Time in Admin.
    */
    static function AttachPageOptions($page_id=null)
    {
        $sections = array();
        $options_data = array();
        if (!empty($page_id)) {
            $page_options = \HelpDesk::get_page_meta($page_id, 'w3_page_options');
            $options_data = !empty($page_options) ? unserialize($page_options->value) : array();
        }

        $PageOptionsClassObj = new ThemePageOptions;
        $sections = $PageOptionsClassObj->sections;

        if (isset($sections) && !empty($sections)){
            return view('w3options::theme-options.page_options', compact('sections','options_data'));
        }else{
            return null;
        }
        
    }

    /*
    * Used for getting Page Options of Single Page Object from meta for Front.
    */
    static function GetPageOptionById($page_id=null,$option_name=null)
    {
        if (!empty($page_id)) {
            $page_options = \HelpDesk::get_page_meta($page_id, 'w3_page_options');
            $options_data = !empty($page_options) ? unserialize($page_options->value) : array();
            
            if (!empty($option_name)) {
                if (!empty($options_data) && isset($options_data[$option_name])) {
                    return $options_data[$option_name];
                }
                return null;
            }
            return $options_data;
        }
        return null;
    }

    /*
    * Used for getting Blgo Options of Single Blog Object from meta for Front.
    */
    static function GetBlogOptionById($blog_id=null,$option_name=null)
    {
        if (!empty($blog_id)) {
            $blog_options = \HelpDesk::getPostMeta($blog_id, 'w3_blog_options');
            $options_data = !empty($blog_options) ? unserialize($blog_options) : array();
            
            if (!empty($option_name)) {
                if (!empty($options_data) && isset($options_data[$option_name])) {
                    return $options_data[$option_name];
                }
                return null;
            }
            return $options_data;
        }
        return null;
    }


}
