@extends('layouts.main')

@section('content')
<div class="container py-4 px-5">
    <div class="property-grid d-flex flex-wrap justify-content-start gap-4">
        @foreach ($properties as $property)
            <x-card :property="$property" />
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $properties->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection
