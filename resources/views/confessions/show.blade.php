@extends('layouts.app')

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
                                            <button class="btn btn-secondary like-button" id="buttonSubmitLike" data-confession-id="{{ $confession->id }}"><i class="fas fa-heart"></i> Odobravam <span class="badge badge-light" id="likeCount{{$confession->id}}">{{count($confession->likes)}}</span></button>
                                            <button class="btn btn-secondary dislike-button" data-confession-id="{{ $confession->id }}"><i class="fas fa-heart-broken"></i> Osuđujem <span class="badge badge-light" id="dislikeCount{{$confession->id}}">{{count($confession->dislikes)}}</span></button>

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

                                <button class="btn btn-secondary btn-submit" id="buttonSubmit">Submit</button>

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

                        var likeCountId = '#likeCount' + confession_id;
                        var dislikeCountId = '#dislikeCount' + confession_id;
                        $(likeCountId).html(data.likesCount);
                        $(dislikeCountId).html(data.dislikesCount);

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

                        var likeCountId = '#likeCount' + confession_id;
                        var dislikeCountId = '#dislikeCount' + confession_id;
                        $(likeCountId).html(data.likesCount);
                        $(dislikeCountId).html(data.dislikesCount);

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

