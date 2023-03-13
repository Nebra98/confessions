@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('confessions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Korisničko ime</label>
                        <input type="text" class="form-control" name="user_name" placeholder="Anonymous" value="Anonymous">
                    </div>
                    <div class="mb-3">
                        <label for="confession" class="form-label">Ostavi ispovijed ovdje</label>
                        <textarea class="form-control" name="confession" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
