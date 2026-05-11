@extends('layouts.app')

@section('title', __('messages.edit_association'))

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-warning">{{ __('messages.edit_association') }}</h2>

    {{-- Message d’erreur --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire de modification --}}
    <div class="card shadow-lg p-4">
        <form action="{{ route('association.update', $association->id_asso) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nom_asso" class="form-label">{{ __('messages.association_name') }}</label>
                <input type="text" name="nom_asso" id="nom_asso" class="form-control"
                       value="{{ old('nom_asso', $association->nom_asso) }}" required>
            </div>

            <div class="mb-3">
                <label for="email_asso" class="form-label">{{ __('messages.email') }}</label>
                <input type="email" name="email_asso" id="email_asso" class="form-control"
                       value="{{ old('email_asso', $association->email_asso) }}" required>
            </div>

            <div class="mb-3">
                <label for="ville_asso" class="form-label">{{ __('messages.city') }}</label>
                <input type="text" name="ville_asso" id="ville_asso" class="form-control"
                       value="{{ old('ville_asso', $association->ville_asso) }}" required>
            </div>

            <div class='mb-3'>
                <label for="domaine_id" class="form_label">{{ __('messages.domain') }}</label>
                <select name="domaine_id" id="domaine_id" class="form-control" required>
                    <option value="">-- Sélectionnez un domaine --</option>
                    @foreach ($domaines as $domaine)
                        <option value="{{ $domaine->id_domaine }}"
                            {{ old('domaine_id', $association->domaine_id) == $domaine->id_domaine ? 'selected' : '' }}>
                            {{ $domaine->nom_domaine }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description_asso" class="form-label">{{ __('messages.description') }}</label>
                <input type="text" name="description_asso" id="description_asso" class="form-control"
                       value="{{ old('description_asso', $association->description_asso) }}" required>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning text-white px-4">{{ __('messages.save') }}</button>
                <a href="{{ route('association') }}" class="btn btn-secondary px-4">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
