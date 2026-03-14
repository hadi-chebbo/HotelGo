@extends('layouts.admin')

@section('title', 'Promo Codes Management')

@extends('components.hotel-admin-sidebar')

@section('content')
<div class="space-y-8">
    <div class="flex justify-end mb-8">
        <x-primary-button onclick="openModal('CreatePromoCodeModal')">+ Add Promocode</x-primary-button>
    </div>


    <!-- Create Promo Code Modal Component -->
    <x-create-modal id="CreatePromoCodeModal" title="Create Promo Code"
        action="{{ route('hotelAdmin.promocode.store') }}" buttonName="Create PromoCode" :fields="[
        ['name' => 'code', 'label' => 'Promo Code', 'type' => 'text'],
        ['name' => 'discount_percentage', 'label' => 'Discount (%)', 'type' => 'number'],
        ['name' => 'start_date', 'label' => 'Valid From', 'type' => 'date'],
        ['name' => 'end_date', 'label' => 'Valid To', 'type' => 'date'],
        ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox'],
    ]" />


    <!-- Scroll Buttons -->
    <div class="flex space-x-4 mb-6">
        <button onclick="document.getElementById('active-promocodes').scrollIntoView({ behavior: 'smooth' })"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Go to Active Promo Codes
        </button>
        <button onclick="document.getElementById('expired-promocodes').scrollIntoView({ behavior: 'smooth' })"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Go to Expired Promo Codes
        </button>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif
    <!-- Active Promo Codes Table -->
    <div id="active-promocodes" class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4"><b>Active Promo Codes</b></h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="text-left py-3 px-4 text-center">Code</th>
                        <th class="text-left py-3 px-4 text-center">Discount %</th>
                        <th class="text-left py-3 px-4 text-center">Start Date</th>
                        <th class="text-left py-3 px-4 text-center">End Date</th>
                        <th class="text-left py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promocodes->where('is_active', 1) as $promo)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center">{{ $promo->code }}</td>
                        <td class="py-3 px-4 text-center">{{ $promo->discount_percentage }}%</td>
                        <td class="py-3 px-4 text-center">{{ $promo->start_date->format('Y-m-d') }}</td>
                        <td class="py-3 px-4 text-center">{{ $promo->end_date->format('Y-m-d') }}</td>
                        <td class="py-3 px-4 flex space-x-2">

                            <!-- Edit Button -->
                            <x-primary-button onclick="openModal('edit-promo-{{ $promo->id }}')">
                                Edit
                            </x-primary-button>

                            <!-- Edit Modal -->
                            <x-edit-modal id="edit-promo-{{ $promo->id }}" title="Edit Promo Code" :fields="[
                                        ['label' => 'Code', 'name' => 'code', 'value' => $promo->code, 'type' => 'text'],
                                        ['label' => 'Discount %', 'name' => 'discount_percentage', 'value' => $promo->discount_percentage, 'type' => 'number'],
                                        ['label' => 'Start Date', 'name' => 'start_date', 'value' => $promo->start_date->format('Y-m-d'), 'type' => 'date'],
                                        ['label' => 'End Date', 'name' => 'end_date', 'value' => $promo->end_date->format('Y-m-d'), 'type' => 'date'],
                                    ]" :route="route('hotelAdmin.promocode.update', $promo->id)" />

                            <x-danger-button class="bg-green-600 hover:bg-green-700"
                                onclick="openModal('deactivate-promo-{{ $promo->id }}')">
                                deactivate
                            </x-danger-button>
                            <x-confirm-delete-modal id="deactivate-promo-{{ $promo->id }}" title="Deactivate Promo Code"
                                message="This promo code will be DeActivated."
                                :route="route('hotelAdmin.promocode.deactivate', $promo->id)" method="PATCH"
                                confirm="Deactivate" />

                            <!-- Delete Button -->
                            <x-danger-button onclick="openModal('delete-promo-{{ $promo->id }}')">
                                Delete
                            </x-danger-button>

                            <!-- Delete Modal -->
                            <x-confirm-delete-modal id="delete-promo-{{ $promo->id }}" title="Delete Promo Code"
                                message="This promo code will be permanently deleted."
                                :route="route('hotelAdmin.promocode.destroy', $promo->id)" method="DELETE"
                                confirm="Delete" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expired Promo Codes Table -->
    <div id="expired-promocodes" class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4"><b>Expired Promo Codes</b></h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="text-left py-3 px-4 text-center">Code</th>
                        <th class="text-left py-3 px-4 text-center">Discount %</th>
                        <th class="text-left py-3 px-4 text-center">Start Date</th>
                        <th class="text-left py-3 px-4 text-center">End Date</th>
                        <th class="text-left py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promocodes->where('is_active', 0) as $promo)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center">{{ $promo->code }}</td>
                        <td class="py-3 px-4 text-center">{{ $promo->discount_percentage }}%</td>
                        <td class="py-3 px-4 text-center">{{ $promo->start_date->format('Y-m-d') }}</td>
                        <td class="py-3 px-4 text-center">{{ $promo->end_date->format('Y-m-d') }}</td>
                        <td class="py-3 px-4 flex space-x-2">

                            <!-- Edit Button -->
                            <x-primary-button onclick="openModal('edit-promo-{{ $promo->id }}')">
                                Edit
                            </x-primary-button>

                            <!-- Edit Modal -->
                            <x-edit-modal id="edit-promo-{{ $promo->id }}" title="Edit Promo Code" :fields="[
                                        ['label' => 'Code', 'name' => 'code', 'value' => $promo->code, 'type' => 'text'],
                                        ['label' => 'Discount %', 'name' => 'discount_percentage', 'value' => $promo->discount_percentage, 'type' => 'number'],
                                        ['label' => 'Start Date', 'name' => 'start_date', 'value' => $promo->start_date->format('Y-m-d'), 'type' => 'date'],
                                        ['label' => 'End Date', 'name' => 'end_date', 'value' => $promo->end_date->format('Y-m-d'), 'type' => 'date'],
                                    ]" :route="route('hotelAdmin.promocode.update', $promo->id)" />
                            <x-primary-button class="bg-green-600 hover:bg-green-700"
                                onclick="openModal('activate-promo-{{ $promo->id }}')">
                                Activate
                            </x-primary-button>
                            <x-confirm-delete-modal id="activate-promo-{{ $promo->id }}" title="Activate Promo Code"
                                message="This promo code will be Activated."
                                :route="route('hotelAdmin.promocode.activate', $promo->id)" method="PATCH"
                                confirm="Activate" />

                            <!-- Delete Button -->
                            <x-danger-button onclick="openModal('delete-promo-{{ $promo->id }}')">
                                Delete
                            </x-danger-button>

                            <!-- Delete Modal -->
                            <x-confirm-delete-modal id="delete-promo-{{ $promo->id }}" title="Delete Promo Code"
                                message="This promo code will be permanently deleted."
                                :route="route('hotelAdmin.promocode.destroy', $promo->id)" method="DELETE"
                                confirm="Delete" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection