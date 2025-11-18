@extends('layouts.main')

@section('content')
<div class="search-page">
    <h2 class="search-title">Search Results for "<span>{{ $keyword }}</span>"</h2>

    @if($properties->isEmpty())
        <p class="no-result">No property found matching your search.</p>
    @else
        <div class="property-grid">
            @foreach ($properties as $property)
                <x-card :property="$property" />
            @endforeach
        </div>

        <div class="pagination">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
