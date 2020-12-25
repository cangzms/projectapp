@extends("layouts.bootstrap")

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Create Project") }}
        </h2>
    </x-slot>

    <div class="py-20">

        <div class="container">

            <form action="{{route("projects.store")}}" method="post"  class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group" align="center">
                    <div class="col-xs-6 col-xs-offset-3 col-md-3">
                       Project Name

                        <hr>
                        @if($errors->has("name"))
                        <div id="validationServer03Feedback" class="alert alert-danger">
                            {{$errors->first("name")}}
                        </div>
                        @endif
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="name">
                        <hr>
                        <button class="btn btn-primary" >Create</button>
                    </div>
                </div>

            </form>

    </div>



</x-app-layout>