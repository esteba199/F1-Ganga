<div class="card glass border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h6 class="mb-0 fw-bold text-warning">{{ $review->user->name }}</h6>
                <small class="text-white-50">{{ $review->created_at->diffForHumans() }}</small>
            </div>
            <div class="text-warning">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} small"></i>
                @endfor
            </div>
        </div>
        <div class="bg-white bg-opacity-5 p-3 rounded-3 position-relative">
            <i class="bi bi-quote text-warning fs-3 position-absolute top-0 start-0 opacity-25" style="transform: translate(-5px, -10px);"></i>
            <p class="card-text text-light small mb-0 font-italic ps-3">
                {{ $review->comment }}
            </p>
        </div>
    </div>
</div>
