@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 mb-3">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @guest
                        @include('partials._modals')
                    @endguest

                    @forelse($confessions as $confession)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                @include('partials._confession')
                            </div>
                        </div>
                    @empty
                        {{ __('Ne postoji ni jedna ispovijest u sustavu!') }}
                    @endforelse

                    <div class="d-flex justify-content-center">
                        {!! $confessions->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
