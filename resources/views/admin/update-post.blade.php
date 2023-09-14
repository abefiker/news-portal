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

                        <form role="form" method="post" action="{{ route('admin.post.update', $post->id) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Post Title</label>
                                            <input type="text" name="title" value="{{ $post->title }}"
                                                class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Categories</label>
                                            <select name="category_id" class="form-control" id="">
                                                <option value="{{ $post->category_id }}" selected>
                                                    {{ $post->category ? $post->category->title : 'No Category' }}</option>
                                                @if ($categories->count() > 0)
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                @else
                                                    <h3>no category title</h3>
                                                @endif
                                            </select>

                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="views">Tags</label>
                                            <select name="tag_id" class="form-control" id="">
                                                @if ($tags->count() > 0)
                                                        @foreach ($tags as $tag)
                                                            <option value="{{$tag->id}}">{{$tag->tag}}</option>
                                                        @endforeach
                                                @else

                                                @endif
                                            </select>
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="special">is a news special</label>
                                            <select name="special" class="form-control" id="">
                                                <option value="1" @if ($post->special) selected @endif>Yes
                                                </option>
                                                <option value="0"
                                                    @unless ($post->special) selected @endif>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="breaking">is a news breaking</label>
                                            <select name="breaking" class="form-control" id="">
                                                <option value="1" @if ($post->breaking) selected @endif>Yes</option>
                                                <option value="0" @unless ($post->breaking) selected @endif>
                                                    No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Post cover image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="short_desc">short Description</label>
                                        <textarea name="short_desc" class="form-control" cols="30" rows="10">{{ $post->short_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="long_desc">Long Description</label>
                                    <textarea name="long_desc" class="form-control" id="editor">{{ $post->long_desc }}</textarea>
                                </div>
                                <input type="number" name="user_id" value="{{auth()->id()}}" autocomplete="off" hidden>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">update</button>
                                @if (Session::has('success'))
                                    <script>
                                        toastr.success("{{ Session::get('success') }}");
                                    </script>
                                @endif
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
