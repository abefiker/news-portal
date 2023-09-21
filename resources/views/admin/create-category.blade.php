@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $page }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $page }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $page }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form role="form" method="post" action="{{ route('categories.create') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                                @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="parent_category">Parent Category</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">No Parent Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @if ($category->children->count())
                                                @include('partials.subcategories', [
                                                    'subcategories' => $category->children,
                                                    'prefix' => '--',
                                                ])
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Category Title</label>
                                            <input type="text" name="title" class="form-control" autocomplete="off"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Category Image</label>
                                            <input type="file" name="image" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea name="desc" class="form-control" id="editor"></textarea>
                                </div>
                                <input type="number" name="user_id" value="{{ auth()->id() }}" autocomplete="off" hidden>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">create</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
