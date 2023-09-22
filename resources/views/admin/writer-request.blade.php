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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Sent on</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($writer_requests->count() > 0)
                                @foreach ($writer_requests as $writer_request)
                                    @if ($writer_request->user)
                                        <tr>
                                            <td>{{ $writer_request->user->name }}</td>
                                            <td>{{ $writer_request->user->email }}</td>
                                            <td>{{ $writer_request->phone }}</td>
                                            <td>{{ $writer_request->created_at }}</td>
                                            @if ($writer_request->user->is_writer)
                                                <td><a
                                                        href="{{ route('admin.writer_request.bann', $writer_request->user_id) }}"><i
                                                            class="fa fa-ban text-danger">Ban Adverter</i>
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    <a
                                                        href="{{ route('admin.writer_request.approve', $writer_request->user_id) }}"><i
                                                            class="fa fa-edit text-success">Approve Adverter</i>
                                                    </a>
                                                </td>
                                            @endif
                                            <td>
                                                <a href="{{ route('writers.destroy', $writer_request->user_id) }}"><i
                                                        class="fa fa-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <h3>No Writers request Found</h3>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
