<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::user()->id;

        $projects=Project::where("user_id",$id)->orderBy("user_id")->get();


        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("projects.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=$request->validate([
            "name"=>["required"],
//            "aws_access_key"=>["nullable"],
//            "aws_secret_key"=>["nullable"],
//            "aws_region"=>["nullable"],
//            "aws_bucket"=>["nullable"],
        ]);

       $create= Project::create([
           "name"=>$request->name,
//           "aws_access_key"=>$request->aws_access_key,
//            "aws_secret_key"=>$request->aws_secret_key,
//            "aws_region"=>$request->aws_region,
//            "aws_bucket"=>$request->aws_bucket,
           "user_id"=>auth()->id()
        ]);

        if (!$validator){
            return back()->with("error","Enter a Different Name");
        }
        else{
            return redirect(route("projects.index"))->with("success","Create Project Successful");
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // $projects=Project::find($id);
        return view("projects.view",compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projects=Project::where("id",$id)->first();
        return view("projects.edit",compact("projects"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator=$request->validate([
            "name"=>["required"],
//            "aws_access_key"=>["nullable"],
//            "aws_secret_key"=>["nullable"],
//            "aws_region"=>["nullable"],
//            "aws_bucket"=>["nullable"],
        ]);

        $updated = Project::where("id",$id)->update([

            "name"=>$request->name,
//            "aws_access_key"=>$request->aws_access_key,
//            "aws_secret_key"=>$request->aws_secret_key,
//            "aws_region"=>$request->aws_region,
//            "aws_bucket"=>$request->aws_bucket,
        ]);


            return redirect(route("projects.index"))->with("success","Edit Project Successful");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $deleted=Project::where("id",$id)->delete();
        return redirect(route("projects.index"));
    }

/*
    public function token(Request $request)
    {
        $project = Project::where('api_key', $request->header('Api-Key'))
            ->where('api_secret', $request->header('Api-Secret'))->firstOrFail();

//        $success['token'] = $project->createToken('token')->accessToken;
  //      $success['project_name'] = $project->name;
    //    $success['project_id'] = $project->id;

        //$request->merge(['project_id' => $project->id]);


        return response()->json($success, 200);
    }
*/
}
