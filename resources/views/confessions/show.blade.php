@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 mb-3">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="card border-dark">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dark">#{{$confession->id }} objavio: {{ $confession->user_name }}</p>
                                                <p class="text-dark">Objavljeno: {{ \Carbon\Carbon::parse($confession->created_at)->diffForHumans() }}</p>
                                            </div>
                                            <p class="card-text">{{ $confession->confession }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
