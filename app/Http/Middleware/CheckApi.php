<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;

class CheckApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!$request->header("api-key")||!$request->header("api-secret")){
            abort(404,"Api and Secret key needed");
        }
        $project=Project::where("api_key",$request->header("api-key"))->where("api_secret",$request->header("api-secret"))->firstOrFail();

        $request->merge(["id"=>$project->id]);


        return $next($request);
    }
}
