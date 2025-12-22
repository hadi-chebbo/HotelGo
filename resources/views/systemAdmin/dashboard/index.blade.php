@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">


    <div class="row g-4 mb-5">
        {{-- Average Rating Card --}}
        <div class="col-md-4">
            <div class="card border-primary shadow-sm h-100 text-center p-4 hover-shadow">
                <div class="card-body">
                    <i class="fas fa-star fa-2x text-warning mb-2"></i>
                    <h5 class="card-title fw-bold">Average Rating</h5>
                    <p class="card-text display-5">{{ number_format($averageRating, 1) }} ⭐</p>
                </div>
            </div>
        </div>

        {{-- Total Hotels Card --}}
        <div class="col-md-4">
            <div class="card border-success shadow-sm h-100 text-center p-4 hover-shadow">
                <div class="card-body">
                    <i class="fas fa-hotel fa-2x text-success mb-2"></i>
                    <h5 class="card-title fw-bold">Total Hotels</h5>
                    <p class="card-text display-5">{{ $totalHotels }}</p>
                </div>
            </div>
        </div>

        {{-- Total Reviews Card --}}
        <div class="col-md-4">
            <div class="card border-warning shadow-sm h-100 text-center p-4 hover-shadow">
                <div class="card-body">
                    <i class="fas fa-comments fa-2x text-warning mb-2"></i>
                    <h5 class="card-title fw-bold">Total Reviews</h5>
                    <p class="card-text display-5">{{ $totalReviews }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Hotel Ratings Chart --}}
    <div class="card shadow-sm p-4 mb-5">
        <h5 class="mb-3 fw-bold">Hotel Ratings</h5>
        <canvas id="hotelRatingsChart" width="400" height="200"></canvas>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($hotels->pluck('name'));
    const data = @json($hotels->pluck('average_rating'));

    const ctx = document.getElementById('hotelRatingsChart').getContext('2d');

    new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels, // room types
        datasets: [{
            label: 'Reservations',
            data: data,
            backgroundColor: '#4F46E5', // nicer purple color
            borderRadius: 5, // rounded bars
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false // hides legend for cleaner look
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.raw + ' reservations';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0,
                    font: {
                        size: 14,
                        family: 'Inter, sans-serif',
                        weight: '500'
                    },
                    color: '#374151' // nice dark gray
                },
                grid: {
                    color: '#E5E7EB', // light gray grid
                    drawBorder: false
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 14,
                        family: 'Inter, sans-serif',
                        weight: '500'
                    },
                    color: '#374151'
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

</script>

{{-- Optional: Hover effect for cards --}}
<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    transition: 0.3s;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
}
</style>

{{-- FontAwesome for icons --}}
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

@endsection
