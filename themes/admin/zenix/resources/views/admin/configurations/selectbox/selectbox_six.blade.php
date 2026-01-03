<form action="{{ route('language') }}" method="POST" id="theme-lang-id" >
    @csrf
    <select class="form-control lang-dropdown-box" data-live-search="true" data-width="fit" name="language"  onchange="javascript:this.form.submit()">
        @forelse($records as $coun)
            <option @selected(session()->get('language') && $coun->language_code == session('language')) data-content=" <span class=''> {{ config('lang.country.'.$coun->country).' - '.config('lang.language1.'.$coun->title) }} </span>" value="{{ $coun->language_code }}">{{ config('lang.country.'.$coun->country).' - '.config('lang.language1.'.$coun->title) }}</option>
        @empty
        @endforelse
    </select>
</form>
