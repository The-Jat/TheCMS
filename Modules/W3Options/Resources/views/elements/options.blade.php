@php
	$options_type = isset($options_type) ? $options_type : '';
	$options_data = isset($options_data) ? $options_data : array();
	$dropdownStart = false;
@endphp
<div class="d-flex">
    <ul class="ThemeOptionsMainMenu nav flex-column" role="tablist" aria-orientation="vertical">
        @forelse ($sections as $key => $section)
        	
        	@php
        		$section_key = (!empty($sections[$key+1]['subsection']) && $sections[$key+1]['subsection'] == true && empty($section['subsection']))  ? $key + 2 : $key + 1;
        		$hasSubSectionClass = (!empty($sections[$key+1]['subsection']) && $sections[$key+1]['subsection'] == true && empty($section['subsection'])) ? 'has-subsection' : '';
        	@endphp


        	@if ($dropdownStart && empty($section['subsection']))
        		@php
					$dropdownStart = false;
				@endphp
	            	</ul>
	            </li>
        	@endif

        	@if (empty($section['subsection']) && empty($hasSubSectionClass))
	        	<li class="nav-item ">
	                <a class="nav-link text-nowrap {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#section_group_{{$section_key}}">
	                	<i class="me-2 {{ !empty($section['icon']) ? $section['icon'] : 'fa-home' }}"></i>
	                	<span> {{ DzHelper::admin_lang($section['title']) }}</span>
	            	</a>
	            </li>
            @else
	        	
	        	@if (empty($section['subsection']))
					@php
						$dropdownStart = true;
					@endphp

		        	<li class="nav-item {{ $hasSubSectionClass }} ">
		                <a class="nav-link text-nowrap {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#section_group_{{$section_key}}">
		                	<i class="me-2 {{ !empty($section['icon']) ? $section['icon'] : 'fa-home' }}"></i>
		                	<span>  {{ DzHelper::admin_lang($section['title']) }}</span>
		            	</a>
		            	<ul class="ThemeOptionsSubMenu" style="display: none;">
            	@endif
	            
	            @if(!empty($section['subsection']) && $section['subsection'] == true)
		            <li class="nav-item subsection">
		                <a class="nav-link text-nowrap {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#section_group_{{$section_key}}">
		                	<i class="me-2 {{ !empty($section['icon']) ? $section['icon'] : 'fa-home' }}"></i>
		                	 <span> {{ DzHelper::admin_lang($section['title']) }}</span>
		            	</a>
		            </li>
	        	@endif



        	@endif



        @empty
        @endforelse

        @if ($dropdownStart)
            	</ul>
            </li>
    	@endif
        
    </ul>
    <div class="tab-content">
    	@forelse ($sections as $key => $section)
        	@php
        		$check_section = false;
        		$active_section_indent = false;
        	@endphp
        	@if (!empty($section['fields']))
	    	<div class="tab-pane fade {{ $key == 0 ? 'active show' : '' }}" id="section_group_{{$key+1}}" role="tabpanel">
	    		@if (!empty($section['title']) || !empty($section['desc']))
	    		<div class=" mb-4">
					@if (!empty($section['title']))
						<h4 class="card-title"> {{ DzHelper::admin_lang($section['title'])}}</h4>
					@endif
					@if (!empty($section['desc']))
					<p>{!! DzHelper::admin_lang($section['desc']) !!}</p>
					@endif
				</div>
	    		@endif
	    		<div class="pt-4">
	    			@if (!empty($section['fields']))
						@forelse ($section['fields'] as $field)
							@php
								$depend_on = '';
								$datafield = '';
								if (!empty($options_data) && isset($options_data[$field['id']])) {
						            $field['old_field_value'] = $options_data[$field['id']];
						        }

						        if(isset($field['depend_on'])) 
								{
									if (is_array($field['depend_on']) && !empty($field['depend_on']))
									{
										foreach($field['depend_on'] as $field_name => $field_array)
										{
											$depend_on .= $field_name.'-depend d-none ';
											if (!is_array($field_array['value'])) {
												$datafield .= "data-".$field_name."-value =".$field_array['value']." ";
											}else{
												$datafield .= "data-".$field_name."-value =".(implode(',', $field_array['value']))." ";
											}
											$datafield .= "data-".$field_name."-operator = ".$field_array['operator']." ";
										}
									}
									else {
										$depend_on = $value['depend_on'].'-depend d-none ';
									}
								}

								$fieldClass	 		= !empty($field['class']) 		? $field['class'] 	: '';
								$fieldClass	    	.= isset($field['depend_on']) && !empty($field['depend_on']) ? ' hidden' : '';
								$fieldHeading	 	= !empty($field['title']) && !is_array($field['title']) 		? $field['title'] 	: '';
								$fieldSubtitle	 	= isset($field['subtitle']) 	? $field['subtitle'] : '';
								$fieldDescription 	= isset($field['desc']) 		? $field['desc'] 	: '';
								$hintTitle 			= !empty($field['hint']['title']) 	? $field['hint']['title'] 	: '';
								$hintContent		= !empty($field['hint']['content']) ? $field['hint']['content'] 	: 'Content';
								$field_style 		= !empty($field['style']) 			? $field['style'] : '';
							@endphp
							{{-- info-types:normal,info,warning,success,critical,custom --}}
							@if (in_array($field['type'], array('info','section')))
								@if ($field['type'] == 'info')

									<div class="alert alert-{{ $field_style }} alert-dismissible alert-alt fade show">
	                                    <strong>
	                                    	@if (!empty($field['icon']))
	                                    	<i class="{{$field['icon']}}"></i>
	                                    	@endif
											{{ DzHelper::admin_lang($field['title'])}}
	                                    </strong>
	                                </div>
								@elseif ($field['type'] == 'section')
									@if ($check_section == false)
	                        			<div class="pt-3 mb-4 border-bottom border-primary {{ $depend_on }}" {{ $datafield }}>
	                        				<h5 class="text-primary">{{DzHelper::admin_lang($fieldHeading)}}</h5>
	                        				<p>{{DzHelper::admin_lang($fieldDescription)}}</p>
	                        			</div>
	                    			@else
	                    				<div class="pt-3 mb-4 border-bottom border-primary {{ $depend_on }}" {{ $datafield }}></div>
									@endif
									@php
										$check_section = ($check_section == false) ? true : false ;
										$active_section_indent = isset($field['indent']) ? $field['indent'] : true ;
									@endphp
								@endif
								
							@else
	            				<div class="row theme-options-row {{ $active_section_indent ? 'indented-section' : '' }} {{ $depend_on }}" {{ $datafield }} >

									<div class="col-lg-4  mb-lg-0 mb-3">
										<div class="d-flex justify-content-between align-items-center">
											<h6 class="dz-title"> {{ DzHelper::admin_lang($fieldHeading) }}</h6>
											@if (!empty($field['hint']))
											<div class="bootstrap-popover d-inline-block">
												<a href="javascript: void(0);" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-html="true" data-bs-placement="right" data-bs-content="{!! $hintContent !!}" title="{{ $hintTitle }}"><i class="fas fa-question-circle"></i></a>
											</div>
											@endif
										</div>

										<small>{{ DzHelper::admin_lang($fieldSubtitle) }}</small>
									</div>
									<div class="col-lg-8">
	                                	
										{!! ThemeOption::CreateField($field,$options_type) !!}
												
										@if($fieldDescription)
											<small class="d-block">{{ DzHelper::admin_lang($fieldDescription) }}</small>
										@endif
									</div>
								</div>

							@endif
						@empty
	            		@endforelse

	    			@endif
				</div>
	    	</div>
	    	@endif
        @empty
        @endforelse
    </div>
</div>
