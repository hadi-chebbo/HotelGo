@extends('layouts.admin')

@section('title', 'All Hotels')

@section('content')
<div class="flex items-center justify-between mb-10">
    <h1 class="text-2xl font-bold">All Hotels</h1>
    <x-primary-button onclick="openModal('CreateHotelModal')">Create</x-primary-button>
</div>
<!-- Create Modal Component -->
    <x-create-modal
        id="CreateHotelModal"
        title="Create Hotel"
        action="{{ route('admin.hotel.store') }}"
        :fields="[
            ['name' => 'name', 'label' => 'Hotel Name', 'type' => 'text'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'text'],
            ['name' => 'location', 'label' => 'Location', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'social_links', 'label' => 'Social Links', 'type' => 'textarea'],
            ['name' => 'admin_phone', 'label' => 'Admin Phone', 'type' => 'text'],
            ['name' => 'image', 'label' => 'Hotel Image', 'type' => 'file'],
        ]"
    />
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($hotels as $hotel)
        <x-system-hotel-card :hotel="$hotel" />
    @endforeach
</div>
@endsection
