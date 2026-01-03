<form action="{{ route('language') }}" method="POST" id="theme-lang-id" >
    @csrf
    {{-- <select class="default-select dashboard-select image-select" name="language"  onchange="javascript:this.form.submit()"> --}}
        {{-- <select class="form-control image-select dropdown_list lang-dropdown-img" data-width="fit" data-actions-box="true" name="language"  onchange="javascript:this.form.submit()">
            @forelse($language as $lang)
                @php  $file =($lang->country_code!=null) ? $lang->country_code : 'default';@endphp
                <option @selected(session()->get('language') && $lang->language_code == session('language')) value="{{ $lang->language_code }}" data-thumbnail="{{ theme_asset('/images/flags/32/'.$file.'.png') }}"  purchase-code="yes">{{ $lang->title }}</option>
            @empty
            @endforelse
        </select> --}}


        <select class="form-control image-select dropdown_list lang-dropdown-box lang-dropdown-img"  data-width="fit" data-flag="true" name="language"  onchange="javascript:this.form.submit()">
            @forelse($records as  $key => $coun)
                        @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';
                        //dump($coun);
                        @endphp
                    
                    @if($coun['lang_type']=='main')
                        <option @selected( session()->get('language') && $coun['language']['language_code'] == session('language')) value="{{ $coun['language']['language_code'] }}" data-content="<img  src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> <span class=''></span>"> {{ $coun['country']['title'] }}</option>
                    @endif

            @empty
            @endforelse
        </select>
</form>
