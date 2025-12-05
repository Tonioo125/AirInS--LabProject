@extends('layouts.main')

@section('content')
<div class="container">

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger mt-4 border-5 mx-auto">
            <p class="mb-0"><strong>Error:</strong> {{ $errors->first() }}</p>
        </div>
    @endif

    {{-- Flash Messages --}}
    @if (session('error'))
    <div class="mt-4 alert alert-danger border-5 mx-auto">
        {{ session('error') }}
    </div>
    @endif

    {{-- Main Content --}}
    <div class="row g-5 py-5">

        {{-- Left Image --}}
        <div class="col-lg-7">
            <img src="{{ asset('storage/' . $property->photos) }}"
                alt="{{ $property->title }}"
                class="img-fluid rounded-4 shadow-sm"
                style="width:100%; height:420px; object-fit:cover;">
        </div>

        {{-- Right Booking Card --}}
        <div class="col-lg-5">
            {{-- Property Title --}}
            <h2 class="fw-bold mb-0">{{ $property->title }}</h2>
            <div class="d-flex mb-3 align-items-center text-muted">
                <span>{{ $property->location }}</span>

                <span class="mx-1" style="font-size: 8px;">●</span> {{-- separator dot --}}

                <span>Category: {{ optional($property->propertyCategories)->name ?? 'N/A' }}</span>
            </div>

            <h4 class="fw-bold mb-0 reds-color text-danger">
                Rp {{ number_format($property->price, 0, ',', '.') }} <small class="text-muted">/ night</small>
            </h4>

            <p class="text-muted mb-1">Hosted by <strong class="text-black">{{ optional($property->airusers)->name ?? 'N/A' }}</strong></p>

            {{-- Property Description --}}
            <p class="mt-3">
                {{ $property->description ?? 'No description available.' }}
            </p>
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold mb-4">Reserve</h5>

                <form action="{{ route('bookings.store', ['id' => $property->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">

                    {{-- Check-in --}}
                    <div class="mb-3">
                        <label class="form-label">Check-in</label>
                        <div class="input-group">
                            <input type="date"
                                id="check_in"
                                name="check_in"
                                class="form-control border-0 border-bottom rounded-0"
                                style="box-shadow:none;"
                                value="{{ old('check_in') }}"
                                required>
                        </div>
                    </div>

                    {{-- Check-out --}}
                    <div class="mb-3">
                        <label class="form-label">Check-out</label>
                        <div class="input-group">
                            <input type="date"
                                id="check_out"
                                name="check_out"
                                class="form-control border-0 border-bottom rounded-0"
                                style="box-shadow:none;"
                                value="{{ old('check_out') }}"
                                required>
                        </div>
                    </div>

                    {{-- Guests selector --}}
                    <div class="mb-3">
                        <label class="form-label">Guests</label>

                        <div class="d-flex align-items-center gap-2">

                            {{-- minus --}}
                            <button type="button"
                                class="btn rounded-circle gray-bg"
                                onclick="document.getElementById('guestCount').value = Math.max(1, parseInt(document.getElementById('guestCount').value) - 1)">
                                –
                            </button>

                            {{-- number input --}}
                            <input id="guestCount"
                                type="number"
                                name="guests"
                                min="1"
                                value="{{ old('guests', 1) }}"
                                class="form-control border-0 border-bottom rounded-0 text-center guest-count"
                                style="max-width: 70px; box-shadow:none;"
                                required>

                            {{-- plus --}}
                            <button type="button"
                                class="btn rounded-circle gray-bg"
                                onclick="document.getElementById('guestCount').value = parseInt(document.getElementById('guestCount').value) + 1">
                                +
                            </button>

                        </div>
                    </div>


                    {{-- Reserve Button --}}
                    @if(auth()->check())
                    <button type="submit" class="btn btn-danger reds-bg w-100 py-2">
                        Reserve
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-danger reds-bg w-100 py-2">
                        Login to Book
                    </a>
                    @endif
                </form>
            </div>
        </div>

    </div>

    {{-- Reviews Section --}}
    <div class="mt-5 px-5">
        <h3 class="fw-bold mb-4">Reviews</h3>

        @if(isset($reviews) && $reviews->count() > 0)
        @foreach($reviews as $review)
        <div class="card mb-3 border-1 shadow-sm rounded-4 p-3">
            <div class="d-flex flex-row justify-content-between">
                <strong class="mb-0">{{ optional($review->user)->name ?? 'Anonymous' }}</strong>
                <span class="ms-2 text-warning">⭐ {{ $review->rating }}/5</span>
            </div>

            <p class="mt-2 mb-1 fw-light text-secondary">{{ $review->comment }}</p>
            <small class="text-muted">
                Reviewed on {{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}
            </small>
        </div>
        @endforeach
        @else
        <p class="text-muted">No reviews yet for this property.</p>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .card{
        border: 1px solid #e0e0e0;
    }
</style>
@endpush

@push('scripts')
<script>
(function(){
    const dataEl = document.getElementById('bookedRangesData');
    const bookedRanges = dataEl ? JSON.parse(dataEl.dataset.json || '[]') : [];

    const inEl = document.getElementById('check_in');
    const outEl = document.getElementById('check_out');

    function parse(d){ return new Date(d + 'T00:00:00'); }
    function todayStr(){ const t = new Date(); const d = new Date(t.getFullYear(), t.getMonth(), t.getDate()); return d.toISOString().slice(0,10); }

    function isDateInRanges(dStr){
        const d = parse(dStr);
        return bookedRanges.some(r => d >= parse(r.start) && d <= parse(r.end));
    }

    function rangesOverlap(aStart, aEnd, bStart, bEnd){
        const as = parse(aStart), ae = parse(aEnd), bs = parse(bStart), be = parse(bEnd);
        return as <= be && bs <= ae;
    }

    function selectionOverlaps(){
        if(!(inEl?.value && outEl?.value)) return false;
        return bookedRanges.some(r => rangesOverlap(inEl.value, outEl.value, r.start, r.end));
    }

    function bumpOneDay(dStr){ const d = parse(dStr); d.setDate(d.getDate() + 1); return d.toISOString().slice(0,10); }

    // Disallow selecting past dates
    const tStr = todayStr();
    if(inEl) inEl.min = tStr;
    if(outEl) outEl.min = tStr;

    function syncOutMin(){
        if(!inEl || !outEl) return;
        if(!inEl.value){ outEl.min = tStr; return; }
        outEl.min = bumpOneDay(inEl.value);
    }

    inEl?.addEventListener('change', () => {
        if(inEl.value && isDateInRanges(inEl.value)){
            inEl.value = '';
            syncOutMin();
            return;
        }
        syncOutMin();
        if(outEl?.value && selectionOverlaps()){
            outEl.value = '';
        }
    });

    outEl?.addEventListener('change', () => {
        if(outEl.value && isDateInRanges(outEl.value)){
            outEl.value = '';
            return;
        }
        if(selectionOverlaps()){
            outEl.value = '';
        }
    });

})();
</script>
@endpush