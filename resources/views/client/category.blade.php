@extends('layouts.client')
@section('content')
    <div class="col-sm-12">
        <div class="card" data-aos="fade-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="font-weight-600 mb-4">
                            {{ $title }}
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        @if ($all_news->count() > 0)
                            @foreach ($all_news as $news)
                                <a href="{{ route('client.post', $news->id) }}" class="text-dark">
                                    <div class="row">
                                        <div class="col-sm-4 grid-margin">
                                            <div class="rotate-img">
                                                <img src="{{ asset('storage/settings/posts/' . $news->image) }}"
                                                    class="img-fluid" />
                                            </div>
                                        </div>
                                        <div class="col-sm-8 grid-margin">
                                            <h2 class="font-weight-600 mb-2">
                                                {{ $news->title }}
                                            </h2>
                                            <p class="fs-13 text-muted mb-0">
                                                <span class="mr-2">Posted </span>{{ $news->created_at->diffForHumans() }}
                                            </p>
                                            <p class="fs-15">
                                                {{ $news->short_desc }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <hr>
                            @endforeach
                        @else
                            <h3>No news Found</h3>
                        @endif

                    </div>
                    <div class="col-lg-4">
                        <h2 class="mb-4 text-primary font-weight-600">
                            Latest news
                        </h2>
                        @if ($latest_news->count() > 0)
                            @foreach ($latest_news as $news)
                                <a href="{{ route('client.post', $news->id) }}" class="text-dark">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="border-bottom pb-4 pt-4">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <h5 class="font-weight-600 mb-1">
                                                            {{ $news->title }}
                                                        </h5>
                                                        <p class="fs-13 text-muted mb-0">
                                                            <span class="mr-2">Posted
                                                            </span>{{ $news->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="rotate-img">
                                                            <img src="{{ asset('storage/settings/posts/' . $news->image) }}"
                                                                alt="banner" class="img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <hr>
                            @endforeach
                        @else
                            <h3>No Latest news Found</h3>
                        @endif

                        @if ($trending->count() > 0)
                            @foreach ($trending as $news)
                                <a href="{{ route('client.post', $news->id) }}" class="text-dark">
                                    <div class="trending">
                                        <h2 class="mb-4 text-primary font-weight-600">
                                            Trending
                                        </h2>
                                        <div class="mb-4">
                                            <div class="rotate-img">
                                                <img src="{{ asset('storage/settings/posts/' . $news->image) }}"
                                                    alt="banner" class="img-fluid">
                                            </div>
                                            <h3 class="mt-3 font-weight-600">
                                                {{ $news->title }}
                                            </h3>
                                            <p class="fs-13 text-muted mb-0">
                                                <span class="mr-2">Posted :
                                                </span>{{ $news->created_at->diffForHumans() }}
                                            </p>

                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <h3>No Trending Post</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
