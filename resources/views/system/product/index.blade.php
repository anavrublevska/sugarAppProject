@extends('layouts.app')

@section('title', 'Moje dania i produkty')
@section('header', 'Moje dania i produkty')
@section('addButton')
    <a href="{{ route('products.create') }}" class="btn btn-outline-info"><i class="fa fa-plus"></i> Dodaj</a>
@endsection

@section('content')
    <ul>
        @forelse ($products as $product)
            <div class="py-12">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-green-200 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <i class="fa-solid fa-carrot text-gray-500"></i>  {{ $product->name }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ __("Nie dodałeś jeszcze żadnego dania lub produktu.") }}
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </ul>
@endsection
