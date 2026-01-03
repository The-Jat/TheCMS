<style>
    /* ---------------------
        Maintenance
    ----------------------- */
    .page-down{
        height: 100vh;
        display: table;
        width: 100%;
        background-size: cover;
        background-position: right top;
        padding-top: 0;
    }
    .page-down .container-fluid{
        display: table-cell;
        vertical-align: middle;
    }
    .pagedown-title{
        padding-left:10.3125rem;
        position:relative;
        margin-left: 3.125rem;
    }
    .pagedown-title h1{
        margin:0;
        font-weight:500;
        font-size:4.375rem;
        line-height:5rem;
        margin-bottom: 0.938rem;
        color:#fff;
    }
    .pagedown-title img{
        position: absolute;
        left: -0.625rem;
        top: 0.625rem;
        width: 10rem;
    }
    .pagedown-title p{
        margin:0;
        font-weight:300;
        font-size:1.75rem;
        line-height:2.5rem;
        opacity: 0.8;
        color:#fff;
    }
    @media only screen and (max-width: 1200px) {
        .pagedown-title{
            padding-left: 0;
            margin-left: 0;
            text-align: center;
        }
        .pagedown-title h1{
            font-size: 3.125rem;
            line-height: 1.2;
        }
        .pagedown-title img{
            position: unset;
            width: 6.25rem;
            margin-bottom: 1.25rem;
        }
        .pagedown-title p{
            font-size: 1.375rem;
            line-height: 1.5;
        }
    }
    @media only screen and (max-width: 576px) {
        .pagedown-title h1{
            font-size: 1.75rem;
            margin-bottom: 0.625rem;
        }
        .pagedown-title img{
            width: 3.75rem;
            margin-bottom: 0.938rem;
        }
        .pagedown-title p{
            font-size: 1rem;
        }
    }
</style>

<div class="content-block">
<!-- Maintenance Page -->
    <div class="section-full bg-white content-inner-2 page-down overlay-black-light" style="background-image:url({{$maintenance_bg}}); background-size:cover; background-position:right top;">
        <div class="container-fluid">
            <div class="pagedown-title">
                <img src="{{$maintenence_icon}}" alt="{{ DzHelper::theme_lang('Image') }}">
                <h1>{!! DzHelper::theme_lang($maintenance_title) !!}</h1>
                <p>{!! DzHelper::theme_lang($maintenance_desc ) !!}</p>
            </div>
        </div>
    </div>
    <!-- Maintenance Page End -->
</div>
