<option value="">{{ __('common.select_user') }}</option>
@forelse($users as $user)
	<option value="{{ $user->id }}">{{ $user->full_name }}</option>
@empty
@endforelse