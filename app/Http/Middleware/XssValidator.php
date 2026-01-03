<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $input = $request->all();
        
        array_walk_recursive($input, function(&$input) {
            if(!empty($input))
            {
                $input = strip_tags(str_replace(array("&lt;", "&gt;"), '', $input), '<span><p><a><b><i><u><strong><br><hr><table><tr><th><td><thead><tbody><tfoot><ul><ol><li><h1><h2><h3><h4><h5><h6><del><ins><sup><sub><pre><address><img><figure><embed><iframe><video><style><div><section><input><select><option><textarea><button><header><footer><form><label><nav><small><aside><blockquote><map><svg><rect><circle><ellipse><line><polyline><polygon><path><text><g><defs><filter><feGaussianBlur><feOffset><feBlend><stop><linearGradient><radialGradient><feColorMatrix><feComponentTransfer><feComposite><feConvolveMatrix><feDiffuseLighting><feDisplacementMap><feFlood><feImage><feMerge><feMorphology><feSpecularLighting><feTile><feTurbulence><feDistantLight><fePointLight><feSpotLight><%ME%><%ME-EL%><iframe>');

                $input = str_replace(array("%ME-EL%", "%ME%"), array("&lt;%ME-EL%&gt;", "&lt;%ME%&gt;"), $input);
            }
        });
        
        $request->merge($input);
        
        return $next($request);
    }
}
