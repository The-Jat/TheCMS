@extends('installation::layouts.master')

@section('template_title')
    {{ trans('installation::installer_messages.requirements.templateTitle') }}
@endsection

@section('container')

    <div id="step-1" class="tab-item staps active">
        <div class="wizard-card">
            <div class="wizard-body">
                @include('installation::elements.errors')
                <form method="POST" action="{{ route('LaravelInstaller::requirements') }}">
                    @csrf
                    <h3>{{ trans('installation::installer_messages.welcome.choose_language') }}</h3>
                    <select name="language" class="form-select select-country" size="9" aria-label="size 3 select example">
                        @forelse($installed_language as $key => $value)
                            <option value="{{ $key }}" {{ $key == 'en' ? 'selected="selected"' : '' }}>{{ $value }}</option>
                        @empty
                        @endforelse
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">
                        {{ trans('installation::installer_messages.requirements.next') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
