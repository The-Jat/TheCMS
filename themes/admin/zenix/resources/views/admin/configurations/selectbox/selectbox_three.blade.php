<form action="{{ route('language') }}" method="POST" id="theme-lang-id" >
    @csrf

    <select class="form-control image-select dropdown_list  " data-live-search="true" data-width="fit" data-flag="true" data-thumbnail="{{ theme_asset('images/flags/in.png') }}" data-actions-box="true" name="language"  onchange="javascript:this.form.submit()">
        @forelse($records as $coun)
            @php $file =($coun->iso_code!=null) ? $coun->iso_code : 'default';  @endphp
            <option @selected( session()->get('language') && $coun->language_code == session('language'))  value="{{ $coun->language_code }}" data-thumbnail="{{ theme_asset('/images/flags/32/'.$file.'.png') }}"  purchase-code="yes" data-content="<img src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> {{  config('lang.language1.'.$coun->title)}}"> {{   config('lang.language1.'.$coun->title) }}</option>
        @empty
        @endforelse
    </select>
</form>
