<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigurationTableSeeder extends Seeder
{
    public function run()
    {
        $this->defaultConfiguration();
    }

    function defaultConfiguration()
    {
        $data = [
            [
                'name'          => 'Site.title',
                'value'         => 'W3CMS Laravel',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 1,
                'params'        => Null,
                'order'         => 1
            ],
            [
                'name'          => 'Site.tagline',
                'value'         => 'W3CMS - Laravel CMS System',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'textarea',
                'editable'      => 1,
                'weight'        => 2,
                'params'        => Null,
                'order'         => 2
            ],
            [
                'name'          => 'Site.email',
                'value'         => 'test@example.com',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 3,
                'params'        => Null,
                'order'         => 3
            ],
            [
                'name'          => 'Site.copyright',
                'value'         => '<strong class="text-dark">W3CMS</strong> Copyright © 2025 All Rights Reserved',
                'title'         => 'Copyright Text',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 4,
                'params'        => Null,
                'order'         => 4
            ],
            [
                'name'          => 'Site.contact',
                'value'         => '9876543210',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 5,
                'params'        => Null,
                'order'         => 5
            ],
            [
                'name'          => 'Site.menu_location',
                'value'         => 'a:5:{s:7:"primary";a:2:{s:5:"title";s:23:"Desktop Horizontal Menu";s:4:"menu";s:1:"1";}s:8:"expanded";a:2:{s:5:"title";s:21:"Desktop Expanded Menu";s:4:"menu";s:0:"";}s:6:"mobile";a:2:{s:5:"title";s:11:"Mobile Menu";s:4:"menu";s:0:"";}s:6:"footer";a:2:{s:5:"title";s:11:"Footer Menu";s:4:"menu";s:0:"";}s:6:"social";a:2:{s:5:"title";s:11:"Social Menu";s:4:"menu";s:0:"";}}',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 0,
                'weight'        => 6,
                'params'        => Null,
                'order'         => 6
            ],
            [
                'name'          => 'Site.biography',
                'value'         => 'A Wonderful Serenity Has Taken Possession Of My Entire Soul, Like These.',
                'title'         => null,
                'description'   => null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 7,
                'params'        => Null,
                'order'         => 7
            ],
            [
                'name'          => 'Site.locale',
                'value'         => 'en',
                'title'         => 'Select Language',
                'description'   => null,
                'input_type'    => 'select',
                'editable'      => 1,
                'weight'        => 8,
                'params'        => 'en,hi,fr,ru',
                'order'         => 8
            ],
            [
                'name'          => 'Site.default_role',
                'value'         => '1',
                'title'         => null,
                'description'   => 'For Newly Created Users',
                'input_type'    => null,
                'editable'      => 1,
                'weight'        => 9,
                'params'        => null,
                'order'         => 9
            ],
            [
                'name'          => 'Site.date_format',
                'value'         => 'F j, Y',
                'title'         => null,
                'description'   => null,
                'input_type'    => null,
                'editable'      => 1,
                'weight'        => 10,
                'params'        => null,
                'order'         => 10
            ],
            [
                'name'          => 'Site.custom_date_format',
                'value'         => 'F j, Y',
                'title'         => null,
                'description'   => null,
                'input_type'    => null,
                'editable'      => 1,
                'weight'        => 11,
                'params'        => null,
                'order'         => 11
            ],
            [
                'name'          => 'Site.time_format',
                'value'         => 'g:i A',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => null,
                'editable'      => 1,
                'weight'        => 12,
                'params'        => Null,
                'order'         => 12
            ],
            [
                'name'          => 'Site.custom_time_format',
                'value'         => 'g:i A',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => null,
                'editable'      => 1,
                'weight'        => 13,
                'params'        => Null,
                'order'         => 13
            ],
            [
                'name'          => 'Site.direction',
                'value'         => 'ltr',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 14,
                'params'        => Null,
                'order'         => 14
            ],
            [
                'name'          => 'Writing.editable',
                'value'         => 1,
                'title'         => 'Enable WYSIWYG editor',
                'description'   => Null,
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 15,
                'params'        => Null,
                'order'         => 15
            ],
            [
                'name'          => 'Reading.nodes_per_page',
                'value'         => 20,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 16,
                'params'        => Null,
                'order'         => 16
            ],
            [
                'name'          => 'Reading.show_on_front',
                'value'         => 'Post',
                'title'         => Null,
                'description'   => 'Home Page(Landing Page)',
                'input_type'    => 'radio',
                'editable'      => 1,
                'weight'        => 17,
                'params'        => 'Post,Page',
                'order'         => 17
            ],
            [
                'name'          => 'Reading.home_page',
                'value'         => null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 18,
                'params'        => Null,
                'order'         => 18
            ],
            [
                'name'          => 'Reading.blog_page',
                'value'         => null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 19,
                'params'        => Null,
                'order'         => 19
            ],
            [
                'name'          => 'Reading.public_blog_search',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 20,
                'params'        => Null,
                'order'         => 20
            ],
            [
                'name'          => 'Reading.multi_lang_theme',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 21,
                'params'        => Null,
                'order'         => 21
            ],
            [
                'name'          => 'Reading.lang_position',
                'value'         => 'Header',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 22,
                'params'        => Null,
                'order'         => 22
            ],
            [
                'name'          => 'Reading.language_widgets',
                'value'         => 6,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 23,
                'params'        => Null,
                'order'         => 23
            ],
            [
                'name'          => 'Permalink.settings',
                'value'         => Null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 24,
                'params'        => Null,
                'order'         => 24
            ],
            [
                'name'          => 'Theme.select_theme',
                'value'         => 'frontend/lemars',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 0,
                'weight'        => 25,
                'params'        => Null,
                'order'         => 25
            ],
            [
                'name'          => 'Theme.select_admin_theme',
                'value'         => 'admin/zenix',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 0,
                'weight'        => 26,
                'params'        => Null,
                'order'         => 26
            ],
            [
                'name'          => 'Environment.menu',
                'value'         => Null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 0,
                'weight'        => 27,
                'params'        => Null,
                'order'         => 27
            ],
            [
                'name'          => 'Discussion.close_comments_days_old',
                'value'         => 14,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 28,
                'params'        => Null,
                'order'         => 28
            ],
            [
                'name'          => 'Discussion.comment_max_links',
                'value'         => null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 29,
                'params'        => Null,
                'order'         => 29
            ],
            [
                'name'          => 'Discussion.comment_moderation',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 30,
                'params'        => Null,
                'order'         => 30
            ],
            [
                'name'          => 'Discussion.comment_order',
                'value'         => 'desc',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 31,
                'params'        => Null,
                'order'         => 31
            ],
            [
                'name'          => 'Discussion.comment_previously_approved',
                'value'         => 1,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 32,
                'params'        => Null,
                'order'         => 32
            ],
            [
                'name'          => 'Discussion.comment_status',
                'value'         => 1,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 33,
                'params'        => Null,
                'order'         => 33
            ],
            [
                'name'          => 'Discussion.comments_notify',
                'value'         => 1,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 34,
                'params'        => Null,
                'order'         => 34
            ],
            [
                'name'          => 'Discussion.comments_per_page',
                'value'         => 2,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 35,
                'params'        => Null,
                'order'         => 35
            ],
            [
                'name'          => 'Discussion.default_comments_page',
                'value'         => 'newest',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 36,
                'params'        => Null,
                'order'         => 36
            ],
            [
                'name'          => 'Discussion.disallowed_comment_keys',
                'value'         => null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 37,
                'params'        => Null,
                'order'         => 37
            ],
            [
                'name'          => 'Discussion.menu',
                'value'         => null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 38,
                'params'        => Null,
                'order'         => 38
            ],
            [
                'name'          => 'Discussion.moderation_keys',
                'value'         => null,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 39,
                'params'        => Null,
                'order'         => 39
            ],
            [
                'name'          => 'Discussion.moderation_notify',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 40,
                'params'        => Null,
                'order'         => 40
            ],
            [
                'name'          => 'Discussion.name_email_require',
                'value'         => 1,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 41,
                'params'        => Null,
                'order'         => 41
            ],
            [
                'name'          => 'Discussion.old_posts_comment_close',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 42,
                'params'        => Null,
                'order'         => 42
            ],
            [
                'name'          => 'Discussion.page_comments',
                'value'         => 1,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 43,
                'params'        => Null,
                'order'         => 43
            ],
            [
                'name'          => 'Discussion.pingback_flag',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 44,
                'params'        => Null,
                'order'         => 44
            ],
            [
                'name'          => 'Discussion.pingback_status',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 45,
                'params'        => Null,
                'order'         => 45
            ],
            [
                'name'          => 'Discussion.registration_comment',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 46,
                'params'        => Null,
                'order'         => 46
            ],
            [
                'name'          => 'Discussion.save_comments_cookie',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 47,
                'params'        => Null,
                'order'         => 47
            ],
            [
                'name'          => 'Discussion.show_comments_cookies_opt_in',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 48,
                'params'        => Null,
                'order'         => 48
            ],
            [
                'name'          => 'Discussion.thread_comments',
                'value'         => 1,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 49,
                'params'        => Null,
                'order'         => 49
            ],            
            [
                'name'          => 'Discussion.thread_comments_depth',
                'value'         => 4,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 50,
                'params'        => Null,
                'order'         => 50
            ],
            [
                'name'          => 'Settings.admin_layout',
                'value'         => 0,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 51,
                'params'        => Null,
                'order'         => 51
            ],
            [
                'name'          => 'Settings.admin_layout_options',
                'value'         => '{"typography":"poppins","version":"light","layout":"vertical","headerBg":"color_1","primary":"color_1","navheaderBg":"color_1","sidebarBg":"color_1","sidebarStyle":"full","sidebarPosition":"fixed","headerPosition":"fixed","containerLayout":"full","direction":"ltr"}',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => Null,
                'editable'      => 1,
                'weight'        => 52,
                'params'        => Null,
                'order'         => 52
            ],
        ];
        Configuration::insert($data);
    }
}
