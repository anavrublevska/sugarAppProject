@extends('layouts.app')

@section('title', 'Dodaj produkt lub danie')
@section('header', 'Dodaj produkt lub danie')
@section('addButton')

@endsection

@section('content')
    <body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col items-center sm:pt-10 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center mb-6 mt-4">
                <i class="fa-5x fa-solid fa-utensils text-gray-500"></i>
            </div>
            <form method="{{ $product ? 'PUT' : 'POST' }}" action="{{ $product ? route('products.update', $product) : route('products.store') }}">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Nazwa')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="Kasza gryczana z sałatką" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Zapisz') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    </body>
@endsection
