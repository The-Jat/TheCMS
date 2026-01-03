<div class="form-group px-3">
	@forelse($searchData as $key => $value)
		<div class="form-check mb-2">
			<input type="checkbox" name="MenuItem[]" class="form-check-input CheckboxViewAll" id="page-{{ $key }}" value="{{ $value->id }}">
			<label class="form-check-label ms-1" for="page-{{ $key }}">{{ $value->title }}</label>
		</div>
	@empty
		<p>{{ ucwords($searchType). __('common.records_not_found') }}</p>
	@endforelse
</div>