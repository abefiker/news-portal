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

                        <form role="form" method="post" action="{{ route('categories.update', $category->id) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="parent_category">Parent Category</label>
                                    <select name="parent_id" class="form-control">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                @if ($category->parent_id == $cat->id) selected @endif>{{ $cat->title }}
                                            </option>
                                            @if ($cat->children->count())
                                                @include('partials.subcategories', [
                                                    'subcategories' => $cat->children,
                                                    'prefix' => '--',
                                                ])
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Categoty Title</label>
                                            <input type="text" name="title" value="{{ $category->title }}"
                                                class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Category Image</label>
                                            <input type="file" name="image" value="{{ $category->image }}"
                                                class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea name="desc" class="form-control" id="editor">{{ $category->desc }}</textarea>
                                </div>
                                <input type="number" name="user_id" value="{{ auth()->id() }}" autocomplete="off" hidden>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">update</button>
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
