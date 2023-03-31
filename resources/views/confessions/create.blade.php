@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
                        <div class="form-group">
                            <label for="confession" class="form-label">Ostavi ispovijed ovdje</label>
                            <textarea class="form-control count" name="confession" id="confession" rows="8" maxlength="1000" required>{{ old('confession') }}</textarea>
                            <small class="form-text text-muted">0 characters remaining</small>

                            @error('confession')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>

    function countCharacters() {
        var max = $(this).attr("maxlength");
        var length = $(this).val().length;
        var counter = max - length;
        var helper = $(this).next(".form-text");
        // Switch to the singular if there's exactly 1 character remaining
        if (counter !== 1) {
            helper.text(counter + " characters remaining");
        } else {
            helper.text(counter + " character remaining");
        }
        // Make it red if there are 0 characters remaining
        if (counter === 0) {
            helper.removeClass("text-muted");
            helper.addClass("text-danger");
        } else {
            helper.removeClass("text-danger");
            helper.addClass("text-muted");
        }
    }

    $(document).ready(function () {
        $(".count").each(countCharacters);
        $(".count").keyup(countCharacters);
    });
</script>
