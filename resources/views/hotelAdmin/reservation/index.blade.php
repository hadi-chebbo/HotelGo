@extends('layouts.admin')

@section('title', 'Reservations Management')

@extends('components.hotel-admin-sidebar')

@section('content')
<div class="space-y-8">
    <div class="flex justify-end mb-8">
        <x-primary-button onclick="openModal('CreateReservationModal')">
            + Add Walk-in Reservation
        </x-primary-button>
    </div>

    <!-- Create Reservation Modal -->
    <x-create-modal id="CreateReservationModal" title="Create Walk-in Reservation"
        action="{{ route('hotelAdmin.reservation.store') }}" buttonName="Create Reservation" :fields="[
            ['name' => 'name', 'label' => 'Guest Name', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'phone', 'label' => 'Phone', 'type' => 'text'],
            ['name' => 'room_number', 'label' => 'Room Number', 'type' => 'number'],
            ['name' => 'check_in_date', 'label' => 'Check-in Date', 'type' => 'date'],
            ['name' => 'check_out_date', 'label' => 'Check-out Date', 'type' => 'date'],
            ['name' => 'payment_method', 'label' => 'Payment Method', 'type' => 'select', 'options' => [
                'cash' => 'Cash',
                'credit_card' => 'Credit Card',
                'debit_card' => 'Debit Card',
                'bank_transfer' => 'Bank Transfer'
            ]],
        ]" />

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Walk-in Reservations Table -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">
            <b>Walk-in Reservations</b>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-3 px-4 text-center">Guest Name</th>
                        <th class="py-3 px-4 text-center">Room Number</th>
                        <th class="py-3 px-4 text-center">Check-in</th>
                        <th class="py-3 px-4 text-center">Check-out</th>
                        <th class="py-3 px-4 text-center">Total Price</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reservationsWalkIn as $reservation)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center font-medium">
                            {{ $reservation->guest->name }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ $reservation->room->room_number }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}
                        </td>

                        <td class="py-3 px-4 text-center font-semibold">
                            ${{ number_format($reservation->total_price, 2) }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($reservation->status === 'confirmed') bg-green-100 text-green-700
                                @elseif($reservation->status === 'checked_in') bg-blue-100 text-blue-700
                                @elseif($reservation->status === 'checked_out') bg-gray-100 text-gray-700
                                @elseif($reservation->status === 'cancelled') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                            </span>
                        </td>

                        <td class="py-3 px-4 flex justify-center gap-2">
                            <!-- Edit -->
                            <x-primary-button type="button" class="editReservationBtn" 
                                data-id="{{ $reservation->id }}"
                                data-name="{{ $reservation->guest->name }}"
                                data-email="{{ $reservation->guest->email }}"
                                data-phone="{{ $reservation->guest->phone }}"
                                data-room_number="{{ $reservation->room->room_number }}"
                                data-check_in_date="{{ $reservation->check_in_date }}"
                                data-check_out_date="{{ $reservation->check_out_date }}"
                                data-payment_method="{{ $reservation->payments->first()->method ?? 'cash' }}">
                                Edit
                            </x-primary-button>

                            <!-- Delete -->
                            <x-danger-button onclick="openModal('deleteReservationModal-{{ $reservation->id }}')">
                                Delete
                            </x-danger-button>

                            <x-confirm-delete-modal id="deleteReservationModal-{{ $reservation->id }}" 
                                title="Delete Reservation"
                                method="DELETE" 
                                message="Are you sure you want to delete the reservation for {{ $reservation->guest->name }}?"
                                route="{{ route('hotelAdmin.reservation.delete', $reservation->id) }}" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            No walk-in reservations found. Click "Add Walk-in Reservation" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Online Reservations Table -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mt-8">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">
            <b>Online Reservations</b>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-3 px-4 text-center">Guest Name</th>
                        <th class="py-3 px-4 text-center">Room Number</th>
                        <th class="py-3 px-4 text-center">Check-in</th>
                        <th class="py-3 px-4 text-center">Check-out</th>
                        <th class="py-3 px-4 text-center">Total Price</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reservationsOnline as $reservation)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center font-medium">
                            {{ $reservation->guest->name }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ $reservation->room->room_number }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}
                        </td>

                        <td class="py-3 px-4 text-center font-semibold">
                            ${{ number_format($reservation->total_price, 2) }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($reservation->status === 'confirmed') bg-green-100 text-green-700
                                @elseif($reservation->status === 'checked_in') bg-blue-100 text-blue-700
                                @elseif($reservation->status === 'checked_out') bg-gray-100 text-gray-700
                                @elseif($reservation->status === 'cancelled') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                            </span>
                        </td>

                        <td class="py-3 px-4 flex justify-center gap-2">
                            <!-- View Details -->
                            <x-primary-button type="button">
                                View
                            </x-primary-button>

                            <!-- Delete -->
                            <x-danger-button onclick="openModal('deleteOnlineReservationModal-{{ $reservation->id }}')">
                                Cancel
                            </x-danger-button>

                            <x-confirm-delete-modal id="deleteOnlineReservationModal-{{ $reservation->id }}" 
                                title="Cancel Reservation"
                                method="DELETE" 
                                message="Are you sure you want to cancel the reservation for {{ $reservation->guest->name }}?"
                                route="{{ route('hotelAdmin.reservation.delete', $reservation->id) }}" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            No online reservations found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Reservation Modal -->
    <x-edit-modal id="editReservationModal" title="Edit Reservation" :fields="[
            ['name' => 'name', 'label' => 'Guest Name', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'phone', 'label' => 'Phone', 'type' => 'text'],
            ['name' => 'room_number', 'label' => 'Room Number', 'type' => 'number'],
            ['name' => 'check_in_date', 'label' => 'Check-in Date', 'type' => 'date'],
            ['name' => 'check_out_date', 'label' => 'Check-out Date', 'type' => 'date'],
            ['name' => 'payment_method', 'label' => 'Payment Method', 'type' => 'select', 'options' => [
                'cash' => 'Cash',
                'credit_card' => 'Credit Card',
                'debit_card' => 'Debit Card',
                'bank_transfer' => 'Bank Transfer'
            ]],
        ]" />

</div>

<script>
    // Edit Reservation Modal
    document.querySelectorAll('.editReservationBtn').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = 'editReservationModal';
            const modal = document.getElementById(modalId);

            // Set form action
            const reservationId = button.getAttribute('data-id');
            const form = modal.querySelector('form');
            form.action = `/hotelAdmin/reservations/${reservationId}/edit`;

            // Add PUT method
            let methodField = form.querySelector('input[name="_method"]');
            if (!methodField) {
                methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                form.appendChild(methodField);
            }
            methodField.value = 'PUT';

            modal.querySelector('#' + modalId + '_entity_id').value = reservationId;
            
            // Populate fields
            modal.querySelector('#' + modalId + '_name').value = button.getAttribute('data-name');
            modal.querySelector('#' + modalId + '_email').value = button.getAttribute('data-email');
            modal.querySelector('#' + modalId + '_phone').value = button.getAttribute('data-phone');
            modal.querySelector('#' + modalId + '_room_number').value = button.getAttribute('data-room_number');
            modal.querySelector('#' + modalId + '_check_in_date').value = button.getAttribute('data-check_in_date');
            modal.querySelector('#' + modalId + '_check_out_date').value = button.getAttribute('data-check_out_date');
            modal.querySelector('#' + modalId + '_payment_method').value = button.getAttribute('data-payment_method');

            openModal(modalId);
        });
    });

    // Re-open modal with old values if validation errors exist
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            @if(old('name') && old('check_in_date') && !old('editReservationModal_entity_id'))
                // Re-open Create Modal with old values
                const createModal = document.getElementById('CreateReservationModal');
                if (createModal) {
                    createModal.querySelector('#CreateReservationModal_name').value = '{{ old('name') }}';
                    createModal.querySelector('#CreateReservationModal_email').value = '{{ old('email') }}';
                    createModal.querySelector('#CreateReservationModal_phone').value = '{{ old('phone') }}';
                    createModal.querySelector('#CreateReservationModal_room_number').value = '{{ old('room_number') }}';
                    createModal.querySelector('#CreateReservationModal_check_in_date').value = '{{ old('check_in_date') }}';
                    createModal.querySelector('#CreateReservationModal_check_out_date').value = '{{ old('check_out_date') }}';
                    createModal.querySelector('#CreateReservationModal_payment_method').value = '{{ old('payment_method') }}';
                    openModal('CreateReservationModal');
                }
            @elseif(old('editReservationModal_entity_id'))
                // Re-open Edit Modal with old values
                const editModal = document.getElementById('editReservationModal');
                if (editModal) {
                    const reservationId = '{{ old('editReservationModal_entity_id') }}';
                    const form = editModal.querySelector('form');
                    form.action = `/hotelAdmin/reservations/${reservationId}`;
                    
                    let methodField = form.querySelector('input[name="_method"]');
                    if (!methodField) {
                        methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        form.appendChild(methodField);
                    }
                    methodField.value = 'PUT';
                    
                    editModal.querySelector('#editReservationModal_name').value = '{{ old('name') }}';
                    editModal.querySelector('#editReservationModal_email').value = '{{ old('email') }}';
                    editModal.querySelector('#editReservationModal_phone').value = '{{ old('phone') }}';
                    editModal.querySelector('#editReservationModal_room_number').value = '{{ old('room_number') }}';
                    editModal.querySelector('#editReservationModal_check_in_date').value = '{{ old('check_in_date') }}';
                    editModal.querySelector('#editReservationModal_check_out_date').value = '{{ old('check_out_date') }}';
                    editModal.querySelector('#editReservationModal_payment_method').value = '{{ old('payment_method') }}';
                    
                    openModal('editReservationModal');
                }
            @endif
        });
    @endif
</script>
@endsection