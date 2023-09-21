@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $Category->count() }}</h3>
                            <p>Categories</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('categories.index') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $Post->count() }}</h3>
                            <p>posts</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('posts.index') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $User->count() }}</h3>
                            <p>User registration</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('posts.index') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $Writer_requests->count() }}</h3>
                            <p>write request</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-newspaper"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.writer.request') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $Advertise_requests->count() }}</h3>
                            <p>Advertise request</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-wifi"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.adverter.request') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $Event->count() }}</h3>

                            <p>Events</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('events.index') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{ $video->count() }}</h3>
                            <p>videos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-play"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('videos.index') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $writers->count() }}</h3>
                            <p>writers</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.video') }}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Latest Users</h3>
                        </div>
                        <!-- /.card-header -->
                        <table class="table table-bordered table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($latest_users->count() > 0)
                                    @foreach ($latest_users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>View/Edit</td>
                                            <td>Delete</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <h3>NO user found in database</h3>
                                @endif
                            </tbody>
                        </table>

                    </div>

                </div>

                {{-- second table --}}
                <div class="col-lg-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Latest Posts</h3>
                        </div>
                        <!-- /.card-header -->
                        <table class="table table-bordered table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>View</th>
                                    <th>Category</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($latest_posts->count() > 0)
                                    @foreach ($latest_posts as $post)
                                        <tr>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->views }}</td>
                                            <td>{{ $post->category->title }}</td>
                                            @if (auth()->user()->is_admin)
                                            <td>


                                                <div class="btn-group">
                                                    <a href="{{ route('posts.edit', $post->id) }}"
                                                        class="edit btn btn-primary btn-sm">view/edit</a>
                                                    <form action="{{ route('posts.destroy', $post->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                    @if ($post->trashed())
                                                        <form action="{{ route('admin.post.restore', $post->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Restore</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <h3>NO post found in database</h3>
                                @endif
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
