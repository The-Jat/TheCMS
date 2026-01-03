@php
    $sidebar = DzHelper::getSidebar($sidebar);
    $widgetIds = json_decode(optional($sidebar)->content);
    $widgets = DzHelper::getSidebarWidgets($widgetIds);
@endphp

@forelse ($widgets as $widget)
    {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
@empty
@endforelse

