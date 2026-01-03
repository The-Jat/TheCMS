@php
    $tagObj = new \app\models\Blog();
    $tags = $tagObj->tagsWidget();
@endphp
<div class="widget widget_tag_cloud">
    <div class="widget-title">
        <h6 class="widget-title"><span>{{ $args['title'] ?? __('Popular Tags') }}</span></h6>
    </div>
    <div class="tagcloud">
        @forelse($tags as $tag)
        <a href="{{DzHelper::laraBlogTagLink($tag->id)}}"><span>{{ $tag->title }}</span></a>
        @empty
        @endforelse
    </div>
</div>