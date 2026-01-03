<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;

class NotificationTemplateTableSeeder extends Seeder
{
    public function run()
    {
        $this->defaultNotificationTemplate();
    }

    function defaultNotificationTemplate()
    {
        $data = [
            [
                "notification_config_id" => "1",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Created New Blog #BLOGTITLE#",
                "slug" => "w3-c-m-s:-created-new-blog#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>New blog created by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTITLE#</h3>\r\n\r\n<p>#BLOGCONTENT#</p>"
            ],
            [
                "notification_config_id" => "2",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Blog #BLOGTITLE#",
                "slug" => "w3-c-m-s:-updated-blog#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>Blog updated by: #USERNAME#</p>\n\n<h3>#BLOGTITLE#</h3>\n#BLOGCONTENT#"
            ],
            [
                "notification_config_id" => "3",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Blog #BLOGTITLE#",
                "slug" => "w3-c-m-s:-deleted-blog#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>Blog deleted by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTITLE#</h3>\r\n\r\n<p>#BLOGCONTENT#</p>"
            ],
            [
                "notification_config_id" => "4",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Trashed Blog #BLOGTITLE#",
                "slug" => "w3-c-m-s:-trashed-blog#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>Blog trashed by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTITLE#</h3>\r\n\r\n<p>#BLOGCONTENT#</p>"
            ],
            [
                "notification_config_id" => "5",
                "notification_type_id" => "1",
                "subject" => "W3CMS: New Blog Category Added #BLOGCATEGORYTITLE#",
                "slug" => "w3-c-m-s:-new-blog-category-added#-b-l-o-g-c-a-t-e-g-o-r-y-t-i-t-l-e#",
                "content" => "<p>New blog category added by: #USERNAME#</p>\r\n\r\n<h3>#BLOGCATEGORYTITLE#</h3>\r\n\r\n<p>#BLOGCATEGORYCONTENT#</p>"
            ],
            [
                "notification_config_id" => "6",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Blog Category #BLOGCATEGORYTITLE#",
                "slug" => "w3-c-m-s:-updated-blog-category#-b-l-o-g-c-a-t-e-g-o-r-y-t-i-t-l-e#",
                "content" => "<p>Blog category updated by: #USERNAME#</p>\r\n\r\n<h3>#BLOGCATEGORYTITLE#</h3>\r\n\r\n<p>#BLOGCATEGORYCONTENT#</p>"
            ],
            [
                "notification_config_id" => "7",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Blog Category #BLOGCATEGORYTITLE#",
                "slug" => "w3-c-m-s:-deleted-blog-category#-b-l-o-g-c-a-t-e-g-o-r-y-t-i-t-l-e#",
                "content" => "<p>Blog category deleted by: #USERNAME#</p>\r\n\r\n<h3>#BLOGCATEGORYTITLE#</h3>\r\n\r\n<p>#BLOGCATEGORYCONTENT#</p>"
            ],
            [
                "notification_config_id" => "8",
                "notification_type_id" => "1",
                "subject" => "W3CMS: New Blog Tag Added #BLOGTAGTITLE#",
                "slug" => "w3-c-m-s:-new-blog-tag-added#-b-l-o-g-t-a-g-t-i-t-l-e#",
                "content" => "<p>New blog tag added by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTAGTITLE#</h3>"
            ],
            [
                "notification_config_id" => "9",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Blog Tag #BLOGTAGTITLE#",
                "slug" => "w3-c-m-s:-updated-blog-tag#-b-l-o-g-t-a-g-t-i-t-l-e#",
                "content" => "<p>Blog tag updated by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTAGTITLE#</h3>"
            ],
            [
                "notification_config_id" => "10",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Blog Tag #BLOGTAGTITLE#",
                "slug" => "w3-c-m-s:-deleted-blog-tag#-b-l-o-g-t-a-g-t-i-t-l-e#",
                "content" => "<p>Blog tag deleted by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTAGTITLE#</h3>"
            ],
            [
                "notification_config_id" => "11",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Blog New Comment #BLOGTITLE#",
                "slug" => "w3-c-m-s:-blog-new-comment#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>Blog new comment by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTITLE#</h3>\r\n\r\n<p>#BLOGCOMMENT#</p>"
            ],
            [
                "notification_config_id" => "12",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Blog Comment #BLOGTITLE#",
                "slug" => "w3-c-m-s:-updated-blog-comment#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>Blog comment updated by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTITLE#</h3>\r\n\r\n<p>#BLOGCOMMENT#</p>"
            ],
            [
                "notification_config_id" => "13",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Trashed Blog Comment #BLOGTITLE#",
                "slug" => "w3-c-m-s:-trashed-blog-comment#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>Blog comment trashed by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTITLE#</h3>\r\n\r\n<p>#BLOGCOMMENT#</p>"
            ],
            [
                "notification_config_id" => "14",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Blog Comment #BLOGTITLE#",
                "slug" => "w3-c-m-s:-deleted-blog-comment#-b-l-o-g-t-i-t-l-e#",
                "content" => "<p>Blog comment deleted by: #USERNAME#</p>\r\n\r\n<h3>#BLOGTITLE#</h3>\r\n\r\n<p>#BLOGCOMMENT#</p>"
            ],
            [
                "notification_config_id" => "15",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Added New Page #PAGETITLE#",
                "slug" => "w3-c-m-s:-added-new-page#-p-a-g-e-t-i-t-l-e#",
                "content" => "<p>New page added by: #USERNAME#</p>\r\n\r\n<h3>#PAGETITLE#</h3>\r\n\r\n<p>#PAGECONTENT#</p>"
            ],
            [
                "notification_config_id" => "16",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Page #PAGETITLE#",
                "slug" => "w3-c-m-s:-updated-page#-p-a-g-e-t-i-t-l-e#",
                "content" => "<p>Page updated by: #USERNAME#</p>\r\n\r\n<h3>#PAGETITLE#</h3>"
            ],
            [
                "notification_config_id" => "17",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Trashed Page #PAGETITLE#",
                "slug" => "w3-c-m-s:-trashed-page#-p-a-g-e-t-i-t-l-e#",
                "content" => "<p>Page trashed by: #USERNAME#</p>\r\n\r\n<h3>#PAGETITLE#</h3>\r\n\r\n<p>#PAGECONTENT#</p>"
            ],
            [
                "notification_config_id" => "18",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Page #PAGETITLE#",
                "slug" => "w3-c-m-s:-deleted-page#-p-a-g-e-t-i-t-l-e#",
                "content" => "<p>Page deleted by: #USERNAME#</p>\r\n\r\n<h3>#PAGETITLE#</h3>\r\n\r\n<p>#PAGECONTENT#</p>"
            ],
            [
                "notification_config_id" => "19",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Created New Post Type #POSTTYPETITLE#",
                "slug" => "w3-c-m-s:-created-new-post-type#-p-o-s-t-t-y-p-e-t-i-t-l-e#",
                "content" => "<p>New post type created by: #USERNAME#</p>\r\n\r\n<h3>#POSTTYPETITLE#</h3>\r\n\r\n<p>#POSTTYPECONTENT#</p>"
            ],
            [
                "notification_config_id" => "20",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Post Type #POSTTYPETITLE#",
                "slug" => "w3-c-m-s:-updated-post-type#-p-o-s-t-t-y-p-e-t-i-t-l-e#",
                "content" => "<p>Post type updated by: #USERNAME#</p>\r\n\r\n<h3>#POSTTYPETITLE#</h3>\r\n\r\n<p>#POSTTYPECONTENT#</p>"
            ],
            [
                "notification_config_id" => "21",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Trashed Post Type #POSTTYPETITLE#",
                "slug" => "w3-c-m-s:-trashed-post-type#-p-o-s-t-t-y-p-e-t-i-t-l-e#",
                "content" => "<p>Post type trashed by: #USERNAME#</p>\r\n\r\n<h3>#POSTTYPETITLE#</h3>\r\n\r\n<p>#POSTTYPECONTENT#</p>"
            ],
            [
                "notification_config_id" => "22",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Post Type #POSTTYPETITLE#",
                "slug" => "w3-c-m-s:-deleted-post-type#-p-o-s-t-t-y-p-e-t-i-t-l-e#",
                "content" => "<p>Post type deleted by: #USERNAME#</p>\r\n\r\n<h3>#POSTTYPETITLE#</h3>\r\n\r\n<p>#POSTTYPECONTENT#</p>"
            ],
            [
                "notification_config_id" => "23",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Created New Taxonomy #TAXONOMYTITLE#",
                "slug" => "w3-c-m-s:-created-new-taxonomy#-t-a-x-o-n-o-m-y-t-i-t-l-e#",
                "content" => "<p>Taxonomy created by: #USERNAME#</p>\r\n\r\n<h3>#TAXONOMYTITLE#</h3>\r\n\r\n<p>#TAXONOMYCONTENT#</p>"
            ],
            [
                "notification_config_id" => "24",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Taxonomy #TAXONOMYTITLE#",
                "slug" => "w3-c-m-s:-updated-taxonomy#-t-a-x-o-n-o-m-y-t-i-t-l-e#",
                "content" => "<p>Taxonomy updated by: #USERNAME#</p>\r\n\r\n<h3>#TAXONOMYTITLE#</h3>\r\n\r\n<p>#TAXONOMYCONTENT#</p>"
            ],
            [
                "notification_config_id" => "25",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Trashed Taxonomy #TAXONOMYTITLE#",
                "slug" => "w3-c-m-s:-trashed-taxonomy#-t-a-x-o-n-o-m-y-t-i-t-l-e#",
                "content" => "<p>Taxonomy trashed by: #USERNAME#</p>\r\n\r\n<h3>#TAXONOMYTITLE#</h3>\r\n\r\n<p>#TAXONOMYCONTENT#</p>"
            ],
            [
                "notification_config_id" => "26",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Taxonomy #TAXONOMYTITLE#",
                "slug" => "w3-c-m-s:-deleted-taxonomy#-t-a-x-o-n-o-m-y-t-i-t-l-e#",
                "content" => "<p>Taxonomy deleted by: #USERNAME#</p>\r\n\r\n<h3>#TAXONOMYTITLE#</h3>\r\n\r\n<p>#TAXONOMYCONTENT#</p>"
            ],
            [
                "notification_config_id" => "27",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Added New User #FULLNAME#",
                "slug" => "w3-c-m-s:-added-new-user#-f-u-l-l-n-a-m-e#",
                "content" => "<p>New user created by: #USERNAME#</p>\r\n\r\n<p>#PROFILE#<br />\r\nName: #FULLNAME#<br />\r\nEmail: #EMAIL#<br />\r\nUser Role: #ROLE#</p>"
            ],
            [
                "notification_config_id" => "28",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated User #FULLNAME#",
                "slug" => "w3-c-m-s:-updated-user#-f-u-l-l-n-a-m-e#",
                "content" => "<p>User updated by: #USERNAME#</p>\r\n\r\n<p>#PROFILE#<br />\r\nName: #FULLNAME#<br />\r\nEmail: #EMAIL#</p>"
            ],
            [
                "notification_config_id" => "29",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted User",
                "slug" => "w3-c-m-s:-deleted-user",
                "content" => "<p>User deleted by: #USERNAME#</p>\r\n\r\n<p>#PROFILE#<br />\r\nName: #FULLNAME#<br />\r\nEmail: #EMAIL#<br />\r\nUser Role: #ROLE#</p>"
            ],
            [
                "notification_config_id" => "30",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated User Password",
                "slug" => "w3-c-m-s:-updated-user-password",
                "content" => "<p>User password Updated by: #USERNAME#</p>\r\n#PROFILE#<br />\r\nName: #FULLNAME#<br />\r\nEmail: #EMAIL#"
            ],
            [
                "notification_config_id" => "31",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Role Assigned To User #FULLNAME#",
                "slug" => "w3-c-m-s:-role-assigned-to-user#-f-u-l-l-n-a-m-e#",
                "content" => "<p>Role assigned by: #USERNAME#</p>\r\n\r\n<p>Name: #FULLNAME#<br />\r\nEmail: #EMAIL#<br />\r\nUser Role: #ROLE#</p>"
            ],
            [
                "notification_config_id" => "32",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Created New Role",
                "slug" => "w3-c-m-s:-created-new-role",
                "content" => "<p>Role created by: #USERNAME#</p>\r\n\r\n<p>Role Name: #NAME#</p>"
            ],
            [
                "notification_config_id" => "33",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Updated Role",
                "slug" => "w3-c-m-s:-updated-role",
                "content" => "<p>Role updated by: #USERNAME#</p>\r\n\r\n<p>Role Name: #NAME#</p>"
            ],
            [
                "notification_config_id" => "34",
                "notification_type_id" => "1",
                "subject" => "W3CMS: Deleted Role",
                "slug" => "w3-c-m-s:-deleted-role",
                "content" => "<p>Role deleted by: #USERNAME#</p>\r\n\r\n<p>Role Name: #NAME#</p>"
            ],
            [
                "notification_config_id" => "35",
                "notification_type_id" => "1",
                "subject" => "W3CMS: A Person Want to Contact",
                "slug" => "w3-c-m-s:-a-person-want-to-contact",
                "content" => "<h3>A Person Want to Contact you -</h3>\r\n\r\n<p>Name: #FIRSTNAME# #LASTNAME#</p>\r\n\r\n<p>Email : #EMAIL#</p>\r\n\r\n<p>Phone Number : #PHONENUMBER#</p>\r\n\r\n<p>Message : #MESSAGE#</p>"
            ]
        ];
        NotificationTemplate::insert($data);
    }
}
