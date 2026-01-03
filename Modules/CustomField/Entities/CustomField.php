<?php

namespace Modules\CustomField\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomField extends Model
{

	use HasFactory;

	protected $table = 'custom_fields';
	protected $fillable = [
		'key',
		'title',
		'parent_id',
		'value',
		'placeholder',
		'description',
		'editable',
		'input_type',
		'params',
		'required',
	];

	public function custom_field_types()
	{
		return $this->hasMany(CustomFieldType::class, 'custom_field_id', 'id');
	}

	public function child_custom_fields()
    {
        return $this->hasMany(CustomField::class, 'parent_id', 'id');
    }

    public function parent_custom_field()
    {
        return $this->belongsTo(CustomField::class, 'parent_id', 'id');
    }

	public function custom_metas()
	{
		return $this->hasMany(CustomMeta::class, 'custom_field_id', 'id');
	}

	public function cf_settings()
	{
		$cf_settings    = config('constants.cf_settings');
		return $cf_settings;
	}

	public function get_custom_fields($field_type)
	{
		$custom_fields  = CustomField::where('parent_id',0)->whereHas('custom_field_types', function ($query) use($field_type) {
								$query->where('custom_field_type', '=', $field_type);
							})->get();

		return $custom_fields;
	}

	public function get_custom_field($field_key, $field_type)
	{
		$custom_field  = CustomField::with(['custom_field_types' => function ($query) use($field_type) {
								$query->where('custom_field_type', '=', $field_type);
							}])->firstWhere('key', $field_key);
		return $custom_field;
	}

	public function update_custom_field($request, $object_id)
	{
        $MEFieldsValue = $request->input('custom-fields');

		if(!empty($request->file('custom-fields')))
		{
            $old_file_values = $request->input('custom_field_old');
			
			foreach($request->file('custom-fields') as $imgKey => $imgValue) 
			{
                $fileFullName = [];
	            /*------ Currently Not Woriking-----*/
	            $allImagesName = explode(',', @$old_file_values[$imgKey]);
	            if (!empty($allImagesName)) {
		            foreach ($allImagesName as $imageName) 
		            {
	                	$filepath = storage_path('app/public/custom-fields/').$imageName;
	                	if(\File::exists($filepath))
		                {
		                    \File::delete($filepath);
		                }	
		            }
	            }
	            /* -------- */
		             
                if (is_array($imgValue)) { 
                    foreach ($imgValue as $key => $image) {

                        /* Multiple Image Upload */
                        if (is_array($image)) {

                            foreach ($image as $fieldName => $value) {
                                if (is_array($value)) {
                                /* Multiple Image Upload */
                                    foreach ($value as $subFieldName => $subValue) {
                                        $fileName = time().'_'.$subValue->getClientOriginalName();
                                        $subValue->storeAs('public/custom-fields', $fileName);
                                        $MEFieldsValue[$imgKey][$key][$fieldName][$subFieldName] = $fileName;
                                    }
                                
                                }
                                /* Single Image Upload */
                                else{
                                    $fileName = time().'_'.$value->getClientOriginalName();
	                                $value->storeAs('public/custom-fields', $fileName);
	                                $MEFieldsValue[$imgKey][$key][$fieldName] = $fileName;
                                }
	                            $fileFullName = $MEFieldsValue[$imgKey];
                            }

                        }
                        /* Single Image Upload */
                        else{
                            $fileName = time().'_'.$image->getClientOriginalName();
                            $image->storeAs('public/custom-fields', $fileName);
                            $fileFullName = !empty($fileFullName) ? $fileFullName.','.$fileName : $fileName;
                        }

                    }

                    $fileName = $fileFullName;
                }
                else {
                    $fileName = time().'_'.$imgValue->getClientOriginalName();
                    $imgValue->storeAs('public/custom-fields', $fileName);
                }
                
                $request->merge([
                    'custom-fields' => array_merge($request->input('custom-fields'), [$imgKey => $fileName])
                ]);
            }
		}

		if($request->has('custom-fields'))
		{
			foreach ($request->input('custom-fields') as $key => $custom_field_value) {
				
				if(is_array($custom_field_value))
				{
					$is_associative = !array_is_list($custom_field_value);
					
					if ($is_associative) {
						$grouped_field_data = [];

						foreach ($custom_field_value as $sub_custom_field_key => $sub_custom_field) {
							if ($sub_custom_field_key === '%KEY%') continue;

							foreach ($sub_custom_field as $sub_key => $sub_value) {
								 $grouped_field_data[$sub_key][] = is_array($sub_value) ? implode(',', $sub_value) : $sub_value ;
							}
						}
						
						foreach ($grouped_field_data as $child_custom_field_key => $child_custom_field_value) {
							$sub_field_ids                             = explode('_', $child_custom_field_key);
							$sub_field_metas['object_id']              = $object_id;
							$sub_field_metas['custom_field_id']        = $sub_field_ids[0];
							$sub_field_metas['custom_field_type_id']   = $sub_field_ids[1];
							$sub_field_metas['value']                  = json_encode($child_custom_field_value);
							$res                                   = CustomMeta::updateOrCreate(['object_id'=>$object_id,'custom_field_id'=>$sub_field_ids[0],'custom_field_type_id'=>$sub_field_ids[1]],$sub_field_metas);
						}

						continue;

					}else{
						$custom_field_value = implode(', ', $custom_field_value);
					}
				}

				if(isset($custom_field_value))
				{
					$field_ids                             = explode('_', $key);
					$field_metas['object_id']              = $object_id;
					$field_metas['custom_field_id']        = $field_ids[0];
					$field_metas['custom_field_type_id']   = $field_ids[1];
					$field_metas['value']                  = $custom_field_value;
					$res                                   = CustomMeta::updateOrCreate(['object_id'=>$object_id,'custom_field_id'=>$field_ids[0],'custom_field_type_id'=>$field_ids[1]],$field_metas);
				}
			}

		}
	}

	public function custom_field_value($field_module, $field_name, $object_id)
	{
		
    	$custom_field      = CustomField::where('key',$field_name)->with([
                                'custom_metas' => function ($q) use ($object_id) {
                                    $q->where('object_id', $object_id);
                                },
                                'child_custom_fields.custom_metas' => function ($q) use ($object_id) {
                                    $q->where('object_id', $object_id);
                                },
                            ])
	    					->whereHas('custom_field_types', function ($query) use ($field_module) {
	                            $query->where('custom_field_type', '=', $field_module);
	                        })
	                        ->where('parent_id',0)->first();
            
        $group_values = [];
        if (!empty($custom_field) && optional($custom_field)->child_custom_fields->isNotEmpty()) 
        {
            foreach ($custom_field->child_custom_fields as $child_custom_field) {
            	$custom_field_value = optional(optional($child_custom_field->custom_metas)->first())->value;
                $custom_field_value = json_decode($custom_field_value);
                if ($custom_field_value) {
                    foreach ($custom_field_value as $i => $value) {
                        $group_values[$i][$child_custom_field->key] = $value;
                    }
                }
            }
            $custom_field_value = $group_values;
        }else{
        	$custom_field_value = optional(optional(@$custom_field->custom_metas)->first())->value;
        }

		return $custom_field_value;
	}

}
