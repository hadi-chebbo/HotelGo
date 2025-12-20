@extends('layouts.admin')

@section('title', 'Room Types Management')

@extends('components.hotel-admin-sidebar')

@section('content')
<div class="space-y-8">

    <!-- Add Button -->
    <div class="flex justify-end mb-8">
        <x-primary-button onclick="openModal('CreateRoomTypeModal')">
            + Add Room Type
        </x-primary-button>
    </div>

    <!-- Create Room Type Modal -->
    <x-create-modal id="CreateRoomTypeModal" title="Create Room Type"
        action="{{ route('hotelAdmin.room_types.store') }}" buttonName="Create Room Type" :fields="[
            ['name' => 'type', 'label' => 'Room Type', 'type' => 'text'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            ['name' => 'price_per_night', 'label' => 'Price per Night', 'type' => 'number', 'step' => '0.01'],
            ['name' => 'capacity', 'label' => 'Capacity', 'type' => 'number'],
            ['name' => 'image', 'label' => 'Room Image', 'type' => 'file'],
        ]" />

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal"
        class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4"
        onclick="closeImagePreview()">
        <div class="relative max-w-4xl max-h-full">
            <img id="previewImage" src="" alt="" class="max-w-full max-h-screen rounded-lg shadow-2xl">
            <button onclick="closeImagePreview()"
                class="absolute top-4 right-4 bg-white text-gray-800 rounded-full p-2 hover:bg-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Room Types Table -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">
            <b>Room Types</b>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-3 px-4 text-center">Type</th>
                        <th class="py-3 px-4 text-center">Description</th>
                        <th class="py-3 px-4 text-center">Price / Night</th>
                        <th class="py-3 px-4 text-center">Capacity</th>
                        <th class="py-3 px-4 text-center">Image</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($roomTypes as $roomType)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center font-medium">
                            <a href="{{ route('hotelAdmin.room.index', $roomType->id) }}"
                                class=" hover:text-blue-800 hover:underline transition">
                                {{ $roomType->type }}
                            </a>
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ $roomType->description }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            ${{ number_format($roomType->price_per_night, 2) }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ $roomType->capacity }}
                        </td>

                        <!-- Image Column with Click to Preview -->
                        <td class="py-3 px-4 text-center">
                            @if($roomType->image)
                            <img src="{{ asset('storage/' . $roomType->image) }}" alt="{{ $roomType->type }}"
                                class="w-16 h-16 object-cover rounded-lg mx-auto shadow-sm cursor-pointer hover:opacity-80 transition-opacity"
                                onclick="showImagePreview('{{ asset('storage/' . $roomType->image) }}', '{{ $roomType->type }}')">
                            @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
                                <span class="text-gray-400 text-xs">No Image</span>
                            </div>
                            @endif
                        </td>

                        <td class="py-3 px-4 flex justify-center gap-2">
                            <!-- Edit -->
                            <x-primary-button type="button" class="editRoomTypeBtn" data-id="{{ $roomType->id }}"
                                data-type="{{ $roomType->type }}" data-description="{{ $roomType->description }}"
                                data-price_per_night="{{ $roomType->price_per_night }}"
                                data-capacity="{{ $roomType->capacity }}" data-image="{{ $roomType->image }}">
                                Edit
                            </x-primary-button>

                            <!-- Delete -->
                            <x-danger-button onclick="openModal('deleteRoomTypeModal-{{ $roomType->id }}')">
                                Delete
                            </x-danger-button>

                            <x-confirm-delete-modal id="deleteRoomTypeModal-{{ $roomType->id }}"
                                title="Delete Room Type" method="DELETE"
                                message="Are you sure you want to delete {{ $roomType->type }}?"
                                route="{{ route('hotelAdmin.room_types.delete', $roomType->id) }}" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-edit-modal id="editRoomTypeModal" title="Edit Room Type" :fields="[
            ['name' => 'type', 'label' => 'Room Type', 'type' => 'text'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            ['name' => 'price_per_night', 'label' => 'Price per Night', 'type' => 'number', 'step' => '0.01'],
            ['name' => 'capacity', 'label' => 'Capacity', 'type' => 'number'],
            ['name' => 'image', 'label' => 'Room Image', 'type' => 'file'],
        ]" />

</div>

<script>
    // Image Preview Functions
    function showImagePreview(imageSrc, altText) {
        const modal = document.getElementById('imagePreviewModal');
        const previewImage = document.getElementById('previewImage');
        previewImage.src = imageSrc;
        previewImage.alt = altText;
        modal.classList.remove('hidden');
    }

    function closeImagePreview() {
        const modal = document.getElementById('imagePreviewModal');
        modal.classList.add('hidden');
    }

    // Edit Room Type Modal
    document.querySelectorAll('.editRoomTypeBtn').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = 'editRoomTypeModal';
            const modal = document.getElementById(modalId);

            // Set form action
            const roomTypeId = button.getAttribute('data-id');
            const form = modal.querySelector('form');
            form.action = `/hotelAdmin/roomTypes/${roomTypeId}/edit`;

            // Populate fields
            modal.querySelector('#' + modalId + '_type').value = button.getAttribute('data-type');
            modal.querySelector('#' + modalId + '_description').value = button.getAttribute('data-description');
            modal.querySelector('#' + modalId + '_price_per_night').value = button.getAttribute('data-price_per_night');
            modal.querySelector('#' + modalId + '_capacity').value = button.getAttribute('data-capacity');

            openModal(modalId);
        });
    });
</script>
@endsection