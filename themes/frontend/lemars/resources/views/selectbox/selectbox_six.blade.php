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
    {{-- {{dump($language)}} --}}
    {{-- <select class="form-control" name="language" data-width="fit" onchange="javascript:this.form.submit()">
        @forelse($language as $lang)
            <option @selected(session()->get('language') && $lang->language_code == session('language'))  data-item-title="{{ $lang->title }}" data-item-img="{{ theme_asset('images/logo.png') }}" value="{{ $lang->language_code }}">{{ $lang->title.' - '.$lang->country }}</option>
        @empty
        @endforelse
    </select> --}}

    <select class="form-control lang-dropdown-box" data-live-search="true" data-width="fit" name="language"  onchange="javascript:this.form.submit()">
        @forelse($records as $coun)
        @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';  @endphp
            <option @selected( session()->get('language') && $coun['language']['language_code'] == session('language')) value="{{ $coun['language']['language_code'] }}"  data-content="<img src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> <span>{{ strtoupper($coun['country']['country_title']).' - '. strtoupper($coun['language']['lang_title']) }}</span>"> {{   strtoupper($coun['country']['country_title']).' - '. strtoupper($coun['language']['lang_title']) }}</option>

    @empty
    @endforelse
        {{-- @forelse($records as $coun)
            @php $file =($coun['iso_code']!=null) ? $coun['iso_code'] : 'default';  
                    if(isset($coun['country_title'])){ $contitle = $coun['country_title'];} else{ $contitle = ''; }
            @endphp
            @forelse($coun['languages'] as $lkey => $language)
                <option @selected( session()->get('language') && $language['language_code'] == session('language'))  value="{{ $language['language_code'] }}"  data-content="<img src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> <span>{{ strtoupper($coun['title']).' - '. strtoupper($language['title']) }}</span>"> {{  strtoupper($language['title']) }}</option>
            @empty
            @endforelse
        @empty
        @endforelse --}}
    </select>
</form>
