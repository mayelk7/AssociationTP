@extends('layouts.app')

@section('title', __('messages.home_title', ['site' => config('app.name')]))

@section('content')
    <div class="text-center py-5">
        <h1 class="mb-4">{{ __('messages.welcome') }}</h1>
        <p class="mb-4 fs-5">{{ __('messages.choose_page') }}</p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('association') }}" class="btn btn-primary btn-lg">{{ __('messages.associations') }}</a>
            <a href="{{ route('contact') }}" class="btn btn-success btn-lg">{{ __('messages.contact') }}</a>
        </div>
    </div>
@endsection