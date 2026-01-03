
<style>
    /* ---------------------
        Coming Soon
    ----------------------- */
    .coming-soon{
        height: 100vh;
        position: relative;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .countdown{
        margin-left: auto;
        margin-bottom: 30px;
    }
    .coming-soon .logo{
        width: 160px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 30px;
    }
    .coming-soon .cs-title{
        font-size: 4.5rem;
        color: #fff;
        font-weight: 900;
        display: block;
        font-family: 'Josefin Sans', sans-serif;
        line-height: 1;
        margin-bottom: 30px;
    }
    .countdown .date div strong{
        font-size: 1.25rem;
        font-weight: 400;
        color: #1b1b1b;
        text-transform: uppercase;
        box-shadow: inset 0rem -0.25rem 0  #000;
        line-height: 1.125rem;
        display: inline-block;
    }
    .countdown .date div{
        display:block;
        line-height: 1.875rem;
    }
    .countdown .date {
        display: inline-block;
        text-align: center;
        width: 8.125rem;
        color: #fff;

    }
    .countdown .date  span{
        height: auto;
        width: auto;
        background: transparent;
        margin: 0;
    }
    .countdown .date .time{
        font-size: 4.375rem;
        color:#fff !important;
        font-weight: 900;
        display: block;
        font-family: 'Josefin Sans', sans-serif;
        line-height: 1;

    }
    .countdown-social{
        margin:0;
        padding:0;
        list-style:none;
    }
    .countdown-social li{
        display:inline-block;
        margin:0 5px;
    }
    .countdown-social li a{
        width: 45px;
        height: 45px;
        border: 1px solid #fff;
        border-radius: 45px;
        color: #fff;
        line-height: 43px;
        font-size: 20px;
    }
    @media only screen and (max-width: 991px) {
        .countdown{
            margin-left: 0;
        }
    }
    @media only screen and (max-width: 576px) {
        .countdown .date {
            width: 4.375rem;
        }
        .countdown .date div strong{
            font-size: 0.75rem;
            line-height: 0.75rem;
        }
        .countdown .date .time{
            font-size: 2.5rem;
            line-height: 1;
        }
        .coming-soon .cs-title {
            font-size: 2.5rem;
        }
        .coming-soon .logo {
            width: 120px;
        }
    }
</style>

<div class="content-block">
    <!-- Coming Soon -->
    <div class="section-full bg-white content-inner-2 coming-soon overlay-black-light" style="background-image:url({{$comingsoon_bg}}); background-size:cover;">
        <div class="container">
            <div class="text-center">
                <div class="cs-logo">
                    <div class="logo">
                        @if ($logo_type == 'text_logo')
                        <div class="text-logo">
                            @if (!empty($logo_text))
                            <h1 class="site-title">
                                <a href="{{url( '/' )}}" title="{{$logo_title}}">
                                    {{$logo_text}}
                                </a>
                            </h1>
                            @endif
                            @if(!empty($logo_tag))
                                <p class="site-description">{{$logo_tag}}</p>
                            @endif
                        </div>
                        @else
                        <a href="{{url( '/' )}}" title="{{$logo_title}}">
                            <img src="{{$logo}}" alt="{{$logo_alt}}"/>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="cs-title">{{ DzHelper::theme_lang('Coming Soon') }}</div>
                <div class="countdown text-center" data-date="{{ $comingsoon_launch_date }}">
                    <div class="date"><span class="time days text-primary"></span>
                        <span>{{ DzHelper::theme_lang('Days') }}</span>
                    </div>
                    <div class="date"><span class="time hours text-primary"></span>
                        <span>{{ DzHelper::theme_lang('Hours') }}</span>
                    </div>
                    <div class="date"><span class="time mins text-primary"></span>
                        <span>{{ DzHelper::theme_lang('Minutes') }}</span>
                    </div>
                    <div class="date"><span class="time secs text-primary"></span>
                        <span>{{ DzHelper::theme_lang('Second') }}</span>
                    </div>
                </div>
                <ul class="countdown-social">
                    {!! get_social_icons() !!}
                </ul>
            </div>
        </div>
    </div>
    <!-- Coming Soon End -->
</div>





