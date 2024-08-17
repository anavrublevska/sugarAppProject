@push('styles')
    <style>
        .box {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            justify-content: space-between;
            flex-direction: row;
        }

        .box > div .me {
            flex: 1 1 160px;
            width: 30%;
        }
    </style>

@endpush

@extends('layouts.app')

@section('title', 'Dodawanie wpisu do historii')
@section('header', 'Dodawanie wpisu do historii')
@section('addButton')

@endsection

@section('content')
    <body class="font-sans text-gray-900 antialiased">
    {{--    <div class="min-h-screen flex flex-row sm:pt-10 bg-gray-100 pb-40"--}}
{{--    <div class="sm:pt-10 bg-gray-100 pb-40 box">--}}
        {{--    <div class="min-h-screen flex flex-col items-center sm:pt-10 bg-gray-100 pb-40">--}}
        <form method="{{ $productLog ? 'PUT' : 'POST' }}"
              action="{{ $productLog ? route('product-logs.update', $productLog) : route('product-logs.store') }}">
            @csrf
            <div class="flex flex-row justify-around">
                <div class="flex flex-col w-2/5">
                    <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg me">
                        <div class="text-center mb-6 mt-4">
                            <i class="fa-5x fas fa-syringe text-gray-500"></i>
                        </div>
                        <h3 class="text-center">Insulina</h3>
                        <input type="time" name="insulin_hour" min="00:00" max="23:59"
                               class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                               style="width:100%;"/>
                        <div class="mt-4">
                            <x-bladewind::select
                                name="insulin_id"
                                required="true"
                                :data="$insulins"
                                label="Nazwa insuliny"
                                label_key="name"
                                value_key="id"
                                selected-value="{{ $productLog->insulin ?? null }}">
                            </x-bladewind::select>
                        </div>
                        <div class="mt-4">
                            <x-bladewind::input
                                numeric="true"
                                label="Liczba jednostek"
                                name="quantity"
                                required="true"
                                class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
                        </div>
                    </div>
                    <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg me">
                        <div class="text-center mb-6 mt-4">
                            <i class="fa-5x fa-solid fa-droplet text-gray-500"></i>
                        </div>
                        <h3 class="text-center">Poziomy cukru</h3>
                        <input type="time" name="sugar_before_hour" min="00:00" max="23:59"
                               class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                               style="width:100%;"/>
                        <div class="mt-4">
                            <x-bladewind::input
                                numeric="true"
                                label="Poziom cukru przed posiłkiem"
                                name="sugar_before"
                                required="true"
                                class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
                        </div>
                        <input type="time" name="sugar_after_hour" min="00:00" max="23:59"
                               class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                               style="width:100%;"/>
                        <div class="mt-4">
                            <x-bladewind::input
                                numeric="true"
                                label="Poziom cukru po posiłku"
                                name="sugar_after"
                                required="true"
                                class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
                        </div>
                    </div>
                </div>
                <div class=" w-2/5">
                <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <div class="text-center mb-6 mt-4">
                        <i class="fa-5x fa-solid fa-utensils text-gray-500"></i>
                    </div>
                    <h3 class="text-center">Posiłek</h3>
                    <div class="mt-4">
                        <x-bladewind::datepicker
                            label="Data"
                            name="product_log_date"
                            required="true"
                            format="dd-mm-yyyy"
                            class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
                    </div>
                    <input type="time" name="product_log_hour" min="00:00" max="23:59"
                           class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50" style="width:100%;"/>
                    <div class="mt-4">
                        <x-bladewind::select
                            name="product_id"
                            required="true"
                            :data="$products"
                            label="Danie/produkt"
                            label_key="name"
                            value_key="id"
                            searchable="true">
                        </x-bladewind::select>
                    </div>
                    <div class="mt-4">
                        <x-bladewind::input
                            numeric="true"
                            label="Gramy"
                            name="grams"
                            required="true"
                            class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
                    </div>
                    @include('system.nutritional_value.form')
                    <x-bladewind::textarea label="Komentarze" name="comment"/>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Zapisz') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
            </div>
        </form>
{{--    </div>--}}
    </body>
@endsection
