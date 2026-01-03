<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ConfigurationTableSeeder::class);
        $this->call(NotificationConfigTableSeeder::class);
        $this->call(NotificationTemplateTableSeeder::class);
        
        Role::firstOrCreate(
            ['name' => 'Super Admin'],
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            ['name' => 'Admin'],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            ['name' => 'Manager'],
            [
                'name' => 'Manager',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            ['name' => 'Customer'],
            [
                'name' => 'Customer',
                'guard_name' => 'web',
            ]
        );

        
        $this->defaultBlog();
        $this->defaultPage();
        $this->defaultMenu();

    }
    
    
    function defaultPage()
    {
        $page = Page::create([
            'user_id'       => '1',  
            'title'         => 'Sample page',
            'slug'          => 'sample-page',  
            'content'       => '<div class="section-full bg-white content-inner about-us">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="text-center section-head">
<h1 class="title-head1">Sample Page</h1>
</div>

<div class="alignwide">
<figure class="aligncenter"></figure>
</div>

<div class="blog-post blog-single blog-post-style-2">
<div class="dlab-post-info">
<div class="dlab-post-text text">
<div class="row text-justify">
<div class="col-lg-6">
<p>W3CMS Laravel is a powerful, flexible, and user-friendly Content Management System (CMS) built on the Laravel framework. It provides a robust platform for creating and managing dynamic websites and web applications. Leveraging the versatility and scalability of Laravel, W3CMS allows developers to customize and extend the system with ease while offering a simple, intuitive interface for content editors.</p>
</div>

<div class="col-lg-6">
<p>With features like multi-language support, custom themes, and easy integration with third-party tools, W3CMS is ideal for businesses and developers looking for a solid foundation to build modern, responsive websites. Whether you&#39;re creating a simple blog or a complex enterprise-level application, W3CMS Laravel simplifies the development process, ensuring your project is both efficient and scalable.</p>
</div>
</div>

<div class="text-center">
<ul class="list-inline link-btn-style m-b0">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>',
            'excerpt'       => 'Excerpt2',
            'comment'       => 1,
            'page_type'     => 'Page',
            'status'        => '1',
            'visibility'    => 'Pu',
            'publish_on'    => date('Y-m-d h:i:s'),
        ]);

        $page->page_metas()->create([
            'title' => 'w3_page_options',
            'value' => 'a:10:{s:17:"page_header_style";s:8:"header_1";s:19:"page_banner_setting";s:6:"custom";s:14:"page_banner_on";s:1:"0";s:16:"page_banner_type";s:5:"image";s:18:"page_banner_height";s:18:"page_banner_medium";s:25:"page_banner_custom_height";s:3:"450";s:15:"page_breadcrumb";s:1:"1";s:16:"page_banner_hide";s:1:"0";s:17:"page_show_sidebar";s:1:"0";s:19:"page_sidebar_layout";s:13:"sidebar_right";}',
        ]);
    }
    
    function defaultBlog()
    {
        $blog = Blog::create([
            'user_id'       =>  '1',  
            'title'         => 'Hello World',
            'slug'          => 'hello-world',  
            'excerpt'          => 'Welcome to W3CMS! This is your first post. You can easily edit or delete it, and start creating your content.',  
            'content'       => 'Welcome to W3CMS! This is your first post. You can easily edit or delete it, and start creating your content. W3CMS is a flexible, easy-to-use Content Management System built on the powerful Laravel framework, designed to help you build dynamic and scalable websites with ease. Customize your site, manage your content, and explore a variety of features to enhance your web development experience. Happy writing!',
            'comment'        => 1,
            'status'        => '1',
            'visibility'    => 'Pu',
            'publish_on'    => date('Y-m-d h:i:s'),
        ]);

        $blog->blog_meta()->create([
            'title' => 'w3_blog_options',
            'value' => 'a:12:{s:11:"post_layout";s:13:"post_standard";s:22:"post_type_quote_author";s:11:"Author Name";s:20:"post_type_quote_text";s:10:"Quote Text";s:17:"post_show_sidebar";s:1:"0";s:19:"post_sidebar_layout";s:13:"sidebar_right";s:14:"featured_image";s:1:"0";s:15:"post_pagination";s:1:"0";s:19:"post_header_setting";s:13:"theme_default";s:17:"post_header_style";s:8:"header_1";s:19:"post_footer_setting";s:13:"theme_default";s:14:"post_footer_on";s:1:"1";s:17:"post_footer_style";s:17:"footer_template_1";}',
        ]);
    }
    
    function defaultMenu()
    {
        $menu1 = Menu::create(
            [
                'user_id'       => '1',  
                'title'         => 'Primary Menu',
                'slug'          => 'primary-menu',  
                'order'         => '1',
            ]
        );

        $menu2 = Menu::create(
            [
                'user_id'       => '1',  
                'title'         => 'Footer Menu',
                'slug'          => 'footer-menu',  
                'order'         => '2',
            ]
        );

        $menu1->menu_items()->create([
            'parent_id' => 0,
            'menu_id' => 1,
            'item_id' => 1,
            'type' => 'Page',
            'title' => 'Home',
            'attribute' => 'Home',
            'menu_target' => 0,
            'order' => 0,

        ]);

        $menu2->menu_items()->create([
            'parent_id' => 0,
            'menu_id' => 2,
            'item_id' => 1,
            'type' => 'Page',
            'title' => 'Home',
            'attribute' => 'Home',
            'menu_target' => 0,
            'order' => 0,

        ]);
    }
}
