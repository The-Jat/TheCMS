<form action="{{ route('language') }}" method="POST" id="theme-lang-id" >
@csrf
    <select class="form-control image-select dropdown_list" data-live-search="true" data-flag="true" name="language"  onchange="javascript:this.form.submit()">
        @forelse($records as $coun)
            @php $file =($coun->iso_code!=null) ? $coun->iso_code : 'default';  @endphp
            <option @selected( session()->get('language') && $coun->language_code == session('language'))  value="{{ $coun->language_code }}" data-content="<img  src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> <span class=''>{{  strtoupper($coun->country) }}</span>"> {{  $coun->country }}</option>
        @empty
        @endforelse
    </select>
</form>
