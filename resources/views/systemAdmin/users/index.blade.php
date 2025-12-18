@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')

<div class="space-y-8">

    <!-- Scroll Buttons -->
    <div class="flex space-x-4 mb-6">
        <button onclick="document.getElementById('active-users').scrollIntoView({ behavior: 'smooth' })"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Go to Active Users
        </button>
        <button onclick="document.getElementById('blocked-users').scrollIntoView({ behavior: 'smooth' })"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Go to Blocked Users
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Active Users Table -->
    <div id="active-users" class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4"><b>Active Users</b></h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="text-left py-3 px-4">Name</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4">Status</th>
                        <th class="text-left py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users->where('role', 0)->where('blocked', 0) as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-600">Active</span>
                            </td>
                            <td class="py-3 px-4 flex space-x-2">

                                <!-- Edit Button -->
                                <x-primary-button onclick="openModal('edit-user-{{ $user->id }}' )" >
                                    Edit
                                </x-primary-button>

                                <!-- Edit Modal -->
                                <x-edit-modal
                                    id="edit-user-{{ $user->id }}"
                                    title="Edit User"
                                    :fields="[
                                        ['label' => 'Name', 'name' => 'name', 'value' => $user->name, 'type' => 'text'],
                                        ['label' => 'Email', 'name' => 'email', 'value' => $user->email, 'type' => 'email'],
                                        ['label' => 'Phone', 'name' => 'phone', 'value' => $user->phone ?? '', 'type' => 'text'],
                                    ]"
                                    :route="route('admin.users.update', $user->id)"
                                />

                                <!-- Block Button -->
                                <x-danger-button onclick="openModal('block-user-{{ $user->id }}')">
                                    Block
                                </x-danger-button>

                                <!-- Block Modal -->
                                <x-confirm-delete-modal
                                    id="block-user-{{ $user->id }}"
                                    title="Block User"
                                    message="This user will be permanently blocked and will no longer access the system."
                                    :route="route('admin.users.block', $user->id)"
                                    method="POST"
                                    confirm="Block"
                                />

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Blocked Users Table -->
    <div id="blocked-users" class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4"><b>Blocked Users</b></h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="text-left py-3 px-4">Name</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4">Status</th>
                        <th class="text-left py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users->where('role', 0)->where('blocked', 1) as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-600">Blocked</span>
                            </td>
                            <td class="py-3 px-4 flex space-x-2">

                                <!-- Edit Button -->
                                <x-primary-button onclick="openModal('edit-user-{{ $user->id }}')">
                                    Edit
                                </x-primary-button>

                                <!-- Edit Modal -->
                                <x-edit-modal
                                    id="edit-user-{{ $user->id }}"
                                    title="Edit User"
                                    :fields="[
                                        ['label' => 'Name', 'name' => 'name', 'value' => $user->name, 'type' => 'text'],
                                        ['label' => 'Email', 'name' => 'email', 'value' => $user->email, 'type' => 'email'],
                                        ['label' => 'Phone', 'name' => 'phone', 'value' => $user->phone ?? '', 'type' => 'text'],
                                    ]"
                                    :route="route('admin.users.update', $user->id)"
                                />

                                <!-- Unblock Button -->
                                <x-primary-button class="bg-green-600 hover:bg-green-700"
                                    onclick="openModal('block-user-{{ $user->id }}')">
                                    Unblock
                                </x-primary-button>

                                <!-- Unblock Modal -->
                                <x-confirm-delete-modal
                                    id="block-user-{{ $user->id }}"
                                    title="Unblock User"
                                    message="This user will be unblocked and will regain access to the system."
                                    :route="route('admin.users.unblock', $user->id)"
                                    method="POST"
                                    confirm="Unblock"
                                />

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
