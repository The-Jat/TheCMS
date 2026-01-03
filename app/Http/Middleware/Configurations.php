<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Configuration;
use App\Models\Blog;
use App\Models\BlogMeta;
use Illuminate\Support\Facades\DB;

class Configurations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (
            optional(request()->route())->getName() && 
            in_array(request()->route()->getName(), ['cpt.blog.admin.index','cpt.blog.admin.create']) && 
            request()->post_type == 'widgets'
        ){
            if (request()->route()->getName() == 'cpt.blog.admin.index') {
                return redirect()->route('admin.widgets.index');
            }
            else{
                return redirect()->route('admin.widgets.create');
            }
        }
        
        try {
            DB::connection()->getPdo();
            if(DB::connection()->getDatabaseName()){
                if(\Schema::hasTable('configurations')) 
                {
                    $configuration = new Configuration();
                    $configuration->init();
                    $prefix = request()->route()->getPrefix();
                    $prefix = \Str::contains($prefix, 'admin');

                    $website_status = config('ThemeOptions.website_status','live_mode');
                    
                    if(!$prefix && $website_status == 'comingsoon_mode')
                    {
                        return response()->view('errors.coming_soon');
                    }
                    else if(!$prefix && $website_status == 'maintenance_mode')
                    {
                        return response()->view('errors.503');
                    }
                }
                if(\Schema::hasTable('blogs')) {

                    $default_cpts = config('constants.default_cpts');
                    
                    if ($default_cpts) {
                        foreach ($default_cpts as $cpt) {
                            if (!Blog::where('slug', '=',$cpt['blog']['slug'])->exists()) {
                                
                                $cpt['blog']['user_id'] = \Auth::id();
                                $cpt['blog']['publish_on'] = date('Y-m-d H:i:s');
                                
                                $blog = Blog::create($cpt['blog']);
                                $blogMetas = array();

                                foreach ($cpt['cpt'] as $key => $value) {
                                    $blogMetas[] = array('blog_id' => $blog->id, 'title' => $key, 'value' => $value);
                                }
                                BlogMeta::insert($blogMetas);
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
        }
        
        return $next($request);
    }
}
