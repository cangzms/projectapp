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
        if (!$request->header("Accept")){
            return response()->json(["message"=>"Accept must be application/json"],404);
        }
        if (!$request->header("ApiKey")||!$request->header("ApiSecret")){
            return response()->json(["message"=>"Faulty or Incomplete Key Entry "],400);
        }
        $project=Project::where("api_key",$request->header("ApiKey"))->where("api_secret",$request->header("ApiSecret"))->first();

        if (!$project){
            return response()->json(["message"=>"Api and Secret key error"],404);
        }
        $request->merge(["id"=>$project->id]);


        return $next($request);
    }
}
