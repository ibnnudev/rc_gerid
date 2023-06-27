@if ($user->is_active)
    <a href="{{ route('admin.user-management.edit', $user->id) }}"
        class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
        <i class="fas fa-edit"></i>
    </a>
@endif
