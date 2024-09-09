@extends('layouts.app')

@push('scripts')
    <script>
        deleteInsulin = (id, name) => {
            showModal('delete-insulin');
            domEl('.bw-delete-insulin .title').innerText = `${name}`;
            domEl('.bw-delete-insulin').id = `${id}`;
        }

        editInsulin = (id) => {
            window.open(`{{ route('insulin.edit', '') }}/${id}`);
        }

        notify = (title, message, type, dismiss_in) => {
            showNotification(title, message, type, dismiss_in)
        };

        deleteInsulinAjax = () => {
            let id =  domEl('.bw-delete-insulin').getAttribute('id');
            $.ajax({
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('insulin.destroy', '') }}/${id}`,
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

@section('title', 'Moja insulina')
@section('header', 'Moja insulina')
@section('addButton')
    <x-bladewind::button tag="a" href="{{ route('insulins.create') }}">Dodaj</x-bladewind::button>
@endsection

@section('content')

    <div style="width: 80%; margin-left:10%;" class="mt-6">
        <x-bladewind.table
            searchable="true"
            :data="$insulins"
            search_placeholder="Wpisz nazwę, żeby wyszukać..."
            :action_icons="$actionIcons"
            :column_aliases="$columnAliases"
            no_data_message="Nie dodałeś jeszcze żadnej insuliny."
            exclude_columns="id"
            actions_title="Akcje">
        </x-bladewind.table>
        <x-bladewind.modal
            name="delete-insulin"
            type="error" title="Potwierdzenie"
            cancel_button_label="Anuluj"
            ok_button_label="Tak"
            ok_button_action="deleteInsulinAjax()"
            cancel_button_action="close"
            blur_size="small">
            Czy na pewno chcesz usunąć insulinę <b class="title"></b>?
            Tej akcji nie można cofnąć.
        </x-bladewind.modal>
        <x-bladewind::notification />
    </div>
@endsection
