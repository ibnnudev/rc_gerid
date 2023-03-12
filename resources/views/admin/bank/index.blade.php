<x-app-layout>
    <x-breadcrumbs name="bank" />
    <h1 class="font-semibold text-xl my-8">Bank Data</h1>

    <x-card-container>
        <div class="text-end">
            <x-link-button route="{{route('admin.bank.create')}}" color="gray">
                Tambah Bank Data
            </x-link-button>
        </div>
    </x-card-container>
@push('js-internal')
    <script>

    </script>
@endpush
</x-app-layout>
