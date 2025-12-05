@extends('layouts.main')

@section('content')
<div class="container mx-auto">
    <div class="row justify-content-center mb-3">
        <div class="w-75">
            <h3 class="mb-0 fw-bold">Add New Property</h3>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger w-75 mx-auto">
            <p class="mb-0"><strong>Error:</strong> {{ $errors->first() }}</p>
        </div>
    @endif

    {{-- Flash Messages --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="cardd border-0 w-75">
            <div class="d-flex flex-column">
            <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3">
                @csrf
                    <div class="mb-2">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" validated>
                        @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" validated>
                        @error('location')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" validated>
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Choose Category --</option>
                            @foreach($categories ?? [] as $c)
                                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Price (per night)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" step="1" validated>
                        @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" validated>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Photos (JPEG/JPG/PNG, max 100MB each)</label>
                        <input type="file" name="photos" class="form-control" accept="image/*">
                        @error('photos')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger reds-bg">Add Property</button>

            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .container { padding: 40px; }
    .cardd .form-control, .cardd .form-select, .cardd textarea { width: 100%; }
        .cardd .form-control,
        .cardd .form-select,
        .cardd textarea {
            border: none;
            border-bottom: 2px solid #eeeeeeff;
            border-radius: 0;
            box-shadow: none;
        }
        .cardd .form-control[type="file"] {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            border-radius: 0;
            box-shadow: none;
        }
        .cardd .form-control[type="file"]::file-selector-button {
            border: 1px solid #000;
            border-radius: 4px;
            background: #fff;
            padding: .375rem .75rem;
            margin-right: .75rem;
            cursor: pointer;
        }
        .cardd .form-control[type="file"]::-webkit-file-upload-button {
            border: 1px solid #000;
            border-radius: 4px;
            background: #fff;
            padding: .375rem .75rem;
            margin-right: .75rem;
            cursor: pointer;
        }
        .cardd .form-control:focus,
        .cardd .form-select:focus,
        .cardd textarea:focus {
            border: none;
            border-bottom: 2px solid #dc3545;
            box-shadow: none;
            outline: none;
        }
</style>
@endpush
