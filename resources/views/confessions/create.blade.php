@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('confessions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Korisničko ime</label>
                        <input type="text" class="form-control" name="user_name" placeholder="Anonymous" value="{{ old('user_name') ?? 'Anonymous' }}" required>
                        @error('user_name')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="confession" class="form-label">Ostavi ispovijed ovdje</label>
                        <textarea class="form-control" name="confession" rows="8" required>{{ old('confession') }}</textarea>

                        @error('confession')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
