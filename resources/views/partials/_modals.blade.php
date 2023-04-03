<!-- Modal for Like Confession -->
<div class="modal fade" id="modalForLike" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sviđa vam se ova ispovijest?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 mb-3">Prijavite se kako bi se vaše mišljenje računalo.</p>
                <a role="button" href="{{ route('login') }}" class="btn btn-secondary">Prijavi
                    se</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Dislike Confession -->
<div class="modal fade" id="modalForDislike" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ne sviđa vam se ova
                    ispovijest?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 mb-3">Prijavite se kako bi se vaše mišljenje računalo.</p>
                <a role="button" href="{{ route('login') }}" class="btn btn-secondary">Prijavi
                    se</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Save Confession -->
<div class="modal fade" id="modalForSave" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Želite li ovo ponovno pogledati
                    kasnije?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 mb-3">Prijavite se kako bi dodali ovu ispovijest u favorite.</p>
                <a role="button" href="{{ route('login') }}" class="btn btn-secondary">Prijavi
                    se</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal For Like Comment -->
<div class="modal fade" id="modalForLikeComment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sviđa vam se ovaj komentar?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 mb-3">Prijavite se kako bi se vaše mišljenje računalo.</p>
                <a role="button" href="{{ route('login') }}" class="btn btn-secondary">Prijavi se</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Dislike Comment -->
<div class="modal fade" id="modalForDislikeComment" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ne sviđa vam se ovaj komentar?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 mb-3">Prijavite se kako bi se vaše mišljenje računalo.</p>
                <a role="button" href="{{ route('login') }}" class="btn btn-secondary">Prijavi se</a>
            </div>
        </div>
    </div>
</div>
