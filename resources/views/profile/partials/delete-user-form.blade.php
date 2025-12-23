<div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
    <header class="mb-6">
        <h2 class="text-xl font-bold text-red-700 mb-1">
            Delete Account
        </h2>
        <p class="text-gray-600">
            Once your account is deleted, all of its resources and data will be permanently deleted. 
            Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700"
    >
        Delete Account
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('delete')

            <h3 class="text-lg font-bold text-red-700">
                Are you sure you want to delete your account?
            </h3>

            <p class="text-gray-600 text-sm">
                Once your account is deleted, all of its resources and data will be permanently deleted. 
                Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <div>
                <x-input-label for="password" value="Password" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700">
                    Delete Account
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
