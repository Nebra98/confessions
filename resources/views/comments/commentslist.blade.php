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
                <button class="btn btn-secondary btn-sm like-button" id="buttonSubmitLike" data-confession-id=""><i class="fas fa-heart"></i> Odobravam <span class="badge badge-light" id="likeCount"></span></button>
                <button class="btn btn-secondary btn-sm dislike-button" data-confession-id=""><i class="fas fa-heart-broken"></i> Osuđujem <span class="badge badge-light" id="dislikeCount"></span></button>
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
