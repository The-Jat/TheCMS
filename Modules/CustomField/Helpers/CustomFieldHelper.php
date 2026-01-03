<?php

namespace Modules\CustomField\Helpers;
use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\CustomMeta;


class CustomFieldHelper
{

    public static function custom_fields($field_type, $object_id=null)
    {
        $CustomFieldObj     =   new CustomField();
        $custom_fields      =   CustomField::with([
                                    'custom_metas' => function ($q) use ($object_id) {
                                        $q->where('object_id', $object_id);
                                    },
                                    'child_custom_fields.custom_metas' => function ($q) use ($object_id) {
                                        $q->where('object_id', $object_id);
                                    },
                                ])
                                ->whereHas('custom_field_types', function ($query) use($field_type) {
                                    $query->where('custom_field_type', '=', $field_type);
                                })
                                ->where('parent_id',0)->get();

        return view('customfield::custom_fields', compact('field_type','custom_fields'));
    }

    /*
    * $field_module = name of module or table, 
    * $field_name = key(name) of the field
    * $object_id = type of object like blog id for particular blog.
    */
    public static function get_custom_field_value($field_module, $field_name, $object_id)
    {
        $CustomFieldObj     = new CustomField();
        $custom_meta_value  = $CustomFieldObj->custom_field_value($field_module, $field_name, $object_id);
        return $custom_meta_value;
    }



}
