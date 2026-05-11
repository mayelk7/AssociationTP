@extends('layouts.app')

@section('title', __('messages.domain'))

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">{{ __('messages.add_domain') }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg p-4">
        <form action="{{ route('domaine.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nom_domaine" class="form-label">{{ __('messages.name') }}</label>
                <input type="text" class="form-control" id="nom_domaine" name="nom_domaine"
                       value="{{ old('nom_domaine') }}" required>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">{{ __('messages.create') }}</button>
                <a href="{{ route('association') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
