@extends("layouts.bootstrap")
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Responsive table -->
                    <div class="table-responsive">
                        <table class="table  ">

                            <b>Project Name</b> = {{$project->name}}
                            <hr>

                            <b>Api Key</b> = {{$project->api_key}}
                            <hr>

                            <b>Api Secret</b> = {{$project->api_secret}}
                            <hr>

                            <b>AWS Access</b> = {{$project->aws_access_key}}
                            <hr>

                            <b>AWS Secret</b> = {{$project->aws_secret_key}}
                            <hr>

                            <b>AWS Region</b> = {{$project->aws_region}}
                            <hr>

                            <b>AWS Bucket</b> = {{$project->aws_bucket}}
                            <hr>
                                 <a href="{{route("projects.index")}}"><button class="btn btn-warning">Back</button></a>




                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
