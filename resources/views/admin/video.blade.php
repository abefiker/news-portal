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
                    <table class="table table-striped table-responsive-sm">
                        <thead>
                            <tr>
                                <th>video title</th>
                                <th>Url/Link</th>
                                <th>Posted On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($videos->count() > 0)
                                @foreach ($videos as $video)
                                    <tr>
                                        <td>{{ $video->title }}</td>
                                        <td>{!! $video->url !!}</td>
                                        <td>{{ $video->created_at }}</td>
                                        <td><a href="{{ route('videos.edit', $video->id) }}">
                                                <i class="fa fa-eye"></i>/<i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('videos.destroy', $video->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link">
                                                    <i class="fa fa-trash text-danger"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h3>No videos Found</h3>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
