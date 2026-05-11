@extends('layouts.app')

@section('title', __('messages.domain_list'))

@section('content')
<h2 class="text-center mb-4 text-primary">{{ __('messages.domain_management') }}</h2>

@if (session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger text-center">{{ session('error') }}</div>
@endif

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('domaine.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> {{ __('messages.add_domain') }}
    </a>
</div>

<div class="card shadow-lg">
    <div class="card-body">
        <table class="table table-striped table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('messages.id') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.association_count') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($domaines as $domaine)
                <tr>
                    <td>{{ $domaine->id_domaine }}</td>
                    <td>{{ $domaine->nom_domaine }}</td>
                    <td>{{ $domaine->associations_count }}</td>
                    <td>
                        <form action="{{ route('domaine.destroy', $domaine->id_domaine) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('{{ __('messages.confirm_delete_domain') }}')">
                                <i class="bi bi-trash"></i> {{ __('messages.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">{{ __('messages.no_domain_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
