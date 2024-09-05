@extends('layouts.app')

@section('title', 'Podgląd wpisu w historii')
@section('header', 'Podgląd wpisu w historii')
@section('addButton')

@endsection

@section('content')
<x-bladewind::card compact="true">
        <div class="mt-6 grid grid-cols-1 gap-3">
            <div>
                <h2 class="text-center text-bold mb-5">
                    <b>
                        Posiłek {{ $productLog->created_at->format(config('app.date_format')) . ' o ' . $productLog->hour }}
                    </b>
                    @if ($productLog->successful)
                        <i class="fa-solid fa-star"></i>
                    @else
                        <x-bladewind::button tag="a" href="{{ route('product-log.mark-successful', $productLog->id)}}">Zaznacz jako udany</x-bladewind::button>
                    @endif
                </h2>
                <div class="flex-row flex justify-around text-center">
                    <div class="flex flex-col">
                        <div class="text-center mb-6 mt-4">
                            <i class="fa-2x fas fa-syringe text-gray-500"></i>
                        </div>
                        <div class="grow pl-2 pt-1">
                            <div>
                                <div style="display: flex; flex-direction: column">
                                    <div class="text-sm"><b>Insulina:</b></div>
                                    <div class="text-sm">{{ $productLog->insulinLog->quantity . ' jednostek'  . ' ( ' . $productLog->insulinLog->insulin->name  . ')' }}</div>
                                    <div class="text-sm">{{ $productLog->insulinLog->hour }} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-center mb-6 mt-4">
                            <i class="fa-2x fas fa-syringe text-gray-500"></i>
                        </div>
                        <div class="grow pl-2 pt-1">
                            <div>
                                <div style="display: flex; flex-direction: column">
                                    <div class="text-sm"><b>{{ 'Poziom cukru:' }}</b></div>
                                    <div class="text-sm">{{ $productLog->sugarBefore->level . '->' .  $productLog->sugarAfter->level }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-center mb-6 mt-4">
                            <i class="fa-2x fas fa-utensils text-gray-500"></i>
                        </div>
                        <div class="grow pl-2 pt-1">
                            <div>
                                <div style="display: flex; justify-content: space-between; flex-direction: column">
                                    <b>{{ $productLog->product->name . ' (' . $productLog->grams . 'g, ' . round(($productLog->carbohydrates / 10), 1) . ' WW)' }}</b>
                                    <p>Węglowodany: {{ $productLog->carbohydrates }}</p>
                                    <p>Białko: {{ $productLog->proteins }}</p>
                                    <p>Tłuszcz: {{ $productLog->fats }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-bladewind::card>
@endsection
