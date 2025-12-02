@extends('layouts.admin')

@section('title', 'All Hotels')

@section('content')
<h1 class="text-2xl font-bold mb-6">All Hotels</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($hotels as $hotel)
        <x-system-hotel-card :hotel="$hotel" />
    @endforeach
</div>
@endsection
