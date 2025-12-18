@props([
    'id',           // Unique modal id
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
    'route' ,       // Route for deletion
    'method' => 'POST',
    'confirm'=>'Delete'
])

<div id="{{ $id }}" class="fixed inset-0 bg-black/50 hidden justify-center items-center p-4 z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <button onclick="closeModal('{{ $id }}')" class="absolute top-2 right-2 text-gray-500 hover:text-black text-lg font-bold">✖</button>
        <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
        <p class="mb-4">{{ $message }}</p>
        <div class="flex justify-end gap-2">
            <x-secondary-button onclick="closeModal('{{ $id }}')">Cancel</x-secondary-button>
            <form action="{{ $route }}" method="POST" class="inline">
                @csrf
                @if($method !== 'POST')
                    @method($method)
                @endif
                <x-danger-button type="submit">{{ $confirm }}</x-danger-button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
