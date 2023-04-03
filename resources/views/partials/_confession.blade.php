<style>
    .vl {
        border-left: 4px solid #ccc;
        height: 36px;
    }
</style>
<div class="card border-dark">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <p class="text-dark">#{{$confession->id }} <i
                    class="fa-solid fa-feather text-secondary"></i> {{ $confession->user_name }}
            </p>
            <p class="text-dark"><i
                    class="fa-regular fa-clock text-secondary"></i> {{ \Carbon\Carbon::parse($confession->created_at)->diffForHumans() }}
            </p>
        </div>

        <a class="text-decoration-none text-dark"
           href="{{ route('confessions.show', $confession) }}">
            <p class="card-text">{{ $confession->confession }}</p>
        </a>

    </div>
    <div class="card-footer">
        @auth
            <div class="btn-group" role="group">
                @if($confession->likes->where('user_id', auth()->user()->id)->count() > 0)
                    <button class="btn btn-secondary like-button"
                            data-confession-id="{{ $confession->id }}"
                            id="likeButton{{$confession->id}}"><i
                            class="fa-solid fa-thumbs-up"></i> <span
                            class="badge badge-light"
                            id="likeCount{{$confession->id}}">{{count($confession->likes)}}</span>
                    </button>
                @endif
                @if($confession->likes->where('user_id', auth()->user()->id)->count() == 0)
                    <button class="btn btn-secondary like-button"
                            data-confession-id="{{ $confession->id }}"
                            id="likeButton{{$confession->id}}"><i
                            class="fa-regular fa-thumbs-up"></i> <span
                            class="badge badge-light"
                            id="likeCount{{$confession->id}}">{{count($confession->likes)}}</span>
                    </button>
                @endif

                <div class="vl"></div>
                @if($confession->dislikes->where('user_id', auth()->user()->id)->count() > 0)
                    <button class="btn btn-secondary dislike-button"
                            data-confession-id="{{ $confession->id }}"
                            id="dislikeButton{{$confession->id}}"><i
                            class="fa-solid fa-thumbs-down fa-flip-horizontal"></i>
                        <span class="badge badge-light"
                              id="dislikeCount{{$confession->id}}">{{count($confession->dislikes)}}</span>
                    </button>
                @endif
                @if($confession->dislikes->where('user_id', auth()->user()->id)->count() == 0)
                    <button class="btn btn-secondary dislike-button"
                            data-confession-id="{{ $confession->id }}"
                            id="dislikeButton{{$confession->id}}"><i
                            class="fa-regular fa-thumbs-down fa-flip-horizontal"></i>
                        <span class="badge badge-light"
                              id="dislikeCount{{$confession->id}}">{{count($confession->dislikes)}}</span>
                    </button>
                @endif
            </div>
        @endauth
        @guest
            <div class="btn-group" role="group">
                <button class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#modalForLike"><i
                        class="fa-regular fa-thumbs-up"></i> <span
                        class="badge badge-light">{{count($confession->likes)}}</span>
                </button>
                <div class="vl"></div>
                <button class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#modalForDislike"><i
                        class="fa-regular fa-thumbs-down fa-flip-horizontal"></i>
                    <span
                        class="badge badge-light">{{count($confession->dislikes)}}</span>
                </button>
            </div>
        @endguest
        <a href="{{ route('confessions.show', $confession) }}" role="button"
           class="btn btn-secondary">
            <i class="fas fa-comment"></i> <span
                class="badge badge-light">{{count($confession->comments)}}</span>
        </a>
        @auth
            @if (\App\Models\SaveConfession::where('confession_id', $confession->id)->where('user_id', auth()->user()->id)->first())
                <button class="btn btn-secondary float-end save-confession"
                        data-confession-id="{{ $confession->id }}"
                        id="saveConfessionButton{{$confession->id}}"><i
                        class="fa-solid fa-bookmark"></i></button>
            @else
                <button class="btn btn-secondary float-end save-confession"
                        data-confession-id="{{ $confession->id }}"
                        id="saveConfessionButton{{$confession->id}}"><i
                        class="fa-regular fa-bookmark"></i>
                </button>
            @endif
        @endauth
        @guest
            <button class="btn btn-secondary float-end" data-bs-toggle="modal"
                    data-bs-target="#modalForSave"><i
                    class="fa-regular fa-bookmark"></i></button>
        @endguest
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.like-button', function (e) {
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
            e.stopImmediatePropagation();
        });
        $(document).on('click', '.dislike-button', function (e) {
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
            e.stopImmediatePropagation();
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
            e.stopImmediatePropagation();
        });
    });
</script>
