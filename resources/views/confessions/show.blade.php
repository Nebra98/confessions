@extends('layouts.app')
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
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            @guest
                            <!-- Modal -->
                            <div class="modal fade" id="modalForLike" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Sviđa vam se ova ispovijest?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0 mb-3">Prijavite se kako bi se vaše mišljenje računalo.</p>
                                            <a role="button" href="{{ route('login') }}" class="btn btn-secondary">Prijavi se</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modalForDislike" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ne sviđa vam se ova ispovijest?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0 mb-3">Prijavite se kako bi se vaše mišljenje računalo.</p>
                                            <a role="button" href="{{ route('login') }}" class="btn btn-secondary">Prijavi se</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endguest

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="card border-dark">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-dark">#{{$confession->id }} objavio: {{ $confession->user_name }}</p>
                                                <p class="text-dark">Objavljeno: {{ \Carbon\Carbon::parse($confession->created_at)->diffForHumans() }}</p>
                                            </div>
                                            <p class="card-text">{{ $confession->confession }}</p>
                                        </div>

                                        <div class="card-footer">
                                            @auth
                                                <div class="btn-group" role="group">
                                                    @if($confession->likes->where('user_id', auth()->user()->id)->count() > 0)
                                                        <button class="btn btn-secondary like-button" data-confession-id="{{ $confession->id }}" id="likeButton{{$confession->id}}"><i class="fa-solid fa-thumbs-up"></i> <span class="badge badge-light" id="likeCount{{$confession->id}}">{{count($confession->likes)}}</span></button>
                                                    @endif
                                                    @if($confession->likes->where('user_id', auth()->user()->id)->count() == 0)
                                                        <button class="btn btn-secondary like-button" data-confession-id="{{ $confession->id }}" id="likeButton{{$confession->id}}"><i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light" id="likeCount{{$confession->id}}">{{count($confession->likes)}}</span></button>
                                                    @endif

                                                    <div class="vl"></div>
                                                    @if($confession->dislikes->where('user_id', auth()->user()->id)->count() > 0)
                                                        <button class="btn btn-secondary dislike-button" data-confession-id="{{ $confession->id }}" id="dislikeButton{{$confession->id}}"><i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light" id="dislikeCount{{$confession->id}}">{{count($confession->dislikes)}}</span></button>
                                                    @endif
                                                    @if($confession->dislikes->where('user_id', auth()->user()->id)->count() == 0)
                                                        <button class="btn btn-secondary dislike-button" data-confession-id="{{ $confession->id }}" id="dislikeButton{{$confession->id}}"><i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light" id="dislikeCount{{$confession->id}}">{{count($confession->dislikes)}}</span></button>
                                                    @endif
                                                </div>
                                            @endauth

                                                @guest
                                                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalForLike"><i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light">{{count($confession->likes)}}</span></button>
                                                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalForDislike"><i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">{{count($confession->dislikes)}}</span></button>
                                                @endguest
                                            @auth
                                                @if (\App\Models\SaveConfession::where('confession_id', $confession->id)->where('user_id', auth()->user()->id)->first())
                                                        <button class="btn btn-secondary float-end save-confession" data-confession-id="{{ $confession->id }}" id="saveConfessionButton{{$confession->id}}"><i class="fa-solid fa-bookmark"></i></button>
                                                    @else
                                                        <button class="btn btn-secondary float-end save-confession" data-confession-id="{{ $confession->id }}" id="saveConfessionButton{{$confession->id}}"><i class="fa-regular fa-bookmark"></i>
                                                </button>
                                                    @endif
                                                @endauth
                                                <a href="{{ route('confessions.show', $confession) }}" role="button" class="btn btn-secondary">
                                                    <i class="fas fa-comment"></i> <span class="badge badge-light">{{count($confession->comments)}}</span>
                                                </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-dark" role="alert">
                                Ostavi svoj komentar
                            </div>

                            <form id="addForm" name="addForm" action="{{ route('comments.store') }}">
                                @csrf
                                <input type="hidden" name="confession_id" id="confessionId" value="{{ $confession->id }}">
                                <input type="hidden" name="comment_id" id="commentId">
                                <div class="form-group mb-3">
                                    <label for="name">Ime</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="comment">Komentar</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Enter your comment"></textarea>
                                </div>

                                <button class="btn btn-secondary btn-submit" id="buttonSubmit"><i class="fas fa-comment-plus"></i> <i class="fas fa-comment-medical"></i> Ostavi komentar</button>

                            </form>
                            <hr>
                            <blockquote class="blockquote">
                                <p class="mb-0">Lista komentara</p>
                            </blockquote>
                            <div id="memberBody">

                            </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            showComments();

            $('#addForm').submit(function(e) {
                e.preventDefault();
                $(buttonSubmit).html('Sending..');
                var url = $(this).attr("action");
                let formData = new FormData(this);

                $.ajax({
                    data: formData,
                    url: url,
                    type: "POST",
                    contentType: false,
                    processData: false,

                    success: function (data) {
                        console.log("Done;");
                        $("#comment").val("");
                        $("#name").val("");
                        $(buttonSubmit).html('Submit');
                        showComments();
                    },


                });
            });


            $(document).on('click', '.like-button', function() {
                var confession_id = $(this).data('confession-id');

                $.ajax({
                    url: '{{ route("like") }}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'confession_id': confession_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // Update the UI to show the like has been added

                        var likeButtonChange = '#likeButton' + confession_id;
                        var dislikeButtonChange = '#dislikeButton' + confession_id;

                        if(data.action == 'like'){
                            $(likeButtonChange).html('<i class="fa-solid fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                        }
                        if(data.action == 'unlike'){
                            $(likeButtonChange).html('<i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                        }
                        if(data.action == 'like-dislike-remove'){
                            $(likeButtonChange).html('<i class="fa-solid fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                            $(dislikeButtonChange).html('<i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                        }

                    }
                });
            });

            $(document).on('click', '.dislike-button', function() {
                var confession_id = $(this).data('confession-id');

                $.ajax({
                    url: '{{ route("dislike") }}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'confession_id': confession_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // Update the UI to show the dislike has been added

                        var likeButtonChange = '#likeButton' + confession_id;
                        var dislikeButtonChange = '#dislikeButton' + confession_id;

                        if(data.action == 'dislike'){
                            $(dislikeButtonChange).html('<i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                        }
                        if(data.action == 'undislike'){
                            $(dislikeButtonChange).html('<i class="fa-regular fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                        }
                        if(data.action == 'dislike-like-remove'){
                            $(dislikeButtonChange).html('<i class="fa-solid fa-thumbs-down fa-flip-horizontal"></i> <span class="badge badge-light">' + data.dislikesCount + '</span>');
                            $(likeButtonChange).html('<i class="fa-regular fa-thumbs-up"></i> <span class="badge badge-light">' + data.likesCount + '</span>');
                        }

                    }
                });
            });

            $(document).on('click', '.save-confession', function() {
                var confession_id = $(this).data('confession-id');

                $.ajax({
                    url: '{{ route("saveConfession") }}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'confession_id': confession_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // Update the UI to show the dislike has been added

                        $('#saveConfessionCount').html(data.savedConfessionCount);
                        console.log(data.action);
                        var ifIsSaved = '#saveConfessionButton' + confession_id;
                        if(data.action == 'unsaved'){
                            $(ifIsSaved).html('<i class="fa-regular fa-bookmark"></i>');
                        }else{
                            $(ifIsSaved).html('<i class="fa-solid fa-bookmark"></i>');
                        }

                        //$('#saveConfessionButton').html('Save');
                        //$('#saveConfessionButton').html('Unsave');

                    }
                });
            });


        });

        function showComments(){
            $.get("{{ URL::to('comments/commentslist/' . $confession->id) }}", function(data){
                $('#memberBody').empty().html(data);
            })
        }

        function postReply(commentId) {
            $('#commentId').val(commentId);
            $('#name').focus();
            console.log("works");
        }

    </script>
@endsection

