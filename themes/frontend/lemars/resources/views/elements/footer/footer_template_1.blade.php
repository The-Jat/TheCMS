<footer class="site-footer">
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-2 col-md-6 d-md-none d-lg-block">
					<div class="widget">
						@if ($logo_type == 'text_logo')
                            <div class="text-logo">
                                @if (!empty($logo_text))
                                <h1 class="site-title">
                                    <a href="{{url( '/' )}}" title="{{$logo_title}}">
                                        {{$logo_text}}
                                    </a>
                                </h1>
                                @endif
                            </div>
                        @else
                            <a href="{{url( '/' )}}" title="{{$logo_title}}">
                            	<div class="footer-logo">
                                	<img src="{{$site_other_logo}}" alt="{{$logo_alt}}"/>
                            	</div>
                            </a>
                        @endif
					</div>
                    <div class="btn-white mb-3">
                        @if (DzHelper::languageBoxPosition()=='Footer')
                            {!! DzHelper::languageSelectBoxStyle() !!}
                        @endif
                    </div>
				</div>
				<div class="col-xl-3 col-lg-4 col-md-6">
					@php
                        $section1_widgets_ids = array_keys($footer_sections['Section 1'] ?? array());
                        $section1_widgets = DzHelper::getSidebarWidgets($section1_widgets_ids);
                    @endphp
                    @forelse ($section1_widgets ?? array() as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6">
					@php
                        $section1_widgets_ids = array_keys($footer_sections['Section 2'] ?? array());
                        $section1_widgets = DzHelper::getSidebarWidgets($section1_widgets_ids);
                    @endphp
                    @forelse ($section1_widgets ?? array() as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
				</div>
				<div class="col-xl-3 col-lg-3 col-md-12">
					@php
                        $section1_widgets_ids = array_keys($footer_sections['Section 3'] ?? array());
                        $section1_widgets = DzHelper::getSidebarWidgets($section1_widgets_ids);
                    @endphp
                    @forelse ($section1_widgets ?? array() as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
				</div>
			</div>
		</div>
	</div>
	@if($footer_copyright_on)
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<span>{!! $copyright_title !!}</span>
				</div>
			</div>
		</div>
	</div>
	@endif
</footer>

