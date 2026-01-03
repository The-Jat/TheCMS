<div class="section-full bg-white content-inner about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center section-head">
                    <h1 class="title-head1">{{ DzHelper::theme_lang(isset($args['title']) ? $args['title'] : '') }}</h1>
                </div>
                <div class="alignwide w-100 m-0">
                    <figure class="aligncenter">
                        <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image']) }}" alt="{{ __('content Image') }}">
                    </figure>
                </div>
                <div class="blog-post blog-single blog-post-style-2">
                    <div class="dlab-post-info">
                        <div class="dlab-post-text text">
                            <div class="row text-justify">
                                <div class="col-lg-6">
                                    <p>{{ DzHelper::theme_lang(isset($args['content1']) ? $args['content1'] : '') }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <p>{{ DzHelper::theme_lang(isset($args['content2']) ? $args['content2'] : '') }}</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <ul class="list-inline link-btn-style m-b0">
                                    <li><a target="_blank" href="{{ isset($args['facebook_link']) ? $args['facebook_link'] : 'javascript: void(0);' }}"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a target="_blank" href="{{ isset($args['twitter_link']) ? $args['twitter_link'] : 'javascript: void(0);' }}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a target="_blank" href="{{ isset($args['whatsapp_link']) ? $args['whatsapp_link'] : 'javascript: void(0);' }}"><i class="fab fa-whatsapp"></i></a></li>
                                    <li><a target="_blank" href="{{ isset($args['instagram_link']) ? $args['instagram_link'] : 'javascript: void(0);' }}"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
