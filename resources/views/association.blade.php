@extends('layouts.app')

@section('title', __('messages.association_list'))

@section('content')
<h2 class="text-center mb-4 text-primary">{{ __('messages.association_list') }}</h2>

{{-- Message de succès --}}
@if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

@if(Auth::user()->is_admin)
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('association.create') }}" class="btn btn-success me-2">
        <i class="bi bi-plus-circle"></i> {{ __('messages.add_association') }}
    </a>

    <a href="{{ route('domaine.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> {{ __('messages.add_domain') }}
    </a>
</div>
@endif

<div class="card shadow-lg">
    <div class="card-body">
        <table id="associationsTable" class="table table-striped table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('messages.id') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.city') }}</th>
                    <th>{{ __('messages.domain') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($associations as $asso)
                <tr>
                    <td>{{ $asso->id_asso }}</td>
                    <td>{{ $asso->nom_asso }}</td>
                    <td><a href="mailto:{{ $asso->email_asso }}">{{ $asso->email_asso }}</a></td>
                    <td>{{ $asso->ville_asso }}</td>
                    <td>{{ $asso->domaine->nom_domaine }}</td>
                    <td>
                        <a href="{{ route('association.detail', $asso->id_asso) }}" class="btn btn-sm btn-info text-white">
                            {{ __('messages.details') }}
                        </a>
                        @if(Auth::user()->is_admin)
                        <a href="{{ route('association.edit', $asso->id_asso) }}" class="btn btn-sm btn-warning text-white">
                            {{ __('messages.edit') }}
                        </a>
                        <form action="{{ route('association.destroy', $asso->id_asso) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">{{ __('messages.no_association_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<!-- Inclure jQuery et DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#associationsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        "order": [[0, "asc"]], // tri par défaut sur la première colonne (ID)
        "paging": true,
        "searching": true,
        "columnDefs": [
            { "orderable": false, "targets": 5 } // Actions non triables
        ]
    });
});
</script>
@endsection
