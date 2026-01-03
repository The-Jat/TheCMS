@if($category)
	@if($category->parent_id)
		<ul class="category-checkbox-list">
			<li class="form-group BlogCategory{{ $category->id }}">
				<input type="checkbox" name="data[BlogCategory][]" class="blog_categories form-check-input" id="BlogCategory{{ $category->id }}" value="{{ $category->id }}">
				<label class="form-check-label" for="BlogCategory{{ $category->id }}">{{ $category->title }}</label>
			</li>
		</ul>
	@else
		<li class="form-group BlogCategory{{ $category->id }}">
			<input type="checkbox" name="data[BlogCategory][]" class="blog_categories form-check-input" id="BlogCategory{{ $category->id }}" value="{{ $category->id }}">
			<label class="form-check-label" for="BlogCategory{{ $category->id }}">{{ $category->title }}</label>
		</li>
	@endif
@else
	<li class="text-danger CatNotExit">
		{{ __('common.category_exits.') }}
	</li>
@endif


