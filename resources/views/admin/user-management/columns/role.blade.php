<select onchange="changeRole(this.value, {{ $data->id }})"
    class="block w-full p-2 text-xs text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
    <option value="user" {{ $data->role == 'user' ? 'selected' : '' }}>User</option>
    <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
</select>
