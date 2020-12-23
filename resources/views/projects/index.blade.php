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

                            <button type="button" class="btn btn-outline-primary pull-right"><a href="{{route
                            ("projects.create")}}">Create a
                                    Project</a></button>
                            <thead>
                            <tr >
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>

                            @foreach($projects as $project)
                            <tbody>
                            <tr>
                                <td>{{$project->name}}</td>
                                <td>{{$project->created_at}}</td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0 pull-right">
                                        <li class="list-inline-item">
                                            <button class="btn btn-primary " type="button" >View</button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-success " type="button">Edit</button>
                                        </li>
                                        <li class="list-inline-item" >
                                            <button class="btn btn-danger " type="button">Delete</button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                            @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pull-right{
            float: right;
        }
    </style>
</x-app-layout>
