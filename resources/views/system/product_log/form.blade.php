@extends('layouts.app')

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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="grams"]').addEventListener('input', function() {
                let grams = this.value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ route('product-log.calculate-nutrition-value') }}`,
                    method: 'POST',
                    data: {
                        productId: $('input[name="product_id"]').val(),
                        grams: grams
                    },
                    success: function(response) {
                        $('input[name="carbohydrates"]').val(response.carbohydrates);
                        $('input[name="proteins"]').val(response.proteins);
                        $('input[name="fats"]').val(response.fats);
                    },
                });
            });
        });
    </script>
@endpush

@section('title', 'Dodawanie wpisu do historii')
@section('header', 'Dodawanie wpisu do historii')
@section('addButton')

@endsection

@section('content')
    <body class="font-sans text-gray-900 antialiased">
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
                        <input type="time" name="insulin_hour" min="00:00" max="23:59" class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                               style="width:100%;" value="{{ $productLog ? $productLog->insulinLog->hour : null }}"/>
                        <div class="mt-4">
                            <x-bladewind::select
                                name="insulin_id"
                                required="true"
                                :data="$insulins"
                                label="Nazwa insuliny"
                                label_key="name"
                                value_key="id"
                                selected-value="{{ $productLog ? $productLog->insulinLog->insulin_id : null }}">
                            </x-bladewind::select>
                        </div>
                        <div class="mt-4">
                            <x-bladewind::input
                                numeric="true"
                                label="Liczba jednostek"
                                name="quantity"
                                required="true"
                                class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                                value="{{ $productLog ? $productLog->insulinLog->quantity : null }}"/>
                        </div>
                    </div>
                    <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg me">
                        <div class="text-center mb-6 mt-4">
                            <i class="fa-5x fa-solid fa-droplet text-gray-500"></i>
                        </div>
                        <h3 class="text-center">Poziomy cukru</h3>
                        <input type="time" name="sugar_before_hour" min="00:00" max="23:59"
                               class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                               style="width:100%;" value="{{ $productLog ? $productLog->sugarBefore?->hour : null }}"/>
                        <div class="mt-4">
                            <x-bladewind::input
                                numeric="true"
                                label="Poziom cukru przed posiłkiem"
                                name="sugar_before"
                                required="true"
                                class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                                value="{{ $productLog ? $productLog->sugarBefore?->level : null }}"/>
                        </div>
                        <input type="time" name="sugar_after_hour" min="00:00" max="23:59"
                               class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                               style="width:100%;" value="{{ $productLog ? $productLog->sugarAfter?->hour : null }}"/>
                        <div class="mt-4">
                            <x-bladewind::input
                                numeric="true"
                                label="Poziom cukru po posiłku"
                                name="sugar_after"
                                required="true"
                                class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                                value="{{ $productLog ? $productLog->sugarAfter?->level : null }}"/>
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
                            class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                            default-date="{{ $productLog ? $productLog->date->format(config('app.date_format')) : null }}"/>
                    </div>
{{--                    @php dd($productLog->value);@endphp--}}
                    <input type="time" name="product_log_hour" min="00:00" max="23:59" class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50" style="width:100%;" value="{{ $productLog->hour ?? null }}"/>
                    <div class="mt-4">
                        <x-bladewind::select
                            name="product_id"
                            required="true"
                            :data="$products"
                            label="Danie/produkt"
                            label_key="name"
                            value_key="id"
                            searchable="true"
                            selected-value="{{ $productLog ? $productLog->product->id : null }}">
                        </x-bladewind::select>
                    </div>
                    <div class="mt-4">
                        <x-bladewind::input
                            numeric="true"
                            label="Gramy"
                            name="grams"
                            required="true"
                            class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"
                            value="{{ $productLog->grams ?? null }}"
                        />
                    </div>
                    @include('system.nutritional_value.form', [
                    'carbohydrates' => $productLog ? $productLog->carbohydrates : null,
                    'proteins' => $productLog ? $productLog->proteins : null,
                    'fats' => $productLog ? $productLog->fats : null
                    ])
                    <x-bladewind::textarea label="Komentarze" name="comment" selected_value="{{ $productLog->comment ?? null }}"/>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Zapisz') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </body>
@endsection
