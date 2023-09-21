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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($events->count() > 0)
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event->title }}</td>
                                            <td>{!! $event->desc !!}</td>
                                            <td>{{ $event->date }}</td>
                                            <td><a href="{{ route('events.edit', $event->id) }}"><i class="fa fa-eye"></i>/<i
                                                        class="fa fa-edit"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('events.destroy', $event->id) }}" method="post">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
