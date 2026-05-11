@extends('layouts.app')

@section('title', __('messages.add_association'))

@section('content')
    <div class="container mt-4">
        <h2 class="text-center text-primary mb-4">{{ __('messages.add_new_association') }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-lg">
            <div class="card-body">
                <form method="POST" action="{{ route('association.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nom_asso" class="form-label">{{ __('messages.association_name') }}</label>
                        <input type="text" class="form-control" id="nom_asso" name="nom_asso" required>
                    </div>

                    <div class="mb-3">
                        <label for="email_asso" class="form-label">{{ __('messages.email') }}</label>
                        <input type="email" class="form-control" id="email_asso" name="email_asso" required>
                    </div>

                    <div class="mb-3">
                        <label for="ville_asso" class="form-label">{{ __('messages.city') }}</label>
                        <input type="text" class="form-control" id="ville_asso" name="ville_asso" required>
                    </div>

                    <div class='mb-3'>
                        <label for="domaine_id" class="form-label">{{ __('messages.domain') }}</label>
                        <select name="domaine_id" id="domaine_id" class="form-control" required>
                            <option value="">-- Sélectionnez un domaine --</option>
                            @foreach ($domaines as $domaine)
                                <option value="{{ $domaine->id_domaine }}"
                                    {{ old('domaine_id') == $domaine->id_domaine ? 'selected' : '' }}>
                                    {{ $domaine->nom_domaine }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description_asso" class="form-label">{{ __('messages.description') }}</label>
                        <textarea class="form-control" id="description_asso" name="description_asso" rows="3"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ __('messages.create') }}</button>
                        <a href="{{ route('association') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
