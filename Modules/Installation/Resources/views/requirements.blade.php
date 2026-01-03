@extends('installation::layouts.master')

@section('container')
    <div id="step-2" class="tab-item staps active">
        <div class="wizard-card">
            <div class="wizard-body">
                @include('installation::elements.errors')

                <h3>{{ trans('installation::installer_messages.requirements.title') }}</h3>
                @foreach($requirements['requirements'] as $type => $requirement)
                    <div class="lag-versoin">
                       <h5>{{ ucfirst($type) }} @if($type == 'php')({{ __('installation::installer_messages.version') }} {{ $phpSupportInfo['minimum'] }} {{ __('installation::installer_messages.requirements.required') }})@endif</h5>
                        @if($type == 'php')
                           <h5>{{ $phpSupportInfo['current'] }}
                            <svg class="ms-2" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M17.5626 7.93928L16.335 6.71186C16.0436 6.4205 15.8049 5.84472 15.8049 5.4318V3.69593C15.8049 2.87018 15.1303 2.19561 14.3048 2.19517H12.5682C12.1558 2.19517 11.5793 1.95597 11.2879 1.66482L10.0605 0.437407C9.47729 -0.145802 8.52238 -0.145802 7.93917 0.437407L6.71175 1.6657C6.42013 1.95707 5.84303 2.19561 5.43147 2.19561H3.6956C2.87095 2.19561 2.1955 2.87018 2.1955 3.69593V5.43184C2.1955 5.84314 1.95678 6.42072 1.66537 6.71191L0.437737 7.93933C-0.145912 8.52253 -0.145912 9.47744 0.437737 10.0616L1.66537 11.289C1.95696 11.5804 2.1955 12.1577 2.1955 12.5691V14.305C2.1955 15.1298 2.87095 15.8053 3.6956 15.8053H5.43152C5.84395 15.8053 6.42039 16.044 6.7118 16.3352L7.93922 17.5631C8.52242 18.1458 9.47733 18.1458 10.0605 17.5631L11.288 16.3352C11.5796 16.0438 12.1558 15.8053 12.5682 15.8053H14.3048C15.1303 15.8053 15.8049 15.1298 15.8049 14.305V12.5691C15.8049 12.156 16.0439 11.5802 16.335 11.289L17.5627 10.0616C18.1454 9.47744 18.1454 8.52249 17.5626 7.93928ZM7.80913 12.3753L4.49955 9.06523L5.56023 8.00476L7.8094 10.2539L12.4393 5.62512L13.4997 6.68558L7.80913 12.3753Z" fill="white"/>
                              </svg>
                           </h5>
                        @endif
                    </div>
                    <ul class="lang-ver-list">
                        @foreach($requirements['requirements'][$type] as $extention => $enabled)
                            <li>
                                <span>{{ $extention }}</span>
                                <span>
                                    @if($enabled)
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_70_4253)">
                                        <path d="M17.5626 7.93928L16.335 6.71186C16.0436 6.4205 15.8049 5.84472 15.8049 5.4318V3.69593C15.8049 2.87018 15.1303 2.19561 14.3048 2.19517H12.5682C12.1558 2.19517 11.5793 1.95597 11.2879 1.66482L10.0605 0.437407C9.47729 -0.145802 8.52238 -0.145802 7.93917 0.437407L6.71175 1.6657C6.42013 1.95707 5.84303 2.19561 5.43147 2.19561H3.6956C2.87095 2.19561 2.1955 2.87018 2.1955 3.69593V5.43184C2.1955 5.84314 1.95678 6.42072 1.66537 6.71191L0.437737 7.93933C-0.145912 8.52253 -0.145912 9.47744 0.437737 10.0616L1.66537 11.289C1.95696 11.5804 2.1955 12.1577 2.1955 12.5691V14.305C2.1955 15.1298 2.87095 15.8053 3.6956 15.8053H5.43152C5.84395 15.8053 6.42039 16.044 6.7118 16.3352L7.93922 17.5631C8.52242 18.1458 9.47733 18.1458 10.0605 17.5631L11.288 16.3352C11.5796 16.0438 12.1558 15.8053 12.5682 15.8053H14.3048C15.1303 15.8053 15.8049 15.1298 15.8049 14.305V12.5691C15.8049 12.156 16.0439 11.5802 16.335 11.289L17.5627 10.0616C18.1454 9.47744 18.1454 8.52249 17.5626 7.93928ZM7.80913 12.3753L4.49955 9.06523L5.56023 8.00476L7.8094 10.2539L12.4393 5.62512L13.4997 6.68558L7.80913 12.3753Z" fill="#00A389"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_70_4253">
                                        <rect width="18" height="18" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                    @else
                                        <svg width="18" height="18" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3"><circle cx="32" cy="32" fill="#ef3333" r="32"/><g fill="#fff" transform="matrix(.707 -.707 .707 .707 -13.097 31.944)"><path d="m14.512 28.782h34.999v5.999h-34.999z"/><path d="m29.012 14.282h5.999v34.999h-5.999z"/></g></g></svg>
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endforeach

                <ul class="lang-ver-list">
                    @foreach($permissions['permissions'] as $permission)
                    <li>
                      <span>{{ $permission['folder'] }}</span>
                      <span>
                        {{ $permission['permission'] }} 
                        @if($permission['isSet'])
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <g clip-path="url(#clip0_70_4253)">
                              <path d="M17.5626 7.93928L16.335 6.71186C16.0436 6.4205 15.8049 5.84472 15.8049 5.4318V3.69593C15.8049 2.87018 15.1303 2.19561 14.3048 2.19517H12.5682C12.1558 2.19517 11.5793 1.95597 11.2879 1.66482L10.0605 0.437407C9.47729 -0.145802 8.52238 -0.145802 7.93917 0.437407L6.71175 1.6657C6.42013 1.95707 5.84303 2.19561 5.43147 2.19561H3.6956C2.87095 2.19561 2.1955 2.87018 2.1955 3.69593V5.43184C2.1955 5.84314 1.95678 6.42072 1.66537 6.71191L0.437737 7.93933C-0.145912 8.52253 -0.145912 9.47744 0.437737 10.0616L1.66537 11.289C1.95696 11.5804 2.1955 12.1577 2.1955 12.5691V14.305C2.1955 15.1298 2.87095 15.8053 3.6956 15.8053H5.43152C5.84395 15.8053 6.42039 16.044 6.7118 16.3352L7.93922 17.5631C8.52242 18.1458 9.47733 18.1458 10.0605 17.5631L11.288 16.3352C11.5796 16.0438 12.1558 15.8053 12.5682 15.8053H14.3048C15.1303 15.8053 15.8049 15.1298 15.8049 14.305V12.5691C15.8049 12.156 16.0439 11.5802 16.335 11.289L17.5627 10.0616C18.1454 9.47744 18.1454 8.52249 17.5626 7.93928ZM7.80913 12.3753L4.49955 9.06523L5.56023 8.00476L7.8094 10.2539L12.4393 5.62512L13.4997 6.68558L7.80913 12.3753Z" fill="#00A389"/>
                              </g>
                              <defs>
                              <clipPath id="clip0_70_4253">
                              <rect width="18" height="18" fill="white"/>
                              </clipPath>
                              </defs>
                            </svg>
                        @else
                            <svg width="18" height="18" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3"><circle cx="32" cy="32" fill="#ef3333" r="32"/><g fill="#fff" transform="matrix(.707 -.707 .707 .707 -13.097 31.944)"><path d="m14.512 28.782h34.999v5.999h-34.999z"/><path d="m29.012 14.282h5.999v34.999h-5.999z"/></g></g></svg>
                        @endif
                          
                      </span>
                    </li>
                    @endforeach
                </ul>
                @if ( !isset($requirements['errors']) && !isset($permission['errors']) && $phpSupportInfo['supported'] )
                    <a href="{{ route('LaravelInstaller::welcome') }}" class="btn btn-secondary mt-3">{{ trans('installation::installer_messages.requirements.prev') }}</a>
                    <a href="{{ route('LaravelInstaller::environmentWizard') }}" class="btn btn-primary mt-3">{{ trans('installation::installer_messages.requirements.next') }}</a>
                @endif
            </div>
        </div>
    </div>
@endsection