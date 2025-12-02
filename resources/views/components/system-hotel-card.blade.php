@props(['hotel'])

<div class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition flex flex-col">
    <!-- Hotel basic info -->
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold">{{ $hotel->name }}</h3>
        <span class="text-gray-500 text-sm">⭐ {{ $hotel->rating ?? 'N/A' }} / 5</span>
    </div>

    <p class="text-gray-600">{{ $hotel->city }}, {{ $hotel->country }}</p>

    <!-- Hotel admin info -->
    <div class="mt-2 text-gray-700 text-sm">
        <p>Admin: {{ $hotel->user->name ?? 'N/A' }}</p>
        <p>Email: {{ $hotel->user->email ?? 'N/A' }}</p>
    </div>

    <!-- Admin actions -->
    {{-- <div class="mt-4 flex gap-2">
        <a href="{{ route('systemAdmin.hotels.edit', $hotel->id) }}"
           class="flex-1 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-center">
            Edit
        </a>

        <form action="{{ route('systemAdmin.hotels.destroy', $hotel->id) }}" method="POST" class="flex-1">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="w-full bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700">
                Delete
            </button>
        </form>
    </div> --}}
</div>
