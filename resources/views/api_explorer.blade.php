@extends('layouts.app')

@section('title', 'API Explorer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary mb-0">API Explorer</h2>
    <span class="badge bg-secondary fs-6">Base : <code class="text-white">{{ url('/api/v1') }}</code></span>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-4" id="apiTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-associations" data-bs-toggle="tab" data-bs-target="#pane-associations" type="button" role="tab">
            Associations <span class="badge bg-primary ms-1" id="badge-associations">…</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-domaines" data-bs-toggle="tab" data-bs-target="#pane-domaines" type="button" role="tab">
            {{ __('messages.domain') }} <span class="badge bg-primary ms-1" id="badge-domaines">…</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-emails" data-bs-toggle="tab" data-bs-target="#pane-emails" type="button" role="tab">
            Emails <span class="badge bg-primary ms-1" id="badge-emails">…</span>
        </button>
    </li>
</ul>

<div class="tab-content">

    {{-- ===== ASSOCIATIONS ===== --}}
    <div class="tab-pane fade show active" id="pane-associations" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted small">GET <code>{{ url('/api/v1/associations') }}</code></span>
            <div class="input-group" style="max-width: 280px;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="search-associations" class="form-control" placeholder="Filtrer…">
            </div>
        </div>
        <div id="loading-associations" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
        <div id="error-associations" class="alert alert-danger d-none"></div>
        <div class="row g-3" id="cards-associations"></div>
    </div>

    {{-- ===== DOMAINES ===== --}}
    <div class="tab-pane fade" id="pane-domaines" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted small">GET <code>{{ url('/api/v1/domaines') }}</code></span>
            <div class="input-group" style="max-width: 280px;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="search-domaines" class="form-control" placeholder="Filtrer…">
            </div>
        </div>
        <div id="loading-domaines" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
        <div id="error-domaines" class="alert alert-danger d-none"></div>
        <div class="row g-3" id="cards-domaines"></div>
    </div>

    {{-- ===== EMAILS ===== --}}
    <div class="tab-pane fade" id="pane-emails" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted small">GET <code>{{ url('/api/v1/emails') }}</code></span>
            <div class="input-group" style="max-width: 280px;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="search-emails" class="form-control" placeholder="Filtrer…">
            </div>
        </div>
        <div id="loading-emails" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
        <div id="error-emails" class="alert alert-danger d-none"></div>
        <table class="table table-striped table-bordered align-middle d-none" id="table-emails">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Association</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody id="rows-emails"></tbody>
        </table>
    </div>

</div>
@endsection

@section('scripts')
<script>
const API = '{{ url('/api/v1') }}';

/* ── helpers ─────────────────────────────────── */
function showError(key, msg) {
    document.getElementById(`loading-${key}`).classList.add('d-none');
    const el = document.getElementById(`error-${key}`);
    el.textContent = `Erreur : ${msg}`;
    el.classList.remove('d-none');
}

function domaineBadgeColor(name) {
    const colors = ['primary','success','danger','warning','info','secondary'];
    let hash = 0;
    for (const c of name) hash += c.charCodeAt(0);
    return colors[hash % colors.length];
}

/* ── ASSOCIATIONS ────────────────────────────── */
let allAssociations = [];

async function loadAssociations() {
    try {
        const data = await fetch(`${API}/associations`).then(r => r.json());
        allAssociations = data;
        document.getElementById('badge-associations').textContent = data.length;
        renderAssociations(data);
        document.getElementById('loading-associations').classList.add('d-none');
    } catch (e) {
        showError('associations', e.message);
    }
}

function renderAssociations(data) {
    const container = document.getElementById('cards-associations');
    if (!data.length) {
        container.innerHTML = '<p class="text-muted">Aucune association trouvée.</p>';
        return;
    }
    container.innerHTML = data.map(a => `
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title mb-0 fw-bold">${escHtml(a.nom_asso)}</h6>
                        <span class="badge bg-${domaineBadgeColor(a.domaine?.nom_domaine ?? '')}">${escHtml(a.domaine?.nom_domaine ?? '—')}</span>
                    </div>
                    <p class="text-muted small mb-1"><i class="bi bi-geo-alt"></i> ${escHtml(a.ville_asso ?? '—')}</p>
                    <p class="small mb-1"><i class="bi bi-envelope"></i>
                        ${a.email_asso
                            ? `<a href="mailto:${escHtml(a.email_asso)}">${escHtml(a.email_asso)}</a>`
                            : '<span class="text-muted">—</span>'}
                    </p>
                    ${a.description_asso
                        ? `<p class="small text-muted mt-2 mb-0" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">${escHtml(a.description_asso)}</p>`
                        : ''}
                </div>
                <div class="card-footer bg-transparent text-end">
                    <a href="/api/v1/associations/${a.id_asso}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-braces"></i> JSON
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

document.getElementById('search-associations').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    renderAssociations(allAssociations.filter(a =>
        a.nom_asso.toLowerCase().includes(q) ||
        (a.ville_asso ?? '').toLowerCase().includes(q) ||
        (a.domaine?.nom_domaine ?? '').toLowerCase().includes(q) ||
        (a.email_asso ?? '').toLowerCase().includes(q)
    ));
});

/* ── DOMAINES ────────────────────────────────── */
let allDomaines = [];

async function loadDomaines() {
    try {
        const data = await fetch(`${API}/domaines`).then(r => r.json());
        allDomaines = data;
        document.getElementById('badge-domaines').textContent = data.length;
        renderDomaines(data);
        document.getElementById('loading-domaines').classList.add('d-none');
    } catch (e) {
        showError('domaines', e.message);
    }
}

function renderDomaines(data) {
    const container = document.getElementById('cards-domaines');
    if (!data.length) {
        container.innerHTML = '<p class="text-muted">Aucun domaine trouvé.</p>';
        return;
    }
    container.innerHTML = data.map(d => `
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body d-flex flex-column justify-content-center">
                    <span class="display-6 mb-2">🏷️</span>
                    <h6 class="fw-bold mb-1">${escHtml(d.nom_domaine)}</h6>
                    <small class="text-muted">id : ${d.id_domaine}</small>
                </div>
                <div class="card-footer bg-transparent text-end">
                    <a href="/api/v1/domaines/${d.id_domaine}/associations" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-list-ul"></i> Associations
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

document.getElementById('search-domaines').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    renderDomaines(allDomaines.filter(d => d.nom_domaine.toLowerCase().includes(q)));
});

/* ── EMAILS ──────────────────────────────────── */
let allEmails = [];

async function loadEmails() {
    try {
        const data = await fetch(`${API}/emails`).then(r => r.json());
        allEmails = data;
        document.getElementById('badge-emails').textContent = data.length;
        renderEmails(data);
        document.getElementById('loading-emails').classList.add('d-none');
        document.getElementById('table-emails').classList.remove('d-none');
    } catch (e) {
        showError('emails', e.message);
    }
}

function renderEmails(data) {
    const tbody = document.getElementById('rows-emails');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="3" class="text-muted text-center">Aucun email trouvé.</td></tr>';
        return;
    }
    tbody.innerHTML = data.map((e, i) => `
        <tr>
            <td class="text-muted">${i + 1}</td>
            <td>${escHtml(e.nom_asso)}</td>
            <td><a href="mailto:${escHtml(e.email_asso)}">${escHtml(e.email_asso)}</a></td>
        </tr>
    `).join('');
}

document.getElementById('search-emails').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    renderEmails(allEmails.filter(e =>
        e.nom_asso.toLowerCase().includes(q) ||
        e.email_asso.toLowerCase().includes(q)
    ));
});

/* ── sécurité XSS ────────────────────────────── */
function escHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
}

/* ── init ────────────────────────────────────── */
loadAssociations();
loadDomaines();
loadEmails();
</script>
@endsection