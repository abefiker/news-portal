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
                    @if (auth()->check())
                        <table class="table table-striped table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Event title</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($events->count() > 0)
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event->title }}</td>
                                            <td>{!! $event->desc !!}</td>
                                            <td>{{ $event->date }}</td>
                                            <td><a href="{{ route('admin.event.update.form', $event->id) }}"><i
                                                        class="fa fa-eye"></i>/<i class="fa fa-edit"></i></a>
                                                @if (Session::has('success'))
                                                    <script>
                                                        toastr.success("{{ Session::get('success') }}");
                                                    </script>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('admin.event.destroy', $event->id) }}"><i
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
                                    <h3>No Events Found</h3>
                                @endif
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
