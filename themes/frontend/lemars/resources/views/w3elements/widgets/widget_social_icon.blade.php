@php
    if (isset($w3cms_option)) {
        extract($w3cms_option);
    }
@endphp
<h6 class="m-b30 footer-title"><span>{{ DzHelper::theme_lang($args['title'] ?? __('Subscribe')) }}</span></h6>
@if ($footer_social_on && $show_social_icon)
    <ul class="d-flex widget-social-ic">
        {!! get_social_icons(null,'site-button-link') !!}
    </ul>
@endif