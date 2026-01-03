@php
    $checked = Acl::checked_user_permission($user_id, $permission_id);
    $checked_permission = '';
@endphp
    @if($checked == 1)
        @php $checked_permission = 'checked="checked"'; @endphp
    @endif
    <label class="me-2">{{ __('common.permission') }} : </label>
<label class="permission-switch">
    <input type="checkbox" class="UserCheckbox permissionCheckbox_{{ $user_id }}" id="userCheckbox_{{ $user_id }}_{{ $permission_id }}" data-user-id="{{ $user_id }}" data-permission-id="{{ $permission_id }}" rdx-link="{{ route('admin.permissions.manage-user-permission', ['user_id'=>$user_id, 'permission_id' => $permission_id] )}}" {{ $checked_permission }}>
    <span class="permission-switch-slider"></span>
</label>