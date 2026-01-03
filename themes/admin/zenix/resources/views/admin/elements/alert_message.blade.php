@if(Session::has('success'))
	<div class="container-fluid">
		<div class="alert alert-success alert-dismissible alert-alt fade show mb-0">
		    <strong>{{ __('common.success') }}</strong> {{ Session::get('success') }}
		    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
		</div>
	</div>
@elseif(Session::has('info'))
	<div class="container-fluid">
		<div class="alert alert-info alert-dismissible alert-alt fade show mb-0">
		    <strong>{{ __('common.info') }}</strong> {{ Session::get('info') }}
		    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
		</div>
	</div>
@elseif(Session::has('warning'))
	<div class="container-fluid">
		<div class="alert alert-warning alert-dismissible alert-alt fade show mb-0">
		    <strong>{{ __('common.warning') }}</strong> {{ Session::get('warning') }}
		    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
		</div>
	</div>
@elseif(Session::has('error'))
	<div class="container-fluid">
		<div class="alert alert-danger alert-dismissible alert-alt fade show mb-0">
		    <strong>{{ __('common.error') }}</strong> {{ Session::get('error') }}
		    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
		</div>
	</div>
@endif