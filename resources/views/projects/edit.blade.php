@extends("layouts.bootstrap")

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Edit Project") }}
        </h2>
    </x-slot>

    <div class="py-20">

        <div class="container">

            <form action="{{route("projects.update",$projects->id)}}" method="post"  class="form-horizontal">
                {{ csrf_field() }}
                @method("PUT")
                <div class="form-group" align="center">
                    <div class="col-xs-6 col-xs-offset-3 col-md-3">
                        Edit Project Name
                        <hr>
                        @if($errors->has("name"))
                        <div id="validationServer03Feedback" class="alert alert-danger">
                            {{$errors->first("name")}}
                        </div>
                        @endif

                        <input type="text" class="form-control" name="name">
                        <hr>
                            <button class="btn btn-info" >Edit</button>
                    </div>
                </div>

            </form>

        </div>



</x-app-layout>