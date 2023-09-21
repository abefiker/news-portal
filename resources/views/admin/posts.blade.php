@extends('layouts.master')

@section('content')
    <div class="content-header">
        <!-- Content Header (Page header) code... -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-header">
                        <h3 class="card-title">{{ $page }}</h3>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Short Description</th>
                                <th>Views</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($posts->count() > 0)
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>{!! $post->short_desc !!}</td>
                                        <td>{{ $post->views }}</td>
                                        <td>{{ $post->created_at }}</td>
                                        <td><a href="{{ route('posts.edit', $post->id) }}"><i
                                                    class="fa fa-eye"></i>/<i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', $post->id) }}"
                                                 method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                type="submit" class="btn btn-link">
                                                <i class="fa fa-trash text-danger"></i></button>
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

            {{-- trashed table --}}

            @if ($trashedPosts->count() > 0)
                <div class="col-lg-12">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">{{ $trash }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <table class="table table-striped table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Short Description</th>
                                    <th>Views</th>
                                    <th>Deleted at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedPosts as $trash)
                                    <tr>
                                        <td>{{ $trash->title }}</td>
                                        <td>{!! $trash->short_desc !!}</td>
                                        <td>{{ $trash->views }}</td>
                                        <td>{{ $trash->deleted_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.posts.restore', $trash->id) }}"><i
                                                    class="fa fa-undo"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <h3>No trash posts</h3>
            @endif
        </div>
    </div>
@endsection
