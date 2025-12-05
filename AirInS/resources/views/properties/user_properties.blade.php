@extends('layouts.main')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
        @if (auth()->user()->role === 'admin')
            <h2 class="mb-0 fw-bold">List of Properties</h2>
        @else
            <h2 class="mb-0 fw-bold">Your Properties</h2>
        @endif
        
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($properties->isEmpty())
        <div class="text-muted">You don't have any properties yet.</div>
    @else
        <div class="row g-4">
            @foreach ($properties as $property)
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <a href="{{ route('bookings.detail', $property->id) }}" class="text-decoration-none">
                            <img src="{{ asset('storage/' . $property->photos) }}" class="card-img-top" alt="{{ $property->title }}" style="height:200px; object-fit:cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title title mb-1 fw-bold">{{ $property->title }}</h5>
                            <p class="card-text location mb-2">{{ $property->location }}</p>
                            <p class="card-text price fw-semibold reds-color mb-0">Rp {{ number_format($property->price, 0, ',', '.') }}</p>
                            <p class="card-text category mb-1">Category: {{ optional($property->propertyCategories)->name ?? 'N/A' }}</p>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('bookings.detail', $property->id) }}" class="btn px-0 py-1 reds-color text-decoration-none">View Detail →</a>
                                <div class="d-flex gap-3 align-items-center">
                                    <a href="{{ route('property.edit', $property->id) }}" class="btn px-0 py-1 text-decoration-none text-secondary">Edit</a>
                                    <form class="p-1 mb-0" action="{{ route('property.destroy', $property->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
                                        @csrf
                                        <button type="submit" class="btn px-0 py-1 text-decoration-none reds-color">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $properties->links('vendor.pagination.custom') }}
        </div>

    @endif
</div>
@endsection

@push('styles')
<style>
.card-img-top { border-top-left-radius: .5rem; border-top-right-radius: .5rem; }
.category {
    font-size: 14px;
    color: #bdbdbdff;
}
.location{
    font-size: 15px;
    color: #999999ff;
}
.btn{
    font-size: 14px;
    border: none;
}
.container {
    padding: 40px 80px;
    margin: 0;
    min-width: 100%;
}
</style>
@endpush
