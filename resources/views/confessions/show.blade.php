@extends('layouts.app')

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

                    @guest
                        @include('partials._modals')
                    @endguest

                    <div class="row mb-3">
                        <div class="col-md-12">
                            @include('partials._confession')
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
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Unesite svoje ime">
                        </div>

                        <div class="form-group mb-3">
                            <label for="comment">Komentar</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"
                                      placeholder="Unesite svoj komentar"></textarea>
                        </div>

                        <button class="btn btn-secondary btn-submit" id="buttonSubmit"><i
                                class="fas fa-comment-plus"></i> <i class="fas fa-comment-medical"></i> Ostavi komentar
                        </button>

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

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            showComments();
            $('#addForm').submit(function (e) {
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
                        $("#comment").val("");
                        $("#name").val("");
                        $(buttonSubmit).html('Submit');
                        showComments();
                    },
                });
            });

        });

        function showComments() {
            $.get("{{ URL::to('comments/commentslist/' . $confession->id) }}", function (data) {
                $('#memberBody').empty().html(data);
            })
        }

        function postReply(commentId) {
            $('#commentId').val(commentId);
            $('#name').focus();
        }
    </script>

@endsection
