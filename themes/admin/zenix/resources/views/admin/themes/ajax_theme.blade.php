@forelse($themes as $key => $theme)
    @php
        $theme->updated_at = Carbon\Carbon::parse($theme->updated_at)->format(config('Site.custom_date_format').' '.config('Site.custom_time_format'));
        $themename = Str::of($theme->title)->before(' ')->slug('-');
    @endphp
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-1">
                <div class="new-arrival-product">
                    <img class="img-fluid" src="{{ $theme->preview_image }}" alt="{{ $theme->preview_image }}">
                </div>
            </div>
            <div class="card-footer p-3 border-top d-flex align-items-center justify-content-between flex-column gap-3">
                <h5 class="m-0 text-capitalize">{{ $theme->title }}</h5>
                <div class="d-flex justify-content-between gap-2 w-100">
                    @if($currentTheme == $themename)
                        <a href="javascript:void(0);" class="btn btn-xs btn-info w-100">{{ __('common.activated') }}</a>
                    @elseif($theme->installed)
                        <a href="{{ route('themes.admin.index', ['activate' => 'frontend/'.$themename]) }}" theme-name="{{ $themename }}" class="btn btn-xs btn-primary w-100">{{ __('common.active') }}</a>
                    @else
                        <a href="{{ $theme->package }}" theme-name="{{ $themename }}" class="btn btn-xs btn-info w-100 InstallTheme">{{ __('common.install') }}</a>
                    @endif
                    <a href="javascript:void(0);" class="btn btn-xs btn-info light w-100 ThemePreview" theme-data="{{ json_encode($theme) }}">{{ __('common.preview') }}</a>
                </div>
            </div>
        </div>
    </div>
@empty
<div class="col-md-12">
	<div class="alert alert-primary text-center" role="alert">
	  	{{ __('common.themes_not_found') }}
	</div>
</div>
@endforelse
