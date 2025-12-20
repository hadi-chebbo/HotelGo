@props(['hotel'])

<div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition flex flex-col">
    <!-- Hotel Image -->
    <div class="w-full h-48 bg-gray-200 overflow-hidden">
        @if($hotel->image)
            <img 
                src="{{ asset('storage/' . $hotel->image) }}" 
                alt="{{ $hotel->name }}"
                class="w-full h-full object-cover"
            >
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                <svg class="w-20 h-20 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        @endif
    </div>

    <!-- Hotel Content -->
    <div class="p-4 flex flex-col flex-grow">
        <!-- Hotel basic info -->
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold text-blue-900">{{ $hotel->name }}</h3>
            <span class="text-gray-500 text-sm">⭐ {{ $hotel->rating ?? 'N/A' }} / 5</span>
        </div>

        <p class="text-gray-600 mt-1">{{ $hotel->location }}</p>
        <p class="text-gray-600 mt-1">Email: {{ $hotel->email }}</p>
        
        <!-- Hotel admin info -->
        <div class="mt-2 text-gray-700 text-sm mb-2">
            <p>Admin: {{ $hotel->user->name ?? 'N/A' }}</p>
            <p>Admin Email: {{ $hotel->user->email ?? 'N/A' }}</p>
            <p>Admin Phone: {{ $hotel->user->phone ?? 'N/A' }}</p>
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
                data-image="{{ $hotel->image ?? '' }}"
            >
                Edit
            </x-primary-button>

            <x-confirm-delete-modal 
                id="deleteHotelModal-{{ $hotel->id }}" 
                route="{{ route('admin.hotel.delete', $hotel->id) }}" 
                title="Delete Hotel"
                method="DELETE"
                message="Are you sure you want to delete {{ $hotel->name }}?"
            />

            <x-danger-button type="button" onclick="openModal('deleteHotelModal-{{ $hotel->id }}')">
                Delete
            </x-danger-button>
        </div>
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
        ['name' => 'image', 'label' => 'Hotel Image', 'type' => 'file', 'accept' => 'image/*'],
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
                admin_phone: this.dataset.admin_phone,
                image: this.dataset.image
            };
            
            const action = `/admin/hotels/${hotelId}/edit`;
            
            openModal(modalId, data, action);
        });
    });
</script>