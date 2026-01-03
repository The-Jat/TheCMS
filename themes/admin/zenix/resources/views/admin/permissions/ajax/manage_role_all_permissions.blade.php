@if($rolePermissionCount == $allPermissionCount)
	<label class="permission-switch">
	    <input type="checkbox" name="role[{{ $role_id }}]" value="{{ $role_id }}" class="rdxUpdateAjax" rdx-result-box="RoleSwitch_{{ $role_id }}" rdx-link="{{ route('admin.permissions.manage-role-all-permissions', ['id'=>$role_id, 'status'=>1] )}}" checked="checked">
	    <span class="permission-switch-slider"></span>
	</label>
@else 
	<label class="permission-switch">
	    <input type="checkbox" name="role[{{ $role_id }}]" value="{{ $role_id }}" class="rdxUpdateAjax" rdx-result-box="RoleSwitch_{{ $role_id }}" rdx-link="{{ route('admin.permissions.manage-role-all-permissions', ['id'=>$role_id, 'status'=>0] )}}">
	    <span class="permission-switch-slider"></span>
	</label>
@endif