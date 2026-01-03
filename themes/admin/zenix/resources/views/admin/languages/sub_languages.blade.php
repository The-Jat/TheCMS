@forelse($translations as $subKey => $subValue)
	@if(is_array($subValue))
		@include('admin.languages.sub_languages', ['translations' => $subValue, 'key' => $subKey])
	@else
		<tr>
			<td>{{ $subKey }}</td>
			<td><input type="text" name="language[{{ $key }}][{{ $subKey }}]" class="form-control" value="{{ $subValue }}"></td>
		</tr>
	@endif
@empty
@endforelse