{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('common.configurations') }}</h4>
                <span>{{ Str::ucfirst($prefix) }} {{ __('common.configurations') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.configurations.admin_index') }}">{{ __('common.configurations') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ Str::ucfirst($prefix) }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('common.reading_configuration') }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('admin.configurations.admin_reading') }}" method="post" id="reading-filters" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('common.show_on_front') }}</label>
                                <div class="col-sm-6 form-group">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input ReadingPostBtn" name="Reading[show_on_front]" id="show_on_front_post" value="Post" {{ (config('Reading.show_on_front') == 'Post') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_on_front_post">{{ __('common.post') }}</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="radio" class="form-check-input ReadingPostBtn" name="Reading[show_on_front]" id="show_on_front_page" value="Page" {{ (config('Reading.show_on_front') == 'Page') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_on_front_page">{{ __('common.page') }}</label>
                                    </div>
                                    <div class="reading-filters text-nowrap d-flex align-items-center page-filters mb-3 {{ (config('Reading.show_on_front') == 'Post') ? 'd-none' : '' }}">
                                        <label class="form-check-label me-3" for="show_on_front_page">{{ __('common.homepage') }}</label>
                                        <select name="Reading[home_page]" class="form-control default-select">
                                            <option disabled selected>{{ __('Select Page') }}</option>
                                            @forelse($pages as $page)
                                                @if($page->status != 3)
                                                    <option {{ (config('Reading.home_page') == $page->slug) ? 'selected' : '' }} value="{{ $page->slug }}">{{ $page->title }}</option>
                                                @endif
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('common.nodes_per_page') }}</label>
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="Reading[nodes_per_page]"  class="form-control" value="{{ config('Reading.nodes_per_page') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('common.search_engine_visibility') }}</label>
                                <div class="col-sm-6 form-group">
                                    <div class="form-check">
                                        <input type="hidden" name="Reading[public_blog_search]" value="0">
                                        <input class="form-check-input" type="checkbox" name="Reading[public_blog_search]" value="1" @checked(config('Reading.public_blog_search') == 1)>
                                        <label class="form-check-label">{{ __('common.discourage_search_engines_from_indexing_this_site') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('common.multilanguage_setting') }}</label>
                                <div class="col-sm-6 form-group">
                                    <div class="form-check">
                                        <input type="hidden" name="Reading[multi_lang_theme]" value="0">
                                        <input class="form-check-input reading-multi-lang" id="reading-multi-lang-id" type="checkbox" name="Reading[multi_lang_theme]" value="1" @checked(config('Reading.multi_lang_theme') == 1)>
                                         <label class="form-check-label">{{ __('common.show_language_selectbox_on_website') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group reading-multi-position row  {{ (config('Reading.multi_lang_theme') == 0) ? 'd-none' : '' }}">
                                <label class="col-sm-3 col-form-label">{{ __('common.language_select_position') }}</label>
                                <div class="col-sm-6 form-group">

                                        <div class="form-check">
                                            <input type="radio" class="form-check-input LangPostionBtn" name="Reading[lang_position]" id="lang_position_header" value="Header" {{ (config('Reading.lang_position') == 'Header') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_on_front_post">{{ __('common.header') }}</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="radio" class="form-check-input LangPostionBtn" name="Reading[lang_position]" id="lang_position_footer" value="Footer" {{ (config('Reading.lang_position') == 'Footer') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_on_front_page">{{ __('common.footer') }}</label>
                                        </div>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('common.language_widgets') }}</label>
                                <div class="col-sm-6 form-group">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input " name="Reading[language_widgets]" id="selectbox_one" value="1" {{ (config('Reading.language_widgets') == '1') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_on_front_post">
                                            <select class="form-control image-select dropdown_list" data-live-search="true" data-flag="true" name="language" >
                                                {{-- mainLanguageListSort --}}
                                                @forelse($mainLanguageList as  $key => $coun)
                                                            @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';
                                                            @endphp

                                                        @if($coun['lang_type']=='main')
                                                            <option @selected( $coun['language']['language_code'] == 'hi') value="{{ $coun['language']['language_code'] }}" data-content="<img src='{{ asset('images/flags/32/'.strtolower($file).'.png') }}'/> <span class=''>{{ strtoupper($coun['country']['title']) }}</span>"> {{ $coun['country']['title'] }}</option>
                                                        @endif

                                                @empty
                                                @endforelse
                                            </select>
                                        </label>
                                    </div>


                                    <div class="form-check">
                                        <input type="radio" class="form-check-input " name="Reading[language_widgets]" id="selectbox_two" value="2" {{ (config('Reading.language_widgets') == '2') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="show_on_front_post">

                                            <select class="form-control image-select dropdown_list" data-live-search="true" data-flag="true" name="language" >
                                                 @forelse($mainLanguageListSort as $coun)
                                                    @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';  @endphp
                                                        <option @selected( $coun['language']['language_code'] == 'hi') value="{{ $coun['language']['language_code'] }}"  data-content="<img src='{{ asset('/images/flags/32/'.strtolower($file).'.png') }}'/> <span>{{  strtoupper($coun['language']['title']) }}</span>"> {{  strtoupper($coun['language']['title']) }}</option>

                                                @empty
                                                @endforelse
                                            </select>



                                        </label>
                                    </div>


                                    <div class="form-check">
                                        <input type="radio" class="form-check-input " name="Reading[language_widgets]" id="selectbox_three" value="3" {{ (config('Reading.language_widgets') == '3') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="show_on_front_post">
                                            <select class="form-control image-select dropdown_list" data-live-search="true" data-flag="true" name="language" >
                                                @forelse($mainLanguageListSort as $coun)
                                                    @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';  @endphp
                                                        <option @selected( $coun['language']['language_code'] == 'hi') value="{{ $coun['language']['language_code'] }}"  data-content="<img src='{{ asset('/images/flags/32/'.strtolower($file).'.png') }}'/> <span>{{  strtoupper($coun['language']['lang_title']) }}</span>"> {{  strtoupper($coun['language']['lang_title']) }}</option>

                                                @empty
                                                @endforelse
                                            </select>
                                        </label>
                                    </div>

                                    <div class="form-check ">
                                        <input type="radio" class="form-check-input " name="Reading[language_widgets]" id="selectbox_four" value="4" {{ (config('Reading.language_widgets') == '4') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="show_on_front_post">
                                            <select class="form-control image-select dropdown_list "  data-width="fit" data-flag="true" name="language" >
                                                @forelse($mainLanguageList as  $key => $coun)
                                                                @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';
                                                                @endphp

                                                            @if($coun['lang_type']=='main')
                                                                <option @selected( $coun['language']['language_code'] == 'hi') value="{{ $coun['language']['language_code'] }}" data-content="<img  src='{{ asset('/images/flags/32/'.strtolower($file).'.png') }}'/> <span class=''></span>"> {{ $coun['country']['title'] }}</option>
                                                            @endif

                                                    @empty
                                                    @endforelse
                                            </select>
                                        </label>
                                    </div>


                                    <div class="form-check">
                                        <input type="radio" class="form-check-input " name="Reading[language_widgets]" id="selectbox_five"   value="5" {{ (config('Reading.language_widgets') == '5') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="show_on_front_post">
                                            <select class="form-control lang-dropdown-box image-select" data-live-search="true" data-width="fit" name="language" >
                                                @forelse($mainLanguageListSort as $coun)
                                                    @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';  @endphp
                                                        <option @selected( $coun['language']['language_code'] == 'hi') value="{{ $coun['language']['language_code'] }}"  data-content="<img src='{{ asset('/images/flags/32/'.strtolower($file).'.png') }}'/> <span>{{ strtoupper($coun['country']['title']).' - '. strtoupper($coun['language']['title']) }}</span>"> {{   strtoupper($coun['country']['title']).' - '. strtoupper($coun['language']['title']) }}</option>

                                                @empty
                                                @endforelse
                                            </select>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="radio" class="form-check-input " name="Reading[language_widgets]" id="selectbox_six"   value="6" {{ (config('Reading.language_widgets') == '6') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="show_on_front_post">

                                            <select class="form-control lang-dropdown-box image-select" data-live-search="true" data-width="fit" name="language" >
                                                @forelse($mainLanguageListSort as $coun)
                                                @php $file =($coun['country']['iso_code']!=null) ? $coun['country']['iso_code'] : 'default';  @endphp
                                                    <option @selected( $coun['language']['language_code'] == 'hi') value="{{ $coun['language']['language_code'] }}"  data-content="<img src='{{ asset('/images/flags/32/'.strtolower($file).'.png') }}'/> <span>{{ strtoupper($coun['country']['country_title']).' - '. strtoupper($coun['language']['lang_title']) }}</span>"> {{   strtoupper($coun['country']['country_title']).' - '. strtoupper($coun['language']['lang_title']) }}</option>

                                            @empty
                                            @endforelse
                                            </select>
                                        </label>

                                    </div>

                                </div>
                            </div>


                            <div class="form-group row ">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
