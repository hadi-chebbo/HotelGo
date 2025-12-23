@extends('layouts.front')
@section('title','Profile')
@section('content')
<div class="relative py-12" 
     style="background-image: url('{{ asset('images/home.png') }}'); 
            background-size: cover; 
            background-position: center;">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <div class="p-4 sm:p-8 dark:bg-gray-800/80 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 dark:bg-gray-800/80 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 dark:bg-gray-800/80 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection
