@props([
'id' => 'CreateModal',
'title' => 'Create Item',
'fields' => [],
'action' => '',
'buttonName' => 'Create'
])

<div id="{{ $id }}" class="fixed inset-0 bg-black/50 hidden justify-center p-4 z-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative mt-10 mb-10 max-h-[90vh] overflow-auto">
        <button onclick="closeModal('{{ $id }}')"
            class="absolute top-2 right-2 text-gray-500 hover:text-black text-lg font-bold">✖</button>
        <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
            @csrf
            @foreach ($fields as $field)
            <div class="mb-3">
                <label class="block text-sm font-medium">{{ $field['label'] }}</label>

                @if($field['type'] === 'textarea')
                <textarea name="{{ $field['name'] }}" id="{{ $id }}_{{ $field['name'] }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error($field['name'])
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @elseif($field['type'] === 'select')
                <select name="{{ $field['name'] }}" id="{{ $id }}_{{ $field['name'] }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @if(isset($field['placeholder']))
                    <option value="">{{ $field['placeholder'] }}</option>
                    @endif
                    @foreach($field['options'] as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error($field['name'])
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @elseif($field['type'] === 'checkbox')
                <input type="checkbox" name="{{ $field['name'] }}" id="{{ $id }}_{{ $field['name'] }}" value="1"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                @error($field['name'])
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @else
                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $id }}_{{ $field['name'] }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    @if(isset($field['min'])) min="{{ $field['min'] }}" @endif 
                    @if(isset($field['max'])) max="{{ $field['max'] }}" @endif 
                    @if(isset($field['step'])) step="{{ $field['step'] }}" @endif>
                @error($field['name'])
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @endif
            </div>
            @endforeach

            <x-primary-button type="submit" class="w-full flex items-center justify-center">
                {{ $buttonName }}
            </x-primary-button>
        </form>

    </div>
</div>

<script>
    function openModal(id){
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeModal(id){
        const modal = document.getElementById(id);
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>