<form action="{{ route('language') }}" method="POST" id="theme-lang-id" >
    @csrf
    {{-- <select class="default-select dashboard-select image-select" name="language"  onchange="javascript:this.form.submit()">
        @php
            $language = DzHelper::getInstalledLanguage();
        @endphp
        @foreach ($language as $key =>$val )
            <option value="{{ $key }}" {{ (session()->get('language') && $key==session('language'))? 'selected' : '' }}>{{ $val }}</option>
        @endforeach

    </select> --}}

    <select class="form-control image-select dropdown_list  " data-live-search="true" data-width="fit" data-flag="true" data-thumbnail="{{ theme_asset('images/flags/in.png') }}" data-actions-box="true" name="language"  onchange="javascript:this.form.submit()">
        @forelse($records as $coun)
            @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';  @endphp
                <option @selected( session()->get('language') && $coun['language']['language_code'] == session('language')) value="{{ $coun['language']['language_code'] }}"  data-content="<img src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> <span>{{  strtoupper($coun['language']['lang_title']) }}</span>"> {{  strtoupper($coun['language']['lang_title']) }}</option>

        @empty
        @endforelse
    </select>
</form>
