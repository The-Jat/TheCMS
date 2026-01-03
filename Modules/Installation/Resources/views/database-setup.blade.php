@extends('installation::layouts.master')

@section('template_title')
    {{ trans('installation::installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('container')
    
    <div id="step-6" class="tab-item staps active">
        <div class="wizard-card">
            <div class="wizard-body">
                @include('installation::elements.errors')
                <form method="post" action="{{ route('LaravelInstaller::database') }}" class="tabs-wrap">
                    @csrf
                    <p class="db-installation-text">{{ trans('installation::installer_messages.configure_site.setup_db.label') }}</p> 
                    <a href="{{ route('LaravelInstaller::environmentWizard') }}" class="btn btn-secondary mt-3">{!! trans('installation::installer_messages.requirements.prev') !!}</a>
                    <button type="submit" class="btn btn-primary mt-3 DB-InstallationBtn">
                        {{ trans('installation::installer_messages.environment.wizard.form.buttons.installation') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
