@extends('layouts.client')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            {!!$about->about!!}
        </div>
    </div>
@endsection
