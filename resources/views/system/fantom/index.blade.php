@extends('layouts.app')

@section('title', 'Miejsca wkłucia')
@section('header', 'Miejsca wkłucia')
@section('addButton')

@endsection

@push('scripts')
    <script>
        let pointsData = [];
        function onFantomClick(event) {
            let color =  document.getElementById('color').value;
            const pin = document.createElement("div");
            pin.classList.add("pin");
            pin.setAttribute("style", `top: ${event.offsetY}px; left: ${event.offsetX}px;`)
            pointsData.push({'coord_x' : event.offsetX, 'coord_y' : event.offsetY, 'color' : color});
            document.getElementById("fantom-container").appendChild(pin);
        }

        document.addEventListener("submit", function(event) {
            document.getElementById('points_data').value = JSON.stringify(pointsData);
        });

        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("fantom").addEventListener("click", onFantomClick);
        })

        deleteFantomPoint = (id, name) => {
            showModal('delete-fantom-point');
            domEl('.bw-delete-fantom-point').id = `${id}`;
        }

        notify = (title, message, type, dismiss_in) => {
            showNotification(title, message, type, dismiss_in)
        };

        deleteFantomPointAjax = () => {
            let id =  domEl('.bw-delete-fantom-point').getAttribute('id');
            $.ajax({
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('fantom-point.destroy', '') }}/${id}`,
                success: function(response) {
                    notify('Powodzenie', 'Pomyślnie usunięto element.', 'success', 2);
                    $(`tr[data-id="${id}"]`).remove();
                },
                error: function(xhr, status, error) {
                    notify('Błąd', 'Wystąpił błąd przy usuwaniu.', 'error', 2);
                }
            });
        }

        redirect = (url) => {
            window.open(url);
        }
    </script>
@endpush

@push('styles')
    <style>
        #fantom-container {
            position: relative;
            display: inline-block;
            min-width: max-content;
        }

        #fantom {
            display: block;
        }

        .point {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .pin {
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: red;
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
    <body class="font-sans text-gray-900 antialiased">
    <div class="flex flex-row justify-around">
        <div class="flex" id="fantom-container">
            <img src="human.svg" draggable="false" alt="Human" id="fantom">
        </div>
        <div class="flex" style="margin-top: 20px">
            <div class="">
                <x-bladewind.table
                    searchable="true"
                    :data="$pointsHistory"
                    search_placeholder="Wpisz nazwę, żeby wyszukać..."
                    :action_icons="$actionIcons"
                    :column_aliases="$columnAliases"
                    no_data_message="Nie dodałeś jeszcze żadnego miejsca wkłucia."
                    exclude_columns="id"
                    actions_title="Akcje">
                </x-bladewind.table>
                <x-bladewind.modal
                    name="delete-fantom-point"
                    type="error" title="Potwierdzenie"
                    cancel_button_label="Anuluj"
                    ok_button_label="Tak"
                    ok_button_action="deleteFantomPointAjax()"
                    cancel_button_action="close"
                    blur_size="small">
                    Czy na pewno chcesz usunąć to miejsce wkłucia?
                    Tej akcji nie można cofnąć.
                </x-bladewind.modal>
                <x-bladewind::notification />
            </div>
        </div>
        <form class="flex" method="{{ 'POST' }}"
                  action="{{ route('fantom.store-points') }}">
                @csrf
            <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg me">
                <div class="text-center mb-6 mt-4">
                    <i class="fa-5x fa-solid fa-arrow-pointer text-gray-500"></i>
                </div>
                <h3 class="text-center">Dodawanie</h3>
                <div class="mt-4">
                    <input type="color" id="color" name="color" value="#e66465" />
                    <label for="head">Kolor</label>
                </div>
                <div class="mt-4">
                    <x-bladewind::datepicker
                        label="Data"
                        name="date"
                        required="true"
                        format="dd-mm-yyyy"
                        class="rounded-md bg-white text-slate-600 border-2 border-slate-300/50"/>
                </div>
                <input type="hidden" name="points_data" id="points_data">
                <x-bladewind::textarea label="Opis" name="description"/>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Zapisz') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
    <script>
        var jsData = @json($fantomPoints);
        function markPoints(data) {
            var container = document.getElementById("fantom-container");
            data.forEach(function(item) {
                var point = document.createElement('div');
                point.className = 'point';
                point.style.left = item.coord_x + 'px';
                point.style.top = item.coord_y + 'px';
                point.style.backgroundColor = item.color;
                container.appendChild(point);
            });
        }

        window.onload = function() {
            markPoints(jsData);
        };
    </script>
    </body>
@endsection
