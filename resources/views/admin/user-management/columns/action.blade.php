<div class="lg:flex gap-x-2">
    @if ($is_active)
        <x-link-button route="{{route('admin.user-management.deactivate', $id)}}" color="red">
            Nonaktifkan
        </x-link-button>
    @else
        <x-link-button route="{{route('admin.user-management.activate', $id)}}" class="bg-primary">
            Aktifkan
        </x-link-button>
    @endif
</div>
