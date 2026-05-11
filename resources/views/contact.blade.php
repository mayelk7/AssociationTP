@extends('layouts.app')

@section('title', __('messages.contact_us'))
@section('content')
    <h2 class="text-center mb-4 text-primary">{{ __('messages.contact_us') }}</h2>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ __('messages.success') }}
        </div>
    @endif

    {{-- Formulaire --}}
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">{{ __('messages.subject') }}</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                           id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">{{ __('messages.message') }}</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" 
                              id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('messages.send') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
