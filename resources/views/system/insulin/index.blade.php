@extends('layouts.app')

@section('title', 'Moje insuliny')
@section('header', 'Moje insuliny')
@section('addButton')
    <a href="{{ route('insulins.create') }}" class="btn btn-outline-info"><i class="fa fa-plus"></i> Dodaj</a>
@endsection

@section('content')
    <ul>
        @forelse ($insulins as $insulin)
            <div class="py-12">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-yellow-100 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <i class="fas fa-syringe text-gray-500"></i>  {{ $insulin->name }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ __("Nie ma dostępnych insulin.") }}
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </ul>
@endsection
