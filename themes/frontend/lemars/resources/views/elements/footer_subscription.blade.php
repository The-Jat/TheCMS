@php
	if(!empty($subscription_section_image)) {
		$col_classes = 'col-lg-5 col-md-5';
		$sec_classes = 'subscribe-sc';
	}else{
		$col_classes = 'col-lg-12 col-md-12 m-b50';
		$sec_classes = 'pt-4';
	}
@endphp

<div class="section-full bg-gray {{$sec_classes}}">
	<div class="container">
		<div class="row align-items-center subscribe-design">
			@if (!empty($subscription_section_image))
			<div class="col-lg-7 col-md-7 d-none d-md-block">
				<img src="{{$subscription_section_image}}" alt="{{ DzHelper::theme_lang('Image') }}"/>
			</div>
			@endif
			<div class="{{$col_classes}}">
				<form class="dzSubscribe dezPlaceAni dz-subscription" action="#" method="post">
					<h2>{{ DzHelper::theme_lang($subscription_section_title) }}</h2>
					<div class="form-style subscribe">
						<div class="input-group">
							<input name="dzEmail" required="required" type="email" class="form-control" placeholder="{{ DzHelper::theme_lang('Your Email') }}">
							<div class="input-group-append">
								<button name="submit" value="Submit" type="submit" class="btn"><i class="la la-paper-plane"></i><span class="d-none dz-loading"><i class="la la-refresh"></i></span></button>
							</div>
						</div>
					</div>
					<div class="dz-subscription-msg font-18 m-t10"></div>
				</form>
			</div>
		</div>
        <h2 class="subscribe-text">{{ DzHelper::theme_lang($subscription_section_bg_text) }}</h2>
	</div>
</div>
