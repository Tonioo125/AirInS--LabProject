@extends('layouts.main')

@section('content')

<div class="property-grid py-4 px-5">
    @foreach ($properties as $property)
    <x-card :property="$property" />
    @endforeach
</div>

{{ $properties->links('vendor.pagination.custom') }}

@endsection