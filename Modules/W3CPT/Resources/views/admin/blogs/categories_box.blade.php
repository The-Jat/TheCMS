@if(!empty($categories))
	@forelse($categories as $key => $value)
		@php
			$taxonomy = \Str::kebab($key);
			$parentCategoryArr = $blogCategoryObj->generateCptCategoryTreeArray($taxonomy, Null, '&nbsp;&nbsp;&nbsp;');
		@endphp
		<div class="col-md-12">
			<div class="card accordion accordion-rounded-stylish accordion-bordered X{{ $key }} {{ !empty($screenOption[$key]['visibility']) ? '' : 'd-none' }}" id="accordion-{{ $key }}">
				<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#taxonomy-{{ $key }}" aria-expanded="true">
					<h4 class="card-title">{{ $value['label'] }}</h4>
					<span class="accordion-header-indicator"></span>
				</div>
				<div class="accordion__body p-4 collapse show appendCategory" id="taxonomy-{{ $key }}" data-bs-parent="#accordion-{{ $key }}">
					{!! $blogCategoryObj->generateCptCategoryTreeListCheckbox($taxonomy, Null, ' ', $blogCatArr) !!}
					<a href="javascript:void(0)" title="{{ __('common.click_add_new_category') }}" class="addNewBlogCategorylink text-primary d-block my-2"><i class="fa fa-plus"></i>{{ __('common.add_new_category') }}</a>
					<div class="col-md-12 form-group newCategoryDiv">
						<div class="form-group">
							<label for="BlogCategoryBlogCategory{{$key}}">{{ __('common.new_category_name') }}</label>
	          				<input type="text" class="form-control newCategoryField mb-2" id="BlogCategoryBlogCategory{{$key}}">
						</div>
						<div class="form-group">
							<label for="ParentBlogCategory{{$key}}">{{ __('common.parent_category') }}</label>
							<select id="ParentBlogCategory{{$key}}" class="form-control CategoryParentId">
								<option value="">-{{ __('common.parent_category') }}-</option>
								@forelse($parentCategoryArr as $value)
									<option value="{{ $value['id'] }}">{!! $value['title'] !!}</option>
								@empty
								@endforelse
							</select>
						</div>
	          			<input type="hidden" class="form-control rdx-link" value="{{ route("cpt.blog_category.admin.admin_ajax_add_category", ['post_type' => $post_type, 'taxonomy' => $taxonomy]) }}">
	         			<button type="button" class="btn btn-primary addNewBlogCategoryBtn" rel="taxonomy-{{ $key }}">{{ __('common.add_new') }}</button>
	         		</div>
				</div>
			</div>
		</div>
	@empty
	@endforelse
@endif