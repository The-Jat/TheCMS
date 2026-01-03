<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helper\DzHelper;


use App\Models\Blog;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{

    /*
    *  Display dashboard for admin panel
    */
    public function dashboard()
    {
        $page_title = __('common.dashboard');
        $blogscount = Blog::WherePublishBlog(config('blog.post_type'))->count();
        $pagescount = Page::get()->count();
        $rolescount = Role::get()->count();
        $userscount = User::get()->count();
        $blog_categories = BlogCategory::select('id','title')->withCount('blog')->inRandomOrder()->limit(4)->get();
        $catagory_labels = $blog_categories->pluck('title');
        $catagory_counts = $blog_categories->pluck('blog_count');

        if ($catagory_counts->isNotEmpty()) {
            $multiplyby = 10;
            foreach ($catagory_counts as $key => $value) {
                if ($value > 10) {
                    $multiplyby = 1;
                    break;
                }
            }
            for ($i=0; $i < 4; $i++) {
                if(isset($catagory_counts[$i])){
                    $catagory_counts[$i] = $catagory_counts[$i] * $multiplyby;
                }
            }
        }

        $users = User::selectRaw('CONCAT_WS("-", DATE_FORMAT(created_at, "%b"),YEAR(created_at)) monthyear, DATE_FORMAT(created_at, "%m") month,YEAR(created_at) year, count(*) data')->groupBy('monthyear','month','year')->orderBy('year')->orderBy('month')->get();

        $users_monthyear = $users->pluck('monthyear');
        $users_count = $users->pluck('data');
        $max_user_count = max($users_count->toArray());
        $max_user_count = ($max_user_count <= 1) ? $max_user_count + 3 : $max_user_count + 1 ;

        return view('admin.dashboard',compact('blogscount','pagescount','rolescount','userscount','blog_categories','catagory_counts','catagory_labels','users_monthyear','users_count','max_user_count','page_title'));
    }

    private function check_ip_list() {

        $info                       = DzHelper::getIpInfo();
        $clientAgent                = DzHelper::osBrowser();

        $ip_record['user_ip'] = $_SERVER["REMOTE_ADDR"];
        $ip_record['user_id'] = Auth::id();
        $ip_record['browser'] = $clientAgent['browser'];
        $ip_record['os'] = $clientAgent['os_platform'];
        if($info)
        {
            $ip_record['longitude'] = implode(',', $info['long']);
            $ip_record['latitude'] = implode(',', $info['lat']);
            $ip_record['location'] = implode(',', $info['city']) . (" - " . implode(',', $info['area']) . "- ") . implode(',', $info['country']) . (" - " . implode(',', $info['code']) . " ");
            $ip_record['country_code'] = implode(',', $info['code']);
            $ip_record['country'] = implode(',', $info['country']);
        }

        $url = config('constants.client_information_api');

        $response = Http::withHeaders([
            'User-Agent'    => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
        ])->get($url, ['client_info' => $ip_record]);

    }
}
