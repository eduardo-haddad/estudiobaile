@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
       <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-xs btn-info">
                                    edit
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('category.destroy', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">
                                    x
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
       </div>
    </div>

@stop