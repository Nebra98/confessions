@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
                            @php
                                $count = 1;
                            @endphp

                        @forelse($confessions as $confession)
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="card border-dark">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-dark">#{{$confession->id }} objavio: {{ $confession->user_name }}</p>
                                                    <p class="text-dark">Objavljeno: {{ \Carbon\Carbon::parse($confession->created_at)->diffForHumans() }}</p>
                                                </div>

                                                <a class="text-decoration-none text-dark" href="{{ route('confessions.show', $confession) }}">
                                                    <p class="card-text">{{ $confession->confession }}</p>
                                                </a>

                                            </div>
                                            <div class="card-footer">
                                                <button class="btn btn-secondary like-button" id="buttonSubmitLike" data-confession-id="{{ $confession->id }}"><i class="fas fa-heart"></i> Odobravam <span class="badge badge-light" id="likeCount{{$confession->id}}">{{count($confession->likes)}}</span></button>
                                                <button class="btn btn-secondary dislike-button" data-confession-id="{{ $confession->id }}"><i class="fas fa-heart-broken"></i> Osuđujem <span class="badge badge-light" id="dislikeCount{{$confession->id}}">{{count($confession->dislikes)}}</span></button>

                                                <a href="{{ route('confessions.show', $confession) }}" role="button" class="btn btn-secondary">
                                                    <i class="fas fa-comment"></i> <span class="badge badge-light">{{count($confession->comments)}}</span>
                                                </a>
                                                @auth
                                                @if (\App\Models\SaveConfession::where('confession_id', $confession->id)->where('user_id', auth()->user()->id)->first())
                                                    <button class="btn btn-secondary float-end save-confession" data-confession-id="{{ $confession->id }}" id="saveConfessionButton{{$confession->id}}"><i class="fa-solid fa-bookmark"></i></button>
                                                @else
                                                    <button class="btn btn-secondary float-end save-confession" data-confession-id="{{ $confession->id }}" id="saveConfessionButton{{$confession->id}}"><i class="fa-regular fa-bookmark"></i>
                                                    </button>
                                                @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $count++;
                                @endphp

                            @empty
                                {{ __('Ne postoji ni jedna ispovijest u sustavu!') }}
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $confessions->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">
    $(document).ready(function(){

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

</script>

