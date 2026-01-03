<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Helper\DzHelper;
use App\Helper\HelpDesk;
use Illuminate\Http\Request;
use App\Models\Blog;
use Modules\W3CPT\Entities\Blog as CptBlog;
use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\User;
use App\Models\BlogTag;
use App\Models\Configuration;
use App\Models\Contact;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Notification;
use Hexadog\ThemesManager\Facades\ThemesManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Cookie;
use Str;
use DB;
use Mail;
use Storage;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public $page_general_sorting_on;
    public $page_general_sorting;

    public function __construct()
    {
        $this->page_general_sorting = config('ThemeOptions.page_general_sorting','created_at__desc');
        $this->page_general_sorting_on = config('ThemeOptions.page_general_sorting_on',1);
    }

    public function index(Request $request)
    {
        if(config('Reading.show_on_front') == 'Page')
        {
            $homepage = Page::wherePublishPage()->where('slug', 'like', config('Reading.home_page'))->first();

            if (!empty($homepage)) {
                $request->slug = config('Reading.home_page');
                
                return $this->page($request);
            }
        }
        
        return $this->blogslist();
    }

    
    public function detail(Request $request)
    {
        $blogView = $this->blog($request);
        if($blogView){
            return $blogView;
        }
        return $this->page($request);
        
    }

    /* 
    CPT Details Function 
    Function : cpt_detail(request) : permalinks
    Theme File : single.blade.php
    */
    public function cpt_detail($request){
        
    }

    /* 
    Blog Details Function 
    Function : blog(request) : permalinks
    Theme File : single.blade.php
    */
    public function blog($request){
        $seoMeta = array('title', 'meta_keywords', 'meta_descriptions', 'image' => '');
        $single = false;
        $post_type = $request->post_type ?? 'blog';
        $blog   = Blog::select('id', 'title', 'content', 'user_id', 'post_type', 'excerpt', 'comment', 'password','visibility', 'publish_on');
        if ($post_type !== 'blog') {
            $blog   = CptBlog::select('id', 'title', 'content', 'user_id', 'post_type', 'excerpt', 'comment', 'password','visibility', 'publish_on');
        }
        if($request->route('year'))
        {
            $blog->whereYear('publish_on', '=', $request->year);
            $single = true;
        }
        if($request->route('month'))
        {
            $blog->whereMonth('publish_on', '=', $request->month);
            $single = true;
        }
        if($request->route('day'))
        {
            $blog->whereDay('publish_on', '=', $request->day);
            $single = true;
        }
        if($request->slug)
        {
            $blog->where('slug', '=', $request->slug);
            $single = true;
        }
        if($request->p)
        {
            $blog->where('id', '=', $request->p);
            $single = true;
        }
        if($request->post_id)
        {
            $blog->where('id', '=', $request->post_id);
            $single = true;
        }
        if($request->post_type)
        {
            $single = true;
        }

        $blog = $blog->WherePublishBlog($post_type)->CheckBlogVisibility()->with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->first();
        $blog_categories = !empty($blog->blog_categories) ? $blog->blog_categories : array();

        /* For Password Protected Blogs */
        $status = 'unlock_'.optional($blog)->id;
        $StatusCookie = Cookie::get('StatusCookie');

        if (optional($blog)->visibility == 'PP' && $StatusCookie != $status) {
            $status = 'locked';

            if (isset($request->password) && !empty($request->password)) {
                if ($request->password == $blog->password) {
                    $status = 'unlock_'.$blog->id;
                    Cookie::queue('StatusCookie', $status, 60);
                }else {
                    return redirect()->back()->withErrors(['password' => __('The Password is incorrect.')]);;

                }
            }
        }
        /* For Password Protected Blogs */


        if(!empty($blog) && empty($request->page_id))
        {       
            $pageTitle = __('common.blogs');
            $blogs   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->WherePublishBlog()->CheckBlogVisibility()->latest();

            /* For Single Blog Detail Start*/
            if($single)
            {
                $pageTitle = optional($blog->blog_seo)->page_title ?? $blog->title;
                $blogCateIds = $blog_categories->pluck('id')->toArray();
                $blogTagsIds = $blog->blog_tags->pluck('id')->toArray();

                if (config('ThemeOptions.single_related_post_type') == 'tag') {
                    $related_blogs = $blogs->where('blogs.id', '!=', $blog->id)
                                        ->whereHas('blog_tags', function($q)use($blogTagsIds){
                                            $q->whereIn('blog_tags.id', $blogTagsIds);
                                        })->limit(2)->get();
                }
                else{
                    $related_blogs = $blogs->where('blogs.id', '!=', $blog->id)
                                        ->whereHas('blog_categories', function($q)use($blogCateIds){
                                            $q->whereIn('blog_categories.id', $blogCateIds);
                                        })->limit(2)->get();
                }

                $nextBlog = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->WherePublishBlog()->CheckBlogVisibility()->where('id', '>', $blog->id)
                    ->orderBy('id', 'asc')
                    ->first();

                $previousBlog = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->WherePublishBlog()->CheckBlogVisibility()->where('id', '<', $blog->id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                
                $blogMeta = $blog->blog_meta->pluck('value', 'title');
                $blogSeo = $blog->blog_seo;

                if(!empty($blogSeo))
                {
                    $seoMeta['title'] = $blogSeo->page_title ?? $blog->title;
                    $seoMeta['author'] = optional($blog->user)->name;
                    $seoMeta['meta_keywords'] = $blogSeo->meta_keywords;
                    $seoMeta['meta_descriptions'] = $blogSeo->meta_descriptions ? $blogSeo->meta_descriptions : $blog->excerpt;
                    if(optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.optional($blog->feature_img)->value))
                    {
                        $seoMeta['image'] = asset('storage/blog-images/'.optional($blog->feature_img)->value);
                    }
                }

                $total_comments = $blog->blog_comments->count();
                $comments = config('Discussion.page_comments') ? $blog->comments()->paginate(config('Discussion.comments_per_page')) : $blog->comments()->get();

                
                /* For Increase Blog Views in meta, Key = blog_view */
                $blog_view = $blogMeta['blog_view'] ?? 0;
                $blog_view += 1;
                $blog->blog_meta()->updateOrCreate(
                    ['title' => 'blog_view'], 
                    ['value' => $blog_view] 
                );

                if (View::exists('single-'.$post_type)) {
                    return view('single-'.$post_type, compact('blog', 'nextBlog', 'previousBlog','blog_categories','status', 'blogMeta', 'seoMeta', 'comments', 'total_comments', 'pageTitle', 'related_blogs'));
                }
                
                return view('single', compact('blog', 'nextBlog', 'previousBlog','blog_categories','status', 'blogMeta', 'seoMeta', 'comments', 'total_comments', 'pageTitle', 'related_blogs'));
            }
            /* For Single Blog Detail End*/

            return $this->index($request);
        }
    }
    
    
    /* 
    Page Details Function 
    Function : page(request) : permalinks
    Theme File : page.blade.php
    */
    public function page($request){

        $seoMeta = array('title', 'meta_keywords', 'meta_descriptions', 'image' => '');

        /* For Single Page Detail Start*/
        $where = array();

        if($request->page_id)
        {
            $where[] = array('id', '=', $request->page_id);
        }
        if($request->slug)
        {
            $where[] = array('slug', '=', $request->slug);
        }
        if (empty($where)) {
            abort(404);
        }
        $page = Page::with('page_metas', 'page_seo', 'user')->with(['child_pages' => function($query) {
            $query->where('visibility', '!=', 'Pr');
        }])->where($where)->wherePublishPage()->firstOrFail();

        
        /* For Private Page - if current user not has admin role then show 404 for private page */
        if(!optional(Auth::user())->hasRole(config('constants.roles.admin')) && optional($page)->visibility == 'Pr'){
            abort(404);
        }
        /* For Private Page */

        /* For Password Protected Page */
        $status = 'unlock_'.optional($page)->id;
        $StatusCookie = Cookie::get('StatusCookie');

        if (optional($page)->visibility == 'PP' && $StatusCookie != $status) {
            $status = 'locked';

            if (isset($request->password) && !empty($request->password)) {
                if ($request->password == $page->password) {
                    $status = 'unlock_'.$page->id;
                    Cookie::queue('StatusCookie', $status, 60);
                }else {
                    return redirect()->back()->withErrors(['password' => __('The Password is incorrect.')]);;

                }
            }
        }
        /* For Password Protected Page */

        $blog = null;
        $pageTitle = $page->title;
        $pageMeta = $page->page_metas->pluck('value', 'title');
        $pageSeo = $page->page_seo;
        if(!empty($pageSeo))
        {
            $seoMeta['title'] = $pageSeo->page_title ?? $page->title;
            $seoMeta['author'] = optional($page->user)->name;
            $seoMeta['meta_keywords'] = $pageSeo->meta_keywords;
            $seoMeta['meta_descriptions'] = $pageSeo->meta_descriptions ? $pageSeo->meta_descriptions : optional($page)->excerpt;
            if(optional($page->feature_img)->value && Storage::exists('public/page-images/'.optional($page->feature_img)->value))
            {
                $seoMeta['image'] = asset('storage/page-images/'.optional($page->feature_img)->value);
            }
        }

        $total_comments = $page->page_comments->count();
        $comments = config('Discussion.page_comments') ? $page->comments()->paginate(config('Discussion.comments_per_page')) : $page->comments()->get();
        
        return view('page', compact('page','blog','status', 'comments', 'seoMeta', 'pageSeo', 'pageMeta','total_comments','pageTitle'));
            
        /* For Single Page Detail End*/
    }
    
    /* 
    Category Page Function 
    Function : category(request) : permalinks
    Theme File : category.blade.php
    * Created By : DexignZone.
    * blogcategory() function use for return view of category.blade.php based on slug,
    * this function return single category view with blogs of the category.
    */
    public function category(Request $request)
    {
        $blog_category = BlogCategory::where('slug', '=', $request->slug)->firstOrFail();
        $blogObj = $blog_category->blog()->WherePublishBlog()->CheckBlogVisibility();

        if (config('ThemeOptions.category_page_sorting_on',$this->page_general_sorting_on) && config('ThemeOptions.category_page_sorting',$this->page_general_sorting)) {
            $order = explode('__', config('ThemeOptions.category_page_sorting',$this->page_general_sorting));
            $blogObj->orderBy($order[0],$order[1]);
        }else{
            $blogObj->latest();
        }

        $pageTitle = $blog_category->title;
        $blogs = $blogObj->paginate(config('Reading.nodes_per_page'));

        return view('category',compact('blogs','pageTitle'));
    }
    
    
    /* 
    Tag Page Function 
    Function : Tag(request) : permalinks
    Theme File : tag.blade.php
    * Created By : DexignZone.
    * blogtag() function use for return view of Blog tags based on title,
    * this function return single tag view with blogs of the tag.
    */
    public function tag(Request $request)
    {
        $blog_tag = BlogTag::where('slug', '=', $request->slug)->firstOrFail();
        $blogObj = $blog_tag->blog()->WherePublishBlog()->CheckBlogVisibility();

        if (config('ThemeOptions.tag_page_sorting_on',$this->page_general_sorting_on) && config('ThemeOptions.tag_page_sorting',$this->page_general_sorting)) {
            $order = explode('__', config('ThemeOptions.tag_page_sorting',$this->page_general_sorting));
            $blogObj->orderBy($order[0],$order[1]);
        }else{
            $blogObj->latest();
        }

        $pageTitle = $blog_tag->title;

        $blogs = $blogObj->paginate(config('Reading.nodes_per_page'));
        return view('tag',compact('blogs','pageTitle'));
    }


    /*
    * Created By : DexignZone.
    * author() function use for return view of archive.blade.php,
    * this function return single author page with blogs of the user.
    */
    public function author(Request $request)
    {
        $user = User::where('name', '=', $request->name)->firstOrFail();
        $blogObj = $user->blog()->WherePublishBlog()->CheckBlogVisibility();
        $pageTitle = $user->name;

        if (config('ThemeOptions.author_page_sorting_on',$this->page_general_sorting_on) && config('ThemeOptions.author_page_sorting',$this->page_general_sorting)) {
            $order = explode('__', config('ThemeOptions.author_page_sorting',$this->page_general_sorting));
            $blogObj->orderBy($order[0],$order[1]);
        }else{
            $blogObj->latest();
        }

        $blogs = $blogObj->paginate(config('Reading.nodes_per_page'));
        return view('author',compact('pageTitle','blogs'));
    }


    /*
    * Created By : DexignZone.
    * blogarchive() function use for return view of archive.blade.php,
    * this function return single archive page with blogs by month and year,
    * $month is the name of month that return in the view.
    */
    public function archive(Request $request)
    {
        $year = $request->year;
        $month = $request->month ? date("F", mktime(0, 0, 0, $request->month, 10)) : '';

        $blogObj = $this->archiveQuery($request);
        $blogs = $blogObj->paginate(config('Reading.nodes_per_page'));

        $pageTitle = $year.' '.$month;

        return view('archive',compact('blogs','pageTitle'));
    }


    private function archiveQuery($request){

        $blogObj = Blog::with('blog_meta');
        $blogObj->WherePublishBlog()->CheckBlogVisibility();
        
        $blogObj->whereYear('publish_on', '=', $request->year);
        if($request->month){
            $blogObj->whereMonth('publish_on', '=', $request->month);
        }

        if (config('ThemeOptions.archive_page_sorting_on',$this->page_general_sorting_on) && config('ThemeOptions.archive_page_sorting',$this->page_general_sorting)) {
            $order = explode('__', config('ThemeOptions.archive_page_sorting',$this->page_general_sorting));
            $blogObj->orderBy($order[0],$order[1]);
        }else{
            $blogObj->latest();
        }
        return $blogObj;
    }

    /*
    * Created By : DexignZone.
    * search() function use for return view of search,
    * this function return single search page with blogs and pages that match by search data,
    */
    public function search(Request $request)
    {
        $pageTitle = $request->s;
        $title = $request->s;
        
        $blogObj = $this->searchBlogQuery($request);
        $blogs = $blogObj->paginate(config('Reading.nodes_per_page'));
        
        $pageObj = $this->searchPageQuery($request);
        $pages = $pageObj->paginate(config('Reading.nodes_per_page'));
        
        $cptBlogObj = $this->searchCptQuery($request);
        $cpt_blogs = $cptBlogObj->paginate(config('Reading.nodes_per_page'));

        return view('search',compact('blogs','pages','cpt_blogs','title','pageTitle'));
    }

    private function searchCptQuery($request){
        
        $title = $request->s;
        $cptBlogObj = Blog::with('blog_meta')->CheckBlogVisibility();

        $cptBlogObj->where('status', 1)->where('post_type', '!=', 'blog');
        $cptBlogObj->where(function($query) use($title) {
            $query->orwhere('title', 'Like', '%'.$title.'%')
                ->orWhere('content', 'Like', '%'.$title.'%')
                ->orWhere('excerpt', 'Like', '%'.$title.'%')
                ->orWhere('slug', 'Like', '%'.$title.'%')
                ->orWhere('comment', 'Like', '%'.$title.'%')
                ->orWhere('publish_on', 'Like', '%'.$title.'%');
        });
        return $cptBlogObj;
    }

    private function searchPageQuery($request){
        
        $title = $request->s;
        $pageObj = Page::with('page_metas');
        if(!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $pageObj->where('visibility', '!=', 'Pr');
        }
        $pageObj->where(['status' => 1]);
        $pageObj->where(function($query) use($title) {
            $query->orwhere('title', 'Like', '%'.$title.'%')
                ->orWhere('content', 'Like', '%'.$title.'%')
                ->orWhere('excerpt', 'Like', '%'.$title.'%')
                ->orWhere('slug', 'Like', '%'.$title.'%')
                ->orWhere('comment', 'Like', '%'.$title.'%')
                ->orWhere('publish_on', 'Like', '%'.$title.'%');
        });
        
        return $pageObj;
    }

    private function searchBlogQuery($request){
        
        $title = $request->s;
        $blogObj = Blog::with('blog_meta')->WherePublishBlog()->CheckBlogVisibility();

        $blogObj->where(function($query) use($title) {
            $query->orwhere('title', 'Like', '%'.$title.'%')
                ->orWhere('content', 'Like', '%'.$title.'%')
                ->orWhere('excerpt', 'Like', '%'.$title.'%')
                ->orWhere('slug', 'Like', '%'.$title.'%')
                ->orWhere('comment', 'Like', '%'.$title.'%')
                ->orWhere('publish_on', 'Like', '%'.$title.'%');
        });

        return $blogObj;
    }

    /*
    * Created By : DexignZone.
    * Theme File : index.blade.php
    * blogslist() function use for return view of blog list,
    * this function return list of blogs when route get 'blog' in url ,
    */
    public function blogslist()
    {
        $pageTitle = config('ThemeOptions.blog_page_title', __('common.blogs'));

        $blogObj   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->WherePublishBlog()->CheckBlogVisibility();

        if ($this->page_general_sorting_on && $this->page_general_sorting) {
            $order = explode('__', $this->page_general_sorting);
            $blogObj->orderBy($order[0],$order[1]);
        }else{
            $blogObj->latest();
        }
        $blogs   = $blogObj->paginate(config('Reading.nodes_per_page'));

        return view('index', compact('blogs','pageTitle'));
    }

    /*
    * Created By : DexignZone.
    * contact() function use for return view of contact us page and save contact details in database,
    * this function return Contact Page when route get 'Page' in url ,
    */
    public function contact(Request $request)
    {
        $pageTitle = __('common.contacts');

        $this->validate($request, [
                'first_name'        => 'required',
                'last_name'         => 'nullable',
                'email'             => 'required|email',
                'phone_number'      => 'required|regex:/^[0-9]{10}+$/',
                'message'           => 'required',
            ],
        );

        $data = [
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'email'         => $request->input('email'),
            'phone_number'  => $request->input('phone_number'),
            'message'       => $request->input('message'),
        ];
        $dzEmail = $data['email'];
        $dzEmailFrom = $data['first_name'].' '.$data['last_name'];
        $contact = Contact::create($data);

        if($contact)
        {

            $notificationObj        = new Notification();
            $notificationObj->notification_entry('Admin-CFI', $contact->id, Auth::id(), config('constants.superadmin'));

            if (!env('MAIL_USERNAME') && !env('MAIL_PASSWORD') && !env('MAIL_HOST')) {
                return redirect()->back()->with('success', __('Contact Added Successfully. But Email SMTP credentials are missing in the .env file.'));
            }

            return redirect()->back()->with('success', __('common.contact_add_success'));
        }

        return redirect()->back()->with('error', __('common.problem_in_form_submition'));
        
    }

    public function themelanguage(Request $request){
         $language = $request->input('language');
         $request->session()->put('language', $language);
         return redirect()->back();

    }

    public function ajax_get_data(Request $request){
        
        if ($request->ajax() && config('Theme.select_theme')) {
            ThemesManager::set(config('Theme.select_theme'));

            $limit = isset($request->no_of_posts) ? $request->no_of_posts : config('Reading.nodes_per_page');
            $el_view = $request->ajax_view;
            $post_type = $request->post_type ?? 'blog';
            
            if ($request->view_name == 'index') {
                
                $blogObj   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->WherePublishBlog($post_type)->CheckBlogVisibility();

                if ($this->page_general_sorting_on && $this->page_general_sorting) {
                    $order = explode('__', $this->page_general_sorting);
                    if ($request->order && $request->orderby) {
                        $blogObj->orderBy($request->orderby, $request->order);
                    }else{
                        $blogObj->orderBy($order[0],$order[1]);
                    }
                }else{
                    $blogObj->latest();
                }
            }
            elseif($request->view_name == 'tag'){
                $blog_tag = BlogTag::where('slug', '=', $request->slug)->firstOrFail();
                $blogObj = $blog_tag->blog()->WherePublishBlog()->CheckBlogVisibility();
                
                if (config('ThemeOptions.tag_page_sorting_on') && config('ThemeOptions.tag_page_sorting')) {
                    $order = explode('__', config('ThemeOptions.tag_page_sorting'));
                    $blogObj->orderBy($order[0],$order[1]);
                }else{
                    $blogObj->latest();
                }

            }
            elseif($request->view_name == 'category'){
                $blog_category = BlogCategory::where('slug', '=', $request->slug)->firstOrFail();
                $blogObj = $blog_category->blog()->WherePublishBlog()->CheckBlogVisibility();

                if (config('ThemeOptions.category_page_sorting_on') && config('ThemeOptions.category_page_sorting')) {
                    $order = explode('__', config('ThemeOptions.category_page_sorting'));
                    $blogObj->orderBy($order[0],$order[1]);
                }else{
                    $blogObj->latest();
                }

            }
            elseif($request->view_name == 'archive'){
                $blogObj = $this->archiveQuery($request);
            }
            elseif($request->view_name == 'author'){
                $user = User::where('name', '=', $request->name)->first();
                $blogObj = $user->blog()->WherePublishBlog()->CheckBlogVisibility();

                if (config('ThemeOptions.author_page_sorting_on') && config('ThemeOptions.author_page_sorting')) {
                    $order = explode('__', config('ThemeOptions.author_page_sorting'));
                    $blogObj->orderBy($order[0],$order[1]);
                }else{
                    $blogObj->latest();
                }

            }
            elseif($request->view_name == 'search'){
                if ($request->search_type == 'page') {
                    $blogObj = $this->searchPageQuery($request);
                }
                elseif($request->search_type == 'blog'){
                    $blogObj = $this->searchBlogQuery($request);
                }
                elseif($request->search_type == 'cpt'){
                    $blogObj = $this->searchCptQuery($request);
                }

            }
            
            $blogs = $blogObj->paginate($limit);
            
            $html = view('elements.ajax.'.$el_view, compact('blogs'))->render();
            $hasMorePages = $blogs->currentPage() < $blogs->lastPage();

            return response()->json([
                'html' => $html,
                'has_more_pages' => $hasMorePages,
            ]);
        }
    }

    public function comment_store(Request $request)
    {

        $validationRule = [
                    'comment'            => 'required',
                ];

        if(!Auth::check() && config('Discussion.name_email_require'))
        {
            $validationRule['commenter']    = 'required';
            $validationRule['email']        = 'required|email';
        }

        $this->validate($request, $validationRule,
                [],
                [
                   'commenter' => 'Name',
                ],
            );

        $modKeys = trim(config('Discussion.moderation_keys'));
        $disallowedKeys = trim(config('Discussion.disallowed_comment_keys'));
        $status = "1";

        if (!empty($modKeys)) {
            $modKeys = explode(",", $modKeys );
            foreach ($modKeys as $key) {

                if ( empty( trim($key) ) ) {
                    continue;
                }

                foreach($request->all() as $inputValue)
                {
                    if(Str::is($key.'*', $inputValue))
                    {
                        $status = "0";
                        break;
                    }
                }
            }
        }

        if (!empty($disallowedKeys)) {
            $disallowedKeys = explode(",", $disallowedKeys );
            foreach ($disallowedKeys as $key) {

                if ( empty( trim($key) ) ) {
                    continue;
                }

                foreach($request->all() as $inputValue)
                {
                    if(Str::is($key.'*', $inputValue))
                    {
                        $status = "3";
                        break;
                    }
                }
            }
        }

        $parentComment = Comment::where('parent_id', $request->input('parent_id'))->first();

        setcookie('comment_author_'.config('constants.comment_cookie_hash'), '', time() + (86400), '/');
        setcookie('comment_email_'.config('constants.comment_cookie_hash'), '', time() + (86400), '/');
        setcookie('comment_website_'.config('constants.comment_cookie_hash'), '', time() + (86400), '/');

        if(config('Discussion.save_comments_cookie') && $request->input('set_comment_cookie'))
        {
            setcookie('comment_author_'.config('constants.comment_cookie_hash'), $request->input('commenter'), time() + (86400), '/');
            setcookie('comment_email_'.config('constants.comment_cookie_hash'), $request->input('email'), time() + (86400), '/');
            setcookie('comment_website_'.config('constants.comment_cookie_hash'), $request->input('profile_url'), time() + (86400), '/');
        }

        if(!empty($parentComment) && $parentComment->approve != '1' && config('Discussion.comment_previously_approved'))
        {
            return redirect()->back()->with('unapprove_comment_error', __('Sorry, You can replay after approved previously comment.'));
        }

        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());
        }

        $comment = Comment::create([
            'parent_id'         => $request->input('parent_id'),
            'object_id'         => $request->input('object_id'),
            'object_type'       => $request->input('object_type'),
            'user_id'           => isset($user->id) ? $user->id : null,
            'commenter'         => isset($user->name) ? $user->name : $request->input('commenter'),
            'profile_url'       => isset($user->id) ? DzHelper::author($user->id) : $request->input('profile_url'),
            'ip'                => \Request::ip(),
            'email'             => isset($user->email) ? $user->email : $request->input('email'),
            'comment'           => $request->input('comment'),
            'approve'           => config('Discussion.comment_moderation') ? '0' : $status,
            'browser_agent'     => $request->userAgent(),
        ]);

        if($comment)
        {
            if(config('Discussion.comments_notify'))
            {
                /* Send Event Notification */
                $notificationObj        = new Notification();
                $notificationObj->notification_entry('BLOG-NBC', $comment->id, Auth::id(), config('constants.superadmin'));
                /* End Send Event Notification */
            }

            return redirect()->back()->with('comment_success', __('common.comment_added_success'));
        }else{
            return redirect()->back()->with('comment_error', __('common.problem_in_form_submition'));
        }
    }

}
