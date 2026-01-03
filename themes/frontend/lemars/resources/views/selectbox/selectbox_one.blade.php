<form action="{{ route('language') }}" method="POST" id="theme-lang-id">
    @csrf
        <select class="image-select language-dropdown" data-live-search="true" data-flag="true" name="language"  onchange="javascript:this.form.submit()">
            @forelse($records as  $key => $coun)
                @php
                    $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';
                @endphp

                @if($coun['lang_type']=='main')
                    <option @selected(session()->get('language') && $coun['language']['language_code'] == session('language')) value="{{ $coun['language']['language_code'] }}" data-content="<img  src='{{ theme_asset('/images/flags/32/'.$file.'.png') }}'/> <span class=''>{{ strtoupper($coun['country']['title']) }}</span>"> {{ $coun['country']['title'] }}</option>
                @endif
            @empty
            @endforelse
        </select>
    </form>

