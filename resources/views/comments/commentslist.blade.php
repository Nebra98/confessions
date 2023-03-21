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

           <a class="btn btn-secondary btn-sm btn-reply" role="button" aria-disabled="true"
                                        onclick="postReply({{ $comment->id }})">Odgovori</a>
            <hr>
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
