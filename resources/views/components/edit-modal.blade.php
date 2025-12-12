@props([
    'id',
    'title' => 'Edit Item',
    'fields' => [],
    'method' => 'PUT'
])

<div id="{{ $id }}" class="fixed inset-0 bg-black/50 hidden justify-center items-center p-4 z-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative mt-10 mb-10 max-h-[90vh] overflow-y-auto">
        <button onclick="closeModal('{{ $id }}')" class="absolute top-2 right-2 text-gray-500 hover:text-black text-lg font-bold">✖</button>
        <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>

        <form id="{{ $id }}-form" method="POST" action="">
            @csrf
            @method($method)    

            @foreach ($fields as $field)
                <div class="mb-3">
                    <label class="block text-sm font-medium">{{ $field['label'] }}</label>
                    @if($field['type'] === 'textarea')
                        <textarea 
                            name="{{ $field['name'] }}" 
                            id="{{ $id }}_{{ $field['name'] }}" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        ></textarea>
                    @else
                        <input 
                            type="{{ $field['type'] }}" 
                            name="{{ $field['name'] }}" 
                            id="{{ $id }}_{{ $field['name'] }}" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            @if(isset($field['min'])) min="{{ $field['min'] }}" @endif
                            @if(isset($field['max'])) max="{{ $field['max'] }}" @endif
                            @if(isset($field['step'])) step="{{ $field['step'] }}" @endif
                        >
                    @endif
                </div>
            @endforeach

            <x-primary-button type="submit" class="w-full flex items-center justify-center">
                Save Changes
            </x-primary-button>
        </form>
    </div>
</div>

<script>
function openModal(id, data = {}, action = '') {
    const modal = document.getElementById(id);
    if (!modal) return;
    
    const form = modal.querySelector('form');
    if (form && action) {
        form.action = action;
    }

    for (const key in data) {
        const input = document.getElementById(`${id}_${key}`);
        if (input) {
            input.value = data[key] || '';
        }
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
