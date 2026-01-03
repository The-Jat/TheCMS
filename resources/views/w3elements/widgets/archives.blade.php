@php
    $blogObj = new \app\models\Blog();
    $archives = $blogObj->archiveBlogs();
@endphp
<div class="widget widget_categories">
    <div class="widget-title">
        <h6 class="widget-title"><span>{{ $args['title'] ?? __('Archives') }}</span></h6>
    </div>
    <ul>
        @forelse($archives as $archive)
            <li><a href="{{DzHelper::laraBlogArchiveLink($archive->year,$archive->month)}}"> {{ $archive->month_name  }} {{ $archive->year }}</a>  
                @if (!empty($args['show_post_counts']))
                    {{ $archive->data  }}
                @endif
            </li>
        @empty
        @endforelse
    </ul>

</div>