@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @forelse($confessions as $confession)
                            {{ $confession->$confession }}
                            @empty
                                {{ __('Ne postoji ni jedna ispovijest u sustavu!') }}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
