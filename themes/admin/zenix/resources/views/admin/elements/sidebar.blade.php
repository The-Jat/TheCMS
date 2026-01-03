<!--**********************************
	Sidebar Fixed
***********************************-->


@php
    $current_user   = auth()->user();
    $user_name      = isset($current_user->full_name) ? $current_user->full_name : '';
    $user_email         = isset($current_user->email) ? $current_user->email : '';
    $userId         = isset($current_user->id) ? $current_user->id : '';
    $userImg        = HelpDesk::user_img($current_user->profile);
@endphp

@php
	$sub_menu_icon = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><polygon points="0 0 24 0 24 24 0 24"/><path d="M22,15 L22,19 C22,20.1045695 21.1045695,21 20,21 L8,21 C5.790861,21 4,19.209139 4,17 C4,14.790861 5.790861,13 8,13 L20,13 C21.1045695,13 22,13.8954305 22,15 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000" opacity="0.3"/><path d="M15.5421357,5.69999981 L18.3705628,8.52842693 C19.1516114,9.30947552 19.1516114,10.5758055 18.3705628,11.3568541 L9.88528147,19.8421354 C8.3231843,21.4042326 5.79052439,21.4042326 4.22842722,19.8421354 C2.66633005,18.2800383 2.66633005,15.7473784 4.22842722,14.1852812 L12.7137086,5.69999981 C13.4947572,4.91895123 14.7610871,4.91895123 15.5421357,5.69999981 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000" opacity="0.3"/><path d="M5,3 L9,3 C10.1045695,3 11,3.8954305 11,5 L11,17 C11,19.209139 9.209139,21 7,21 C4.790861,21 3,19.209139 3,17 L3,5 C3,3.8954305 3.8954305,3 5,3 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000"/></g></svg>';
@endphp

<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">
            <div class="image-bx">
                <img src="{{ $userImg }}" alt="{{ __('common.user_profile') }}">
                <a href="{!! route('admin.users.profile') !!}"><i class="fa fa-cog" aria-hidden="true"></i></a>
            </div>
            <h5 class="name"><span class="font-w400">{{ __('common.hello') }},</span> {{ $user_name }}</h5>
            <p class="email">{{ $user_email }}</p>
        </div>
        <ul class="metismenu" id="menu">

            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-141-home"></i>
                    <span class="nav-text">{{ __('common.dashboard') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ request()->is('admin') ? 'mm-active' : '' }}">
                        <a href="{!! url('/admin'); !!}">{{ __('common.dashboard') }}</a>
                    </li>
                </ul>
            </li>

            <li class="nav-label">{{ __('common.cms') }}</li>

            @canany(['Controllers > BlogsController > admin_index', 'Controllers > BlogsController > admin_create'])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-push-pin"></i>
                    <span class="nav-text">{{ __('common.blogs') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('Controllers > BlogsController > admin_index')
                        <li><a href="{{ route('blog.admin.index') }}">{{ __('common.all_blogs') }}</a></li>
                    @endcan
                    @can('Controllers > BlogsController > admin_create')
                        <li><a href="{{ route('blog.admin.create') }}">{{ __('common.add_new') }}</a></li>
                    @endcan
                    @can('Controllers > BlogCategoriesController > list')
                        <li><a href="{{ route('blog_category.admin.list') }}">{{ __('common.categories') }}</a></li>
                    @endcan
                    @can('Controllers > BlogTagsController > list')
                        <li><a href="{{ route('blog_tag.admin.list') }}">{{ __('common.tags') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['Controllers > PagesController > admin_index', 'Controllers > PagesController > admin_create'])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-049-copy"></i>
                    <span class="nav-text">{{ __('common.pages') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('Controllers > PagesController > admin_index')
                        <li><a href="{{ route('page.admin.index') }}">{{ __('common.all_pages') }}</a></li>
                    @endcan
                    @can('Controllers > PagesController > admin_create')
                        <li><a href="{{ route('page.admin.create') }}">{{ __('common.add_new_page') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany



            @if(Module::collections()->has('W3CPT'))
                {!! CptHelper::register_nav_menus() !!}
            @endif


            @canany(['Controllers > CommentsController > admin_index', 'Controllers > CommentsController > admin_edit'])
            <li>
                <a href="{{ route('comments.admin.index') }}">
                    <i class="flaticon-160-chat"></i>
                    <span class="nav-text">{{ __('common.comments') }}</span>
                </a>
            </li>
            @endcanany

            <li class="nav-label">{{ __('common.admin') }}</li>

            @canany(['Controllers > UsersController > index', 'Controllers > UsersController > create'])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-028-user-1"></i>
                    <span class="nav-text">{{ __('common.users') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('Controllers > UsersController > index')
                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">

                        <a href="{{ route('admin.users.index') }}">{{ __('common.all_users') }}</a>
                    </li>
                    @endcan
                    @can('Controllers > UsersController > create')
                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.users.create') }}">{{ __('common.add_user') }}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['Controllers > RolesController > index', 'Controllers > RolesController > create'])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-153-user"></i>
                    <span class="nav-text">{{ __('common.roles') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('Controllers > RolesController > index')
                    <li><a href="{{ route('admin.roles.index') }}">{{ __('common.all_roles') }}</a></li>
                    @endcan
                    @can('Controllers > RolesController > create')
                    <li><a href="{{ route('admin.roles.create') }}">{{ __('common.add_role') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['Controllers > PermissionsController > index', 'Controllers > PermissionsController > roles_permissions', 'Controllers > PermissionsController > user_permissions', 'Controllers > PermissionsController > temp_permissions'])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-035-shield"></i>
                    <span class="nav-text">{{ __('common.permissions') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('Controllers > PermissionsController > index')
                    <li><a href="{{ route('admin.permissions.index') }}">{{ __('common.all_permissions') }}</a></li>
                    @endcan
                    @can('Controllers > PermissionsController > temp_permissions')
                    <li><a href="{{ route('admin.permissions.temp_permissions') }}">{{ __('common.all_temp_permissions') }}</a></li>
                    @endcan
                    @can('Controllers > PermissionsController > roles_permissions')
                    <li><a href="{{ route('admin.permissions.roles_permissions') }}">{{ __('common.roles_permissions') }}</a></li>
                    @endcan
                    @can('Controllers > PermissionsController > user_permissions')
                    <li><a href="{{ route('admin.permissions.user_permissions') }}">{{ __('common.users_permissions') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
			@if(Module::collections()->has('CCMS'))
            <li class="nav-label">{{ __('common.ccms') }}</li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.businesses') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.businesses.index') }}">{{ __('common.listing') }}</a></li>
                    <li><a href="{{ route('admin.ccms.businesses.create') }}">{{ __('common.add') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.projects') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.projects.index') }}">{{ __('common.listing') }}</a></li>
                    <li><a href="{{ route('admin.ccms.projects.create') }}">{{ __('common.add') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.transaction_types') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.transaction_types.list') }}">{{ __('common.listing') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.parties') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.parties.index') }}">{{ __('common.listing') }}</a></li>
                    <li><a href="{{ route('admin.ccms.parties.create') }}">{{ __('common.add') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.invoices') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.invoices.index') }}">{{ __('common.listing') }}</a></li>
                    <li><a href="{{ route('admin.ccms.invoices.create') }}">{{ __('common.add') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.quotations') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.quotations.index') }}">{{ __('common.listing') }}</a></li>
                    <li><a href="{{ route('admin.ccms.quotations.create') }}">{{ __('common.add') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.inventories') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.inventories.index') }}">{{ __('common.listing') }}</a></li>
                    <li><a href="{{ route('admin.ccms.inventories.create') }}">{{ __('common.add') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.materials') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.ccms.materials.index') }}">{{ __('common.listing') }}</a></li>
                    <li><a href="{{ route('admin.ccms.materials.categories') }}">{{ __('common.material_category') }}</a></li>
                    <li><a href="{{ route('admin.ccms.materials.brands') }}">{{ __('common.material_brands') }}</a></li>
                </ul>
            </li>
			@endif
            <li class="nav-label">{{ __('common.appearance') }}</li>

            @canany(['Controllers > MenusController > admin_index', 'Controllers > ThemesController > index'])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-162-edit"></i>
                    <span class="nav-text">{{ __('common.appearance') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('Controllers > MenusController > admin_index')
                    <li><a href="{{ route('menu.admin.admin_index') }}">{{ __('common.menus') }}</a></li>
                    @endcan
                    @can('Controllers > ThemesController > index')
                    <li><a href="{{ route('themes.admin.index') }}">{{ __('common.themes') }}</a></li>
                    @endcan
                    @if(Module::collections()->has('W3Options'))
                        <li>
                            <a href="{{ route('w3options.admin.theme-options') }}">{{ __('common.theme_options') }} <span class="badge badge-xs badge-danger">{{ __('New') }}</span></a>
                        </li>
                        
                    @endif
                    @can('Controllers > WidgetsController > index')
                    <li class="{{ (DzHelper::controller() == 'WidgetsController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">

                        <a href="{{ route('admin.widgets.index') }}">{{ __('common.widgets') }}<span class="badge badge-xs badge-danger">{{ __('New') }}</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['Controllers > MenusController > admin_index', 'Controllers > ThemesController > index'])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-088-tools"></i>
                    <span class="nav-text">{{ __('common.tools') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('Controllers > ToolsController > export')
                    <li><a href="{{ route('tools.admin.export') }}">{{ __('common.export') }}</a></li>
                    @endcan
                    @can('Controllers > ToolsController > import')
                    <li><a href="{{ route('tools.admin.import') }}">{{ __('common.import') }}</a></li>
                    @endcan

                    <li><a href="javascript:void(0);" class="bg-light">{{ __('common.site_health') }} <span class="badge badge-xs badge-danger">{{ __('common.coming_soon') }}</span></a></li>
                </ul>
            </li>
            @endcanany

            @php
                $configuration_menu = HelpDesk::configuration_menu();
            @endphp

            @if(!empty($configuration_menu))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-073-settings"></i>
                        <span class="nav-text">{{ __('common.configuration') }}</span>
                    </a>
                    <ul aria-expanded="false">
                        @forelse($configuration_menu as $config_menu)
                            <li>
                                <a href="{{ route('admin.configurations.admin_prefix',$config_menu) }}">{{ DzHelper::admin_lang($config_menu) }}</a>
                            </li>
                        @empty
                        @endforelse
                        <li>
                            <a href="{{ route('admin.languages.index') }}">{{ __('common.translator') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(Module::collections()->has('CustomField'))
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">{{ __('common.custom_fields') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('customfields.admin.index') }}">{{ __('common.all_custom_feilds') }}</a></li>
                    <li><a href="{{ route('customfields.admin.create') }}">{{ __('common.add_custom_field') }}</a></li>
                </ul>
            </li>
            @endif

            @if(Module::collections()->has('W3CPT'))
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">{{ __('w3cpt::common.w3_post_types') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('cpt.admin.index') }}">{{ __('w3cpt::common.all_cpt') }}</a></li>
                    <li><a href="{{ route('cpt.admin.save') }}">{{ __('w3cpt::common.add_cpt') }}</a></li>
                    <li><a href="{{ route('cpt_taxo.admin.index') }}">{{ __('w3cpt::common.all_taxonomies') }}</a></li>
                    <li><a href="{{ route('cpt_taxo.admin.save') }}">{{ __('w3cpt::common.add_taxonomy') }}</a></li>
                </ul>
            </li>
            @endif

            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-161-alarm"></i>
                    <span class="nav-text">{{ __('common.notifications') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.notification.index') }}">{{ __('common.all_notifications') }}</a></li>
                    <li><a href="{{ route('admin.notification.notifications_config') }}">{{ __('common.all_notifications_config') }}</a></li>
                    <li><a href="{{ route('admin.notification.create') }}">{{ __('common.add_notification_config') }}</a></li>
                    <li><a href="{{ route('admin.notification.settings') }}">{{ __('common.notifications_config_settings') }}</a></li>
                </ul>
            </li>

        </ul>
        <div class="copyright">
            <p class="fs-12">{!! config('Site.footer_text') !!}</p>
        </div>
    </div>
</div>

<!--**********************************
	Sidebar End
***********************************
