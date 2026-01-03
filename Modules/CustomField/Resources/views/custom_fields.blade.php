<div id="CustomFeildContainer">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('common.custom_fields') }}</h4>
            <a href="{{ route('customfields.admin.ajax_modal',$field_type) }}" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxLg">{{ __('common.add_custom_field') }}</a>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($custom_fields as $custom_field)
                <div class="col-xl-4 col-md-6 mb-3">
                    @php

                        $inputType      = $custom_field->input_type ? $custom_field->input_type : 'text';
                        $field_id       = $custom_field->id; 
                        $field_type_id  = $custom_field->custom_field_types->where('custom_field_type',$field_type)->first()->id; 
                        $required       = '';
                        
                        if ($custom_field->required) {
                            $required = "required='required'";
                        }

                        $field['id'] = $field_id .'_'. $field_type_id;
                        $custom_field_value = optional(optional($custom_field->custom_metas)->first())->value;
                        $field['old_field_value'] = @$custom_field_value ?? @$custom_field->value;
                        $field['type'] = $inputType;
                        $field['title'] = $custom_field->title;
                        $options = array_map('trim', explode(',', $custom_field->params));
                        $field['options'] = array_combine($options, $options);
                        $child_custom_fields = $custom_field->child_custom_fields;
                        
                        if (!empty($child_custom_fields->toArray())) {
                            $group_values = [];
                            
                            foreach ($child_custom_fields as $child_custom_field) {
                                
                                $inputType      = $child_custom_field->input_type ? $child_custom_field->input_type : 'text';
                                $field_id       = $child_custom_field->id; 
                                $field_type_id  = $child_custom_field->custom_field_types->where('custom_field_type',$field_type)->first()->id; 

                                $group_field['id'] = $field_id .'_'. $field_type_id;
                                $custom_field_value = optional(optional($child_custom_field->custom_metas)->first())->value;
                                $custom_field_value = json_decode($custom_field_value);
                                if ($custom_field_value) {
                                    foreach ($custom_field_value as $i => $value) {
                                        $group_values[$i][$group_field['id']] = $value;
                                    }
                                }

                                $group_field['type'] = $inputType;
                                $group_field['title'] = $child_custom_field->title;
                                $options = array_map('trim', explode(',', $child_custom_field->params));
                                $group_field['options'] = array_combine($options, $options);


                                $group_params[] = $group_field;
                            }

                            $field['params'] = $group_params;
                            $field['old_field_value'] = $group_values;
                        
                        }


                    @endphp
                    
                    <label for="custom_field_{{ $field_id }}_{{ $custom_field->key }}" class="form-label d-block">{{ $custom_field->title }}</label> 
                    
                    {!! ThemeOption::CreateField($field,'custom-fields') !!}
                    <small class="d-inline-block mt-1">{!! $custom_field->description !!}</small>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('inline-modals')
<div class="modal fade" id="AjaxModalBoxLg" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="AjaxResultContainerLg">
        </div>
    </div>
</div>
@endpush

@push('inline-scripts')
    <script>
        $(document).on('submit','#AddCustomFeildForm', function() {
            event.preventDefault();
            var actionVal = $(this).attr('action');
    
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: actionVal,
                data:  $(this).serialize(), 
                success: function(data)
                {
                    if (data.status) {
                        jQuery('#CustomFeildContainer').html(data.html);
                        jQuery('select.default-select').selectpicker('refresh');
                        jQuery('#AjaxModalBoxLg').modal('hide');
                        jQuery("#AddCustomFeildForm")[0].reset();

                    }
                    else{
                        alert('Something Went wrong.')
                    }
                },
                error: function (err) {
                    if (err.status == 422) { 
                        $(document).find('.error').text('');
                        $.each(err.responseJSON.errors, function (i, error) {
                            $(document).find('.'+i+'-error').text(error[0]);
                        });
                    }
                }
            });
            return false;
        });
    </script>
@endpush