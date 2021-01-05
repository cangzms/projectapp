<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id=Auth::user()->id;

        $projects=Project::where("user_id",$id)->orderBy("user_id")->get();


        return view('projects.index', compact('projects'));
    }

}
