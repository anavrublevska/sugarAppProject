@extends('layouts.app')

@push('scripts')
    <script>
        deleteProductLog = (id) => {
            showModal('delete-product-log');
            domEl('.bw-delete-product-log').id = `${id}`;
        }

        editProductLog = (id) => {
            window.open(`{{ route('product-log.edit', '') }}/${id}`);
        }

        showProductLog = (id) => {
            window.open(`{{ route('product-log.show', '') }}/${id}`);
        }

        notify = (title, message, type, dismiss_in) => {
            showNotification(title, message, type, dismiss_in)
        };

        deleteProductLogAjax = () => {
            let id =  domEl('.bw-delete-product-log').getAttribute('id');
            $.ajax({
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('product-logs.destroy', '') }}/${id}`,
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

@section('title', 'Historia')
@section('header', 'Historia')
@section('addButton')
    <x-bladewind::button tag="a" href="{{ route('product-logs.create') }}">Dodaj wpis</x-bladewind::button>
@endsection

@section('content')
    <div style="width: 80%; margin-left:10%;" class="mt-6">
        <x-bladewind.table
            searchable="true"
            :data="$productLogs"
            search_placeholder="Wpisz nazwę, żeby wyszukać..."
            :action_icons="$actionIcons"
            :column_aliases="$columnAliases"
            no_data_message="Nie dodałeś jeszcze żadnego wpisu."
            exclude_columns="id"
            actions_title="Akcje">
        </x-bladewind.table>
        <x-bladewind.modal
            name="delete-product-log"
            type="error" title="Potwierdzenie"
            cancel_button_label="Anuluj"
            ok_button_label="Tak"
            ok_button_action="deleteProductLogAjax()"
            cancel_button_action="close"
            blur_size="small">
            Czy na pewno chcesz usunąć ten wpis?
            Tej akcji nie można cofnąć.
        </x-bladewind.modal>
        <x-bladewind::notification />
    </div>
@endsection
