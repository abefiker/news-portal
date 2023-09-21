@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) code... -->
    <div class="content-header">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $page }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin/homr">Home</a></li>
                            <li class="breadcrumb-item active">{{ $page }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-header">
                        <h3 class="card-title">{{ $page }}</h3>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-responsive-sm categories-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($categories->count() > 0)
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->title }}</td>
                                        <td>{!! $category->desc !!}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>
                                            <a href="{{route('categories.edit', $category->id)}}" class="edit btn btn-primary btn-sm">view/edit</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link"><i class="fa fa-trash text-danger"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h3>No Events Found</h3>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

