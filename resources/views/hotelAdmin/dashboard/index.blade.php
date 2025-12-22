@extends('layouts.admin')

@section('title', 'Hotel Dashboard')
@extends('components.hotel-admin-sidebar')
@section('content')
<div class="container mx-auto py-8 px-4">

    {{-- Revenue Chart --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-blue-900">Revenue per Room Type</h2>
        <canvas id="revenueChart" class="w-full h-64"></canvas>
    </div>
    {{-- Most Booked Rooms --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600">Most Booked Room Types</h2>
        <ul class="divide-y divide-gray-200">
            @foreach($roomTypes as $index => $type)
                <li class="py-3 flex justify-between">
                    <span class="font-medium text-blue-900">{{ $type }}</span>
                    <span class="text-gray-600">{{ $bookings[$index] }} bookings</span>
                </li>
            @endforeach
        </ul>
    </div>
    

    

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($roomTypes) !!},
            datasets: [{
                label: 'Revenue ($)',
                data: {!! json_encode($revenues) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.raw.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue ($)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Room Types'
                    }
                }
            }
        }
    });
</script>
@endsection
