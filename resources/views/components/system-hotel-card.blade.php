@props(['hotel'])

<div class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition flex flex-col">
    <!-- Hotel basic info -->
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold text-blue-900">{{ $hotel->name }}</h3>
        <span class="text-gray-500 text-sm">⭐ {{ $hotel->rating ?? 'N/A' }} / 5</span>
    </div>

    <p class="text-gray-600 mt-1">{{ $hotel->location }}</p>

    <!-- Hotel admin info -->
    <div class="mt-2 text-gray-700 text-sm mb-2">
        <p>Admin: {{ $hotel->user->name ?? 'N/A' }}</p>
        <p>Email: {{ $hotel->user->email ?? 'N/A' }}</p>
    </div>

    <!-- Admin actions -->
    <div class="flex gap-2 mt-auto">
        <!-- Edit Button -->
        <x-primary-button
            type="button"
            class="editHotelBtn"
            data-id="{{ $hotel->id }}"
            data-name="{{ $hotel->name }}"
            data-location="{{ $hotel->location }}"
            data-rating="{{ $hotel->rating ?? 0 }}"
            data-email="{{ $hotel->email }}"
            data-social_links="{{ is_array($hotel->social_links) ? implode(',', $hotel->social_links) : ($hotel->social_links ?? '') }}"
            data-admin_phone="{{ $hotel->user?->phone ?? '' }}"
        >
            Edit
        </x-primary-button>

        <x-confirm-delete-modal 
            id="deleteHotelModal-{{ $hotel->id }}" 
            route="{{ route('admin.hotel.delete', $hotel->id) }}" 
            title="Delete Hotel"
            message="Are you sure you want to delete {{ $hotel->name }}?"
        />

        <x-danger-button type="button" onclick="openModal('deleteHotelModal-{{ $hotel->id }}')">
            Delete
        </x-danger-button>
    </div>
</div>

<!-- Edit Modal -->
<x-edit-modal 
    id="editHotelModal-{{ $hotel->id }}"
    title="Edit Hotel"
    :fields="[
        ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
        ['name' => 'location', 'label' => 'Location', 'type' => 'text'],
        ['name' => 'rating', 'label' => 'Rating', 'type' => 'number', 'min' => 0, 'max' => 5, 'step' => 0.1],
        ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
        ['name' => 'social_links', 'label' => 'Social Links', 'type' => 'textarea'],
        ['name' => 'admin_phone', 'label' => 'Admin Phone', 'type' => 'text'],
    ]"
/>

<script>
    document.querySelectorAll('.editHotelBtn').forEach(button => {
        button.addEventListener('click', function() {
            const hotelId = this.dataset.id;
            const modalId = `editHotelModal-${hotelId}`;
            
            const data = {
                name: this.dataset.name,
                location: this.dataset.location,
                rating: this.dataset.rating,
                email: this.dataset.email,
                social_links: this.dataset.social_links ? this.dataset.social_links.split(',').join("\n") : '',
                admin_phone: this.dataset.admin_phone
            };
            
            const action = `/admin/hotels/${hotelId}/edit`;
            
            openModal(modalId, data, action);
        });
    });
</script>
