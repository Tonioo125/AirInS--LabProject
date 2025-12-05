@extends('layouts.main')

@section('content')
<div class="container py-4 px-5">

    @if($properties->isEmpty())
        <p class="text-muted fs-5">No property can be displayed</p>
    @else
        <div class="property-grid d-flex flex-wrap justify-content-start gap-4">
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
