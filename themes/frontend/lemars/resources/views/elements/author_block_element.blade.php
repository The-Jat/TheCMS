@php
    $author_box_on = config('ThemeOptions.author_box_on',true);
@endphp

@if ($author_box_on)

<div class="author-box blog-user m-b60">
    <div class="author-profile-info">
        <div class="author-profile-pic">
            <img src="{{ HelpDesk::user_img(optional($blog->user)->profile); }}" alt="{{ DzHelper::theme_lang("user's profile") }}">
        </div>
        <div class="author-profile-content">
            <h6>{{ DzHelper::theme_lang('by') }} <a href="{{ DzHelper::author(optional($blog->user)->id) }}">{{ optional($blog->user)->name }}</a> </h6>
            <p>{{  DzHelper::theme_lang('Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quisma bibendum auctor nisi elit consequat ipsum, nec sagittis sem amet nibh vulputate cursus itaet mauris.') }} </p>
            <ul class="list-inline m-b0">
                {!! get_social_icons('','site-button-link') !!}
            </ul>
        </div>
    </div>
</div>
@endif
