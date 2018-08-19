@extends('layouts.app')

@section('content')

    {{-- Errors --}}
    @include('admin.elements.errors')

    <div class="panel panel-default">

        <div class="panel-heading">
            Edit category: {{ $category->name }}
        </div>

        <div class="panel-body">

        <form action="{{ route('category.update', ['id' => $category->id]) }}" method="post">
                
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Name</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control">
                </div>

                <div class="form-group">
                    <div class="text-left">
                        <button class="btn btn-success" type="submit">
                            Save category
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@stop