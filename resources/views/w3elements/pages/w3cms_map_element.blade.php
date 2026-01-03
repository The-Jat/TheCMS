@php
    // dump($args);
@endphp

@if (isset($args['iframe_link']) && !empty($args['iframe_link']))
<div class="container content-inner-1">
    <div class="map-iframe">
        <iframe src="{{ $args['iframe_link'] }}" style="border:0; margin-bottom: -7px; width: 100%; height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
@endif

{{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3611.813290366381!2d75.82890977521674!3d25.142002433934397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396f84c0164c45ed%3A0x930e6cfa69ccabdd!2sVikas%20Park!5e0!3m2!1sen!2sin!4v1686646479946!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}