@extends('installation::layouts.master')

@section('template_title')
    {{ trans('installation::installer_messages.final.templateTitle') }}
@endsection


@section('container')

    <div id="step-7" class="tab-item staps active">
        <div class="wizard-card">
            <div class="wizard-body">
                @include('installation::elements.errors')
                <h3>{!! trans('installation::installer_messages.environment.wizard.step7_title') !!}</h3>
                <span class="w-75">{!! trans('installation::installer_messages.environment.wizard.step7_description') !!}</span>
                <div class="d-block">
                    <a href="{{ url('/admin') }}" class="btn btn-primary mt-3">{{ trans('installation::installer_messages.final.exit') }}</a>
                </div>
            </div>
        </div>
    </div>

@endsection
