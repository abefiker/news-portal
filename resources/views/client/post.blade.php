@extends('layouts.client')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card" data-aos="fade-up">
                <div class="card-body">
                    <div class="aboutus-wrapper">
                        <h1 class="mt-5">
                            {{$post->title}}
                        </h1>
                        {!!$post->long_desc!!}
                    </div>
                    <div class="col-sm-4 grid-margin mx-3">
                        <div class="rotate-img">
                            <img
                            src="{{asset('storage/settings/posts/'.$post->image)}}"
                                class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
