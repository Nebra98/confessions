@extends('layouts.app')
<script src="{{ asset('jquery.js') }}"></script>

<style>
    .vl {
        border-left: 4px solid #ccc;
        height: 36px;
    }
</style>
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
                    <blockquote class="blockquote">
                        <p class="mb-0">Spremljene ispovijesti</p>
                    </blockquote>

                    @forelse($saved_confessions as $save_confession)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card border-dark">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <p class="text-dark">#{{$save_confession->confession->id }}
                                                <i class="fa-solid fa-feather text-secondary"></i> {{ $save_confession->confession->user_name }}
                                            </p>
                                            <p class="text-dark">
                                                <i class="fa-regular fa-clock text-secondary"></i> {{ \Carbon\Carbon::parse($save_confession->confession->created_at)->diffForHumans() }}
                                            </p>
                                        </div>

                                        <a class="text-decoration-none text-dark"
                                           href="{{ route('confessions.show', $save_confession->confession) }}">
                                            <p class="card-text">{{ $save_confession->confession->confession }}</p>
                                        </a>

                                    </div>
                                    <div class="card-footer">
                                        @auth
                                            <div class="btn-group" role="group">
                                                @if($save_confession->confession->likes->where('user_id', auth()->user()->id)->count() > 0)
                                                    <button class="btn btn-secondary like-button"
                                                            data-confession-id="{{ $save_confession->confession->id }}"
                                                            id="likeButton{{$save_confession->confession->id}}"><i
                                                            class="fa-solid fa-thumbs-up"></i> <span
                                                            class="badge badge-light"
                                                            id="likeCount{{$save_confession->confession->id}}">{{count($save_confession->confession->likes)}}</span>
                                                    </button>
                                                @endif
                                                @if($save_confession->confession->likes->where('user_id', auth()->user()->id)->count() == 0)
                                                    <button class="btn btn-secondary like-button"
                                                            data-confession-id="{{ $save_confession->confession->id }}"
                                                            id="likeButton{{$save_confession->confession->id}}"><i
                                                            class="fa-regular fa-thumbs-up"></i> <span
                                                            class="badge badge-light"
                                                            id="likeCount{{$save_confession->confession->id}}">{{count($save_confession->confession->likes)}}</span>
                                                    </button>
                                                @endif

                                                <div class="vl"></div>
                                                @if($save_confession->confession->dislikes->where('user_id', auth()->user()->id)->count() > 0)
                                                    <button class="btn btn-secondary dislike-button"
                                                            data-confession-id="{{ $save_confession->confession->id }}"
                                                            id="dislikeButton{{$save_confession->confession->id}}">
                                                        <i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i>
                                                        <span class="badge badge-light"
                                                              id="dislikeCount{{$save_confession->confession->id}}">{{count($save_confession->confession->dislikes)}}</span>
                                                    </button>
                                                @endif
                                                @if($save_confession->confession->dislikes->where('user_id', auth()->user()->id)->count() == 0)
                                                    <button class="btn btn-secondary dislike-button"
                                                            data-confession-id="{{ $save_confession->confession->id }}"
                                                            id="dislikeButton{{$save_confession->confession->id}}">
                                                        <i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i>
                                                        <span class="badge badge-light"
                                                              id="dislikeCount{{$save_confession->confession->id}}">{{count($save_confession->confession->dislikes)}}</span>
                                                    </button>
                                                @endif
                                            </div>
                                        @endauth
                                        <a href="{{ route('confessions.show', $save_confession->confession) }}"
                                           role="button" class="btn btn-secondary">
                                            <i class="fas fa-comment"></i> <span
                                                class="badge badge-light">{{count($save_confession->confession->comments)}}</span>
                                        </a>
                                        @auth
                                            @if (\App\Models\SaveConfession::where('confession_id', $save_confession->confession->id)->where('user_id', auth()->user()->id)->first())
                                                <button class="btn btn-secondary float-end save-confession"
                                                        data-confession-id="{{ $save_confession->confession->id }}"
                                                        id="saveConfessionButton{{$save_confession->confession->id}}">
                                                    <i class="fa-solid fa-bookmark"></i></button>
                                            @else
                                                <button class="btn btn-secondary float-end save-confession"
                                                        data-confession-id="{{ $save_confession->confession->id }}"
                                                        id="saveConfessionButton{{$save_confession->confession->id}}">
                                                    <i class="fa-regular fa-bookmark"></i>
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        {{ __('Niste spremili ni jednu ispovijest!') }}
                    @endforelse

                </div>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('click', '.like-button', function () {
            var confession_id = $(this).data('confession-id');

            $.ajax({
                url: '{{ route("like") }}',
                type: 'post',
                dataType: 'json',
                data: {
                    'confession_id': confession_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Update the UI to show the like has been added

                    var likeButtonChange = '#likeButton' + confession_id;
                    var dislikeButtonChange = '#dislikeButton' + confession_id;

                    if (data.action == 'like') {
                        $(likeButtonChange).html('<i class="fa-solid fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                    }
                    if (data.action == 'unlike') {
                        $(likeButtonChange).html('<i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                    }
                    if (data.action == 'like-dislike-remove') {
                        $(likeButtonChange).html('<i class="fa-solid fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                        $(dislikeButtonChange).html('<i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                    }

                }
            });
        });

        $(document).on('click', '.dislike-button', function () {
            var confession_id = $(this).data('confession-id');

            $.ajax({
                url: '{{ route("dislike") }}',
                type: 'post',
                dataType: 'json',
                data: {
                    'confession_id': confession_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Update the UI to show the dislike has been added

                    var likeButtonChange = '#likeButton' + confession_id;
                    var dislikeButtonChange = '#dislikeButton' + confession_id;

                    if (data.action == 'dislike') {
                        $(dislikeButtonChange).html('<i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                    }
                    if (data.action == 'undislike') {
                        $(dislikeButtonChange).html('<i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                    }
                    if (data.action == 'dislike-like-remove') {
                        $(dislikeButtonChange).html('<i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                        $(likeButtonChange).html('<i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                    }

                }
            });
        });

        $(document).on('click', '.save-confession', function () {
            var confession_id = $(this).data('confession-id');

            $.ajax({
                url: '{{ route("saveConfession") }}',
                type: 'post',
                dataType: 'json',
                data: {
                    'confession_id': confession_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Update the UI to show the dislike has been added

                    $('#saveConfessionCount').html(data.savedConfessionCount);
                    var ifIsSaved = '#saveConfessionButton' + confession_id;
                    if (data.action == 'unsaved') {
                        $(ifIsSaved).html('<i class="fa-regular fa-bookmark"></i>');
                    } else {
                        $(ifIsSaved).html('<i class="fa-solid fa-bookmark"></i>');
                    }

                }
            });
        });

    });

</script>

