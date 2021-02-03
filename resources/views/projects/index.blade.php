@extends("layouts.bootstrap")
<x-app-layout>

    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->get('danger'))
        <div class="alert alert-danger">
            {{ session()->get('danger') }}
        </div>
    @endif


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

                        <a class="btn btn-success pull-right mb-3" href="{{route
                            ("projects.create")}}">{{__("Create a Project")}}</a>
                        <div class="clearfix"></div>

                        @if(count($projects))

                        <table class="table ">

                            <thead>
                            <tr >
                                <th scope="col">{{__("Name")}}</th>
                                <th scope="col">{{__("Created at")}}</th>
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
                                            <a href="{{route("projects.show",$project->id)}}"><button class="btn btn-primary "type="button">{{__("View")}}</button></a>
                                        </li>

                                        <li class="list-inline-item">
                                            <a href="{{route("projects.edit",$project->id)}}"><button class="btn
                                         btn-success "
                                            type="button">{{__("Edit")}}</button></a>
                                        </li>
                                        <li class="list-inline-item" >
                                            <form method="POST" action="{{ route('projects.destroy', $project->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-xs btn-danger btn-flat
                                                show_confirm" data-toggle="tooltip" title='Delete'> <i class="fa
                                                fa-trash"> </i>{{__("Delete")}}</button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>

                            </tbody>
                            @endforeach

                        </table>
                        @else
                        <div class="alert alert-info text-center">
                            {{__("There is no project.")}}
                        </div>
                        @endif
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
        $('.show_confirm').click(function(e) {
            if(!confirm('Are you sure you want to delete this?')) {
                e.preventDefault();
            }
        });
    </script>
</x-app-layout>
