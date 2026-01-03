<form action="{{ route('language') }}" method="POST" id="theme-lang-id" >
    @csrf
    <select class="form-control image-select dropdown_list  " data-live-search="true" data-width="fit" data-flag="true" data-thumbnail="{{ theme_asset('images/flags/in.png') }}" data-actions-box="true" name="language"  onchange="javascript:this.form.submit()">
        @forelse($records as $coun)
            @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';  @endphp
                <option @selected( session()->get('language') && $coun['language']['language_code'] == session('language')) value="{{ $coun['language']['language_code'] }}"  data-content="<img src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> <span>{{  strtoupper($coun['language']['title']) }}</span>"> {{  strtoupper($coun['language']['title']) }}</option>

        @empty
        @endforelse
    </select>
        {{-- <select class="form-control image-select dropdown_list  " data-live-search="true" data-width="fit" data-flag="true" data-thumbnail="{{ theme_asset('images/flags/in.png') }}" data-actions-box="true" name="language"  onchange="javascript:this.form.submit()">
            @forelse($records as $coun)
                @if(!empty($coun->languages))
                    @forelse($coun->languages as $lang)
                        @php $file =($coun->iso_code!=null) ? $coun->iso_code : 'default'; echo $lang->languages; @endphp
                        <option @selected( session()->get('language') && $lang->language_code == session('language'))  value="{{ $lang->language_code }}" data-thumbnail="{{ theme_asset('/images/flags/32/'.$file.'.png') }}"  purchase-code="yes" data-content="<img src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> {{  $lang->title }}"> {{  $lang->title }}</option>
                    @empty
                    @endforelse
                @endif
            @empty
            @endforelse
        </select> --}}
</form>
