<!--**********************************
	Footer start
***********************************-->

<div class="footer">
	<div class="copyright">
		@if(config('Site.copyright'))
			<p>{!! config('Site.copyright') !!}</p>
		@else
			<p>{{ __('common.copyright_text') }}</p>
		@endif
	</div>
</div>

<!--**********************************
	Footer end
***********************************-->