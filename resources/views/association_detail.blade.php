@extends('layouts.app')

@section('title', __('messages.association_details'))

@section('content')
    <h2 class="text-center mb-4 text-primary">{{ __('messages.association_details') }}</h2>

    <div class="card shadow-lg mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h4 class="card-title text-center mb-3">{{ $association->nom_asso }}</h4>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>{{ __('messages.id') }} :</strong> {{ $association->id_asso }}
                </li>
                <li class="list-group-item">
                    <strong>{{ __('messages.email') }} :</strong> 
                    <a href="mailto:{{ $association->email_asso }}">
                        {{ $association->email_asso }}
                    </a>
                </li>
                <li class="list-group-item">
                    <strong>{{ __('messages.city') }} :</strong> {{ $association->ville_asso }}
                </li>
                    <li class="list-group-item">
                    <strong>{{ __('messages.domain') }} :</strong> {{ $association->domaine->nom_domaine }}
                </li>
                <li class="list-group-item">
                    <strong>{{ __('messages.description') }} :</strong>
                    <p class="mt-2">{{ $association->description_asso }}</p>
                </li>
            </ul>

            <div class="mt-4 text-center">
                <a href="{{ route('association') }}" class="btn btn-secondary">
                    ← {{ __('messages.back_to_list') }}
                </a>

                @if(Auth::user()->is_admin)
                <a href="{{ route('association.edit', $association->id_asso) }}"
                   class="btn btn-warning text-white">
                    {{ __('messages.edit') }}
                </a>

                <form action="{{ route('association.destroy', $association->id_asso) }}"
                      method="POST"
                      style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                        {{ __('messages.delete') }}
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection
