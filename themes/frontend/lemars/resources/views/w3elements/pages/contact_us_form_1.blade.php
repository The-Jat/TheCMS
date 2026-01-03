<!-- Contact Us Page -->
<div class="section-full bg-white content-inner-1 contact-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="text-center section-head">
                    <h1 class="contact-title">{{ DzHelper::theme_lang(isset($args['title']) ? $args['title'] : '') }}</h1>
                </div>

                @if(isset($args['show_image']) && $args['show_image'] === 'true')
                    <div class="banner-contact">
                        <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image']) }}" alt="{{ __('Contact Image') }}">
                    </div>
                @endif
                <div class="row">
                    <div class="col-xl-9 col-lg-8 m-b30">
                        <form method="POST" action="{{ route('front.contact') }}">
                            @csrf
                            <div class="row form-set">
                                @if($errors->any())
                                    <div class="col-12 m-b30">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ implode(', ', $errors->all(':message')) }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif
                                @if( Session::get('success') )
                                    <div class="col-12 m-b30">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ Session::get('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xl-6 mb-3 mb-md-4">
                                    <input name="first_name" required type="text" class="form-control" placeholder="{{ DzHelper::theme_lang('First Name') }}">
                                </div>
                                <div class="col-xl-6 mb-3 mb-md-4">
                                    <input name="last_name" type="text" class="form-control" placeholder="{{ DzHelper::theme_lang('Last Name') }}">
                                </div>
                                <div class="col-xl-6 mb-3 mb-md-4">
                                    <input name="email" required type="text" class="form-control" placeholder="{{ DzHelper::theme_lang('Email Address') }}">
                                </div>
                                <div class="col-xl-6 mb-3 mb-md-4">
                                    <input name="phone_number" required type="text" class="form-control" placeholder="{{ DzHelper::theme_lang('Phone No.') }}">
                                </div>
                                <div class="col-xl-12 mb-3 mb-md-4">
                                    <textarea rows="4" name="message" required class="form-control" placeholder="{{ DzHelper::theme_lang('Message') }}"></textarea>
                                </div>
                                <div class="col-md-12 col-sm-12 text-center">
                                    <button name="submit" type="submit" value="Submit" class="btn radius-xl">{{ DzHelper::theme_lang('Send Message') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-3 col-lg-4 m-b30">
                        <div class="contact-info">
                            <div class="extra-info">
                                <div class="text-uppercase info-title text-center">{{ DzHelper::theme_lang('Additional info') }}</div>
                                <ul>
                                    <li><i class="la la-location-arrow"></i> {{ DzHelper::theme_lang(isset($args['address']) ? $args['address'] : '') }}</li>
                                    <li><i class="la la-globe"></i> {{ isset($args['email']) ? $args['email'] : '' }}</li>
                                    <li><i class="la la-mobile-phone"></i> {{ isset($args['phone']) ? $args['phone'] : '' }}</li>
                                </ul>
                            </div>
                            @if(isset($args['social_icon']) && !empty($args['social_icon']))
                            <div class="text-center">
                                <ul class="list-inline link-btn-style m-b0">
                                    @php
                                        $social_icons = array(
                                            'facebook'  => '<i class="fab fa-facebook-f"></i>',
                                            'instagram' => '<i class="fab fa-instagram"></i>',
                                            'whatsapp'  => '<i class="fab fa-whatsapp"></i>',
                                            'twitter'   => '<i class="fab fa-twitter"></i>',
                                            'youtube'   => '<i class="fab fa-youtube"></i>',
                                            'linkedin'  => '<i class="fab fa-linkedin-in"></i>',
                                            'reddit'    => '<i class="fab fa-reddit-alien"></i>',
                                            'pinterest' => '<i class="fab fa-pinterest"></i>',
                                            'google'    => '<i class="fab fa-google-plus-g"></i>'
                                        );
                                    @endphp
                                    @foreach($args['social_icon'] as $icon)
                                    <li><a target="_blank" href="{{ isset($icon['social_link']) ? $icon['social_link'] : '#' }}">{!! $social_icons[$icon['icon']] !!}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Us Page End -->
