@extends('layouts.admin')

@section('title', 'Rooms Management')

@extends('components.hotel-admin-sidebar')

@section('content')
<div class="space-y-8">
    <div class="flex justify-end mb-8">
        <x-primary-button onclick="openModal('CreateRoomModal')">
            + Add Rooms
        </x-primary-button>
    </div>

    <!-- Create Room Modal -->
    <x-create-modal id="CreateRoomModal" title="Create Rooms"
        action="{{ route('hotelAdmin.room.store', $roomType->id) }}" buttonName="Create Rooms" :fields="[
            ['name' => 'floor', 'label' => 'Floor', 'type' => 'number'],
            ['name' => 'nbrOfRooms', 'label' => 'Number of Rooms', 'type' => 'number'],
            ['name' => 'startingRoomNbr', 'label' => 'Starting Room Number', 'type' => 'number'],
        ]" />

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Rooms Table -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">
            <b>Rooms - {{ $roomType->type }}</b>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-3 px-4 text-center">Room Number</th>
                        <th class="py-3 px-4 text-center">Floor</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rooms as $room)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center font-medium">
                            {{ $room->room_number }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ $room->floor }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($room->status === 'available') bg-green-100 text-green-700
                                @elseif($room->status === 'occupied') bg-red-100 text-red-700
                                @elseif($room->status === 'maintenance') bg-yellow-100 text-yellow-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>

                        <td class="py-3 px-4 flex justify-center gap-2">
                            <!-- Edit -->
                            <x-primary-button type="button" class="editRoomBtn" data-id="{{ $room->id }}"
                                data-room_number="{{ $room->room_number }}" data-floor="{{ $room->floor }}"
                                data-status="{{ $room->status }}">
                                Edit
                            </x-primary-button>

                            <!-- Delete -->
                            <x-danger-button onclick="openModal('deleteRoomModal-{{ $room->id }}')">
                                Delete
                            </x-danger-button>

                            <x-confirm-delete-modal id="deleteRoomModal-{{ $room->id }}" title="Delete Room"
                                method="DELETE" message="Are you sure you want to delete room {{ $room->room_number }}?"
                                route="{{ route('hotelAdmin.room.delete', [$roomType->id, $room->id]) }}" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">
                            No rooms found. Click "Add Rooms" to create rooms.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Edit Room Modal -->
    <x-edit-modal id="editRoomModal" title="Edit Room" :fields="[
            ['name' => 'room_number', 'label' => 'Room Number', 'type' => 'number'],
            ['name' => 'floor', 'label' => 'Floor', 'type' => 'number'],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [
                'available' => 'Available',
                'occupied' => 'Occupied',
                'maintenance' => 'Maintenance',
                'cleaning' => 'Cleaning'
            ]],
        ]" />

</div>
@if($errors->any() && request()->route('room'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('editRoomModal');

    const roomTypeId = {{ $roomType->id }};
    const roomId = '{{ request()->route('room')->id ?? request()->route('room') }}';

    const form = modal.querySelector('form');

    // Restore correct action
    form.action = `/hotelAdmin/roomTypes/${roomTypeId}/rooms/${roomId}/edit`;

    // Restore old values
    modal.querySelector('#editRoomModal_room_number').value = '{{ old('room_number') }}';
    modal.querySelector('#editRoomModal_floor').value = '{{ old('floor') }}';
    modal.querySelector('#editRoomModal_status').value = '{{ old('status') }}';

    openModal('editRoomModal');
});
</script>
@endif
<script>
    // Edit Room Modal
    document.querySelectorAll('.editRoomBtn').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = 'editRoomModal';
            const modal = document.getElementById(modalId);

            // Set form action
            const roomId = button.getAttribute('data-id');
            const roomTypeId = {{ $roomType->id }};
            const form = modal.querySelector('form');
            form.action = `/hotelAdmin/roomTypes/${roomTypeId}/rooms/${roomId}/edit`;

            modal.querySelector('#' + modalId + '_entity_id').value = roomId;
            // Populate fields
            modal.querySelector('#' + modalId + '_room_number').value = button.getAttribute('data-room_number');
            modal.querySelector('#' + modalId + '_floor').value = button.getAttribute('data-floor');
            modal.querySelector('#' + modalId + '_status').value = button.getAttribute('data-status');

            openModal(modalId);
        });
    });
    // Re-open modal with old values if validation errors exist
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            @if(old('nbrOfRooms'))
                // Re-open Create Modal with old values
                const createModal = document.getElementById('CreateRoomModal');
                if (createModal) {
                    createModal.querySelector('#CreateRoomModal_floor').value = '{{ old('floor') }}';
                    createModal.querySelector('#CreateRoomModal_nbrOfRooms').value = '{{ old('nbrOfRooms') }}';
                    createModal.querySelector('#CreateRoomModal_startingRoomNbr').value = '{{ old('startingRoomNbr') }}';
                    openModal('CreateRoomModal');
                }
            @elseif(old('room_number'))
                // Re-open Edit Modal with old values
                const editModal = document.getElementById('editRoomModal');
                if (editModal) {
                    const roomTypeId = {{ $roomType->id }};
                    const form = editModal.querySelector('form');
                    
                    // You need to store the room ID somehow - use a hidden field or URL parsing
                    // For now, we'll extract it from the form action if it exists
                    const actionParts = form.action.split('/');
                    const roomId = '{{ old('editRoomModal_entity_id') }}';
                    
                    form.action = `/hotelAdmin/roomTypes/${roomTypeId}/rooms/${roomId}/edit`;
                    
                    editModal.querySelector('#editRoomModal_room_number').value = '{{ old('room_number') }}';
                    editModal.querySelector('#editRoomModal_floor').value = '{{ old('floor') }}';
                    editModal.querySelector('#editRoomModal_status').value = '{{ old('status') }}';
                    
                    openModal('editRoomModal');
                }
            @endif
        });
    @endif
</script>
@endsection