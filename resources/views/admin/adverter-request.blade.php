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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($adverter_requests->count() > 0)
                                @foreach ($adverter_requests as $adverter_request)
                                    <tr>
                                        <td>{{ $adverter_request->user->name }}</td>
                                        <td>{{ $adverter_request->user->email }}</td>
                                        <td>{{ $adverter_request->phone }}</td>
                                        <td>{{ $adverter_request->created_at }}</td>
                                        @if ($adverter_request->user->is_adverter)
                                            <td><a
                                                    href="{{ route('admin.advert_request.bann', $adverter_request->user_id) }}"><i
                                                        class="fa fa-ban text-danger">Ban Adverter</i></a>
                                                @if (Session::has('success'))
                                                    <script>
                                                        toastr.success("{{ Session::get('success') }}");
                                                    </script>
                                                @endif
                                            </td>
                                        @else
                                            <td><a
                                                    href="{{ route('admin.advert_request.approve', $adverter_request->user_id) }}"><i
                                                        class="fa fa-edit text-success">Approve Adverter</i></a>
                                                @if (Session::has('success'))
                                                    <script>
                                                        toastr.success("{{ Session::get('success') }}");
                                                    </script>
                                                @endif
                                            </td>
                                        @endif
                                        <td><a
                                                href="{{ route('admin.advert_request.destroy', $adverter_request->user_id) }}"><i
                                                    class="fa fa-trash text-danger"></i></a>
                                            @if (Session::has('success'))
                                                <script>
                                                    toastr.success("{{ Session::get('success') }}");
                                                </script>
                                            @endif
                                        </td>
                                    </tr>
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



<!-- The rest of your HTML and scripts... -->
