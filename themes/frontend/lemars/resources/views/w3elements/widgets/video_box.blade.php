<h6 class="m-b30 footer-title"><span>{{ DzHelper::theme_lang($args['title'] ?? __('My Blogs')) }}</span></h6>
<a class="video widget relative popup-youtube overlay-black-middle" href="{{@$args['url']}}">
    <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image']) }}" alt="{{ DzHelper::theme_lang('Thumbnail Image') }}"/>
    <span class="play-video"><i class="la la-play"></i></span>
</a>