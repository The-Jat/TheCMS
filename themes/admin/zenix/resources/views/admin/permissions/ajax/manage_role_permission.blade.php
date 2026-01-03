@if($status == 1)
	<label class="permission-switch">
	    <input type="checkbox" class="rdxUpdateAjax" rdx-result-box="SingleRoleSwitch_{{ $permission_id }}_{{ $role_id }}" rdx-link="{{ route('admin.permissions.manage-role-permission', ['role_id'=>$role_id, 'permission_id' => $permission_id, 'status'=>0] )}}">
	    <span class="permission-switch-slider"></span>
	</label>
@else 
	<label class="permission-switch">
	    <input type="checkbox" class="rdxUpdateAjax" rdx-result-box="SingleRoleSwitch_{{ $permission_id }}_{{ $role_id }}" rdx-link="{{ route('admin.permissions.manage-role-permission', ['role_id'=>$role_id, 'permission_id' => $permission_id, 'status'=>1] )}}" checked="checked">
	    <span class="permission-switch-slider"></span>
	</label>
@endif