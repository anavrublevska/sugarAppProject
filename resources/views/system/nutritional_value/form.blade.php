<div class="mt-4">
    <x-bladewind::input
        numeric="true"
        label="Węglowodany (g)"
        name="carbohydrates"
        with_dots="true"
        required="true"
        value="{{ $carbohydrates ?? null }}"
        class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
</div>
<div class="mt-4">
    <x-bladewind::input
        numeric="true"
        label="Białko (g)"
        name="proteins"
        with_dots="true"
        value="{{ $proteins ?? null }}"
        class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
</div>
<div class="mt-4">
    <x-bladewind::input
        numeric="true"
        label="Tłuszcz (g)"
        name="fats"
        with_dots="true"
        value="{{ $fats ?? null }}"
        class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
</div>
