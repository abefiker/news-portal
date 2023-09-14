@extends('layouts.client')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('become.writer') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Enter Your Phone') }}</label>
                        <input type="text" class="form-control" name="phone" value="" value="{{ old('phone') }}"
                            required autocomplete="phone" autofocus>
                        <input type="number" value="{{ $user->id }}" name="user_id" hidden>
                    </div>

                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Become Writer') }}
                        </button>
                    </div>
                    @if (Session::has('success'))
                        <script>
                            toastr.success("{{ Session::get('success') }}");
                        </script>
                    @else
                        <script>
                            toastr.error("{{ Session::get('error') }}");
                        </script>
                    @endif

                </form>
            </div>
        </div>
    </div>
@endsection
