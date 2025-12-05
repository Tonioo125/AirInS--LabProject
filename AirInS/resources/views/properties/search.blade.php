@extends('layouts.main')

@section('content')
<div class="search-page py-4 px-5">
    {{-- Judul pencarian --}}
    <h2 class="search-title">
        <span class="search-label">Search Results for:</span>
        <span class="keyword-text">{{ $keyword }}</span>
    </h2>

    {{-- Jika tidak ada hasil --}}
    @if($properties->isEmpty())
        <p class="no-result">No property found matching your search.</p>
    @else
        <div class="property-grid">
            @foreach ($properties as $property)
                <x-card :property="$property" />
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
    .search-page {
        text-align: left; 
    }

    .search-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
    }

    .search-title .search-label{
        color: #777;
    }
    .search-title .keyword-text {
        color: #000; 
        font-weight: 700; 
    }

    .no-result {
        color: #777;
        font-size: 16px;
        margin-top: 10px;
        text-align: left; 
    }

    .property-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start; 
    }
</style>
@endpush