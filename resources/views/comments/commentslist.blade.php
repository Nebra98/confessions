<style>
    .comment {
        padding: 10px;
        margin: 10px 0;
    }

    .cardd {
        border-left-style: solid;
    }

    .comment .replies {
        margin-left: 5px;
    }

    .vl {
        border-left: 4px solid #ccc;
        height: 36px;
    }

</style>

@forelse($comments as $comment)
    <div class="comment cardd">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <p class="text-dark"><i
                        class="fa-solid fa-feather text-secondary"></i> {{ $comment->comment_sender_name }}</p>
                <p class="text-dark"><i
                        class="fa-regular fa-clock text-secondary"></i> {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                </p>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $comment->comment }}</p>

        </div>

        <div class="card-footer">

            @auth
                <div class="btn-group btn-group-sm" role="group">
                    @if($comment->likes->where('user_id', auth()->user()->id)->count() > 0)
                        <button class="btn btn-secondary like-comment-button" data-comment-id="{{ $comment->id }}"
                                id="commentlikeButton{{$comment->id}}"><i class="fa-solid fa-thumbs-up"></i> <span
                                class="badge badge-light"
                                id="likeCommentCount{{$comment->id}}">{{count($comment->likes)}}</span></button>
                    @endif
                    @if($comment->likes->where('user_id', auth()->user()->id)->count() == 0)
                        <button class="btn btn-secondary like-comment-button" data-comment-id="{{ $comment->id }}"
                                id="commentlikeButton{{$comment->id}}"><i class="fa-regular fa-thumbs-up"></i> <span
                                class="badge badge-light"
                                id="likeCommentCount{{$comment->id}}">{{count($comment->likes)}}</span></button>
                    @endif
                    <div class="vl"></div>
                    @if($comment->dislikes->where('user_id', auth()->user()->id)->count() > 0)
                        <button class="btn btn-secondary dislike-comment-button" data-comment-id="{{ $comment->id }}"
                                id="commentdislikeButton{{$comment->id}}"><i
                                class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light"
                                                                                              id="dislikeCommentCount{{$comment->id}}">{{count($comment->dislikes)}}</span>
                        </button>
                    @endif
                    @if($comment->dislikes->where('user_id', auth()->user()->id)->count() == 0)
                        <button class="btn btn-secondary dislike-comment-button" data-comment-id="{{ $comment->id }}"
                                id="commentdislikeButton{{$comment->id}}"><i
                                class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span
                                class="badge badge-light"
                                id="dislikeCommentCount{{$comment->id}}">{{count($comment->dislikes)}}</span></button>
                    @endif
                </div>
            @endauth
            @guest
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalForLikeComment"><i
                            class="fa-regular fa-thumbs-up"></i> <span
                            class="badge badge-light">{{count($comment->likes)}}</span></button>
                    <div class="vl"></div>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalForDislikeComment"><i
                            class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span
                            class="badge badge-light">{{count($comment->dislikes)}}</span></button>
                </div>
            @endguest

            <a role="button" class="btn btn-secondary btn-reply" aria-disabled="true"
               onclick="postReply({{ $comment->id }})"><i class="fas fa-reply"></i></a>

        </div>


        @if(count($comment->replies))
            <div class="replies">
                @include('comments.commentslist', ['comments' => $comment->replies])
            </div>
        @endif
    </div>
@empty
    Ispovijest nema komentara
@endforelse

<script type="text/javascript">

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.like-comment-button', function (e) {
            var comment_id = $(this).data('comment-id');

            $.ajax({
                url: '{{ route("likeComment") }}',
                type: 'post',
                dataType: 'json',
                data: {
                    'comment_id': comment_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Update the UI to show the like has been added

                    var likeButtonChange = '#commentlikeButton' + comment_id;
                    var dislikeButtonChange = '#commentdislikeButton' + comment_id;

                    if (data.action == 'like') {
                        $(likeButtonChange).html('<i class="fa-solid fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCommentCount + '</span>');
                    }
                    if (data.action == 'unlike') {
                        $(likeButtonChange).html('<i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCommentCount + '</span>');
                    }
                    if (data.action == 'like-dislike-remove') {
                        $(likeButtonChange).html('<i class="fa-solid fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCommentCount + '</span>');
                        $(dislikeButtonChange).html('<i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCommentCount + '</span>');
                    }

                }
            });
            e.stopImmediatePropagation();
        });

        $(document).on('click', '.dislike-comment-button', function (e) {
            var comment_id = $(this).data('comment-id');

            $.ajax({
                url: '{{ route("dislikeComment") }}',
                type: 'post',
                dataType: 'json',
                data: {
                    'comment_id': comment_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Update the UI to show the like has been added

                    var likeButtonChange = '#commentlikeButton' + comment_id;
                    var dislikeButtonChange = '#commentdislikeButton' + comment_id;

                    if (data.action == 'dislike') {
                        $(dislikeButtonChange).html('<i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCommentCount + '</span>');
                    }
                    if (data.action == 'undislike') {
                        $(dislikeButtonChange).html('<i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCommentCount + '</span>');
                    }
                    if (data.action == 'dislike-like-remove') {
                        $(dislikeButtonChange).html('<i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCommentCount + '</span>');
                        $(likeButtonChange).html('<i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCommentCount + '</span>');
                    }

                }
            });
            e.stopImmediatePropagation();
        });

    });

</script>
