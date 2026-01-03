@forelse($translations as $key => $value)
	@if(is_array($value))
		@include('admin.languages.sub_languages', ['translations' => $value, 'key' => $key])
	@else
		<tr>
			<td class="py-1">{{ $key }}</td>
			<td class="py-1"><input type="text" name="language[{{ $key }}]" class="form-control" value="{{ $value }}"></td>
		</tr>
	@endif
@empty
	<tr>
		<td colspan="2" align="center">{{ __('common.no_language_found') }}</td>
	</tr>
@endforelse
