<style>
    .comment {
        padding: 10px;
        margin: 10px 0;

    }

    .cardd {
        border-top: 0;
        border-right: 0;
        border-bottom: 0;
        border-radius: 0 !important;
        border-left-style: solid;
    }

    .comment .replies {
        margin-left: 20px;
        border-left-color: blue;

    }
</style>


@forelse($comments as $comment)
    <div class="row">
        <div class="comment cardd">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <p class="text-dark">Objavio: {{ $comment->comment_sender_name }}</p>
                    <p class="text-dark">Objavljeno: {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</p>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $comment->comment }}</p>

            </div>

            <div class="card-footer">
                <button class="btn btn-secondary btn-sm like-comment-button" data-comment-id="{{ $comment->id }}"><i class="fas fa-heart"></i> Odobravam <span class="badge badge-light" id="likeCommentCount{{$comment->id}}">{{count($comment->likes)}}</span></button>
                <button class="btn btn-secondary btn-sm dislike-comment-button" data-comment-id="{{ $comment->id }}"><i class="fas fa-heart-broken"></i> Osuđujem <span class="badge badge-light" id="dislikeCommentCount{{$comment->id}}">{{count($comment->dislikes)}}</span></button>
           <a class="btn btn-secondary btn-sm btn-reply" role="button" aria-disabled="true"
                                        onclick="postReply({{ $comment->id }})"><i class="fas fa-reply"></i> Odgovori</a>

            </div>


            @if(count($comment->replies))
                <div class="replies">
                    @include('comments.commentslist', ['comments' => $comment->replies])
                </div>
            @endif

        </div>
    </div>
@empty
    Ispovest nema komentara
@endforelse

<script type="text/javascript">

    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.like-comment-button', function(e) {
            var comment_id = $(this).data('comment-id');

            $.ajax({
                url: '{{ route("likeComment") }}',
                type: 'post',
                dataType: 'json',
                data: {
                    'comment_id': comment_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    // Update the UI to show the like has been added

                    var likeCommentCountId = '#likeCommentCount' + comment_id;

                    var dislikeCommentCountId = '#dislikeCommentCount' + comment_id;

                    $(likeCommentCountId).html(data.likesCommentCount);
                    $(dislikeCommentCountId).html(data.dislikesCommentCount);

                }
            });
            e.stopImmediatePropagation();
        });



    });


</script>
