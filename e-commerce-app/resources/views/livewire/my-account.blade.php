<div class="flex justify-center align-middle">
    <div x-data="{
        showToast: false,
    message: '',
    type: '',
    init() {
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('toast', (data) => {
                console.log('Toast event received:', data);
                this.message = data[0].message;
                this.type = data[0].type;
                this.showToast = true;

                setTimeout(() => {
                    this.dismissToast();
                }, 3000);
            });
        });
    },
    dismissToast() {
        this.showToast = false;
    }
    }">
        <div x-show="showToast"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="fixed top-[80px] right-14 z-50">
            <div id="toast-notification"
                 class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                 role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"
                     :class="type === 'success' ? 'text-green-500 bg-green-100' : 'text-red-500 bg-red-100'">
                    <template x-if="type === 'success'">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                    </template>
                    <template x-if="type === 'error'">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                    </template>
                </div>
                <div class="ms-3 text-sm font-normal" x-text="message"></div>
                <button type="button"
                        @click="dismissToast()"
                        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="w-full max-w-[60rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <h3 class="pl-5 text-4xl font-bold text-slate-500">Account information</h3>
        <form wire:submit.prevent="updateName" class="px-9 py-5 bg-white rounded shadow-lg my-6">
            <div class="grid gap-4 mb-10 sm:grid-cols-1 gap-x-10">
                <div>
                    <label for="name" class="block py-3 text-start text-md font-medium text-gray-500 uppercase">Name</label>
                    <div class="flex justify-between w-full">
                        <div class="w-2/3">
                            <input type="text" wire:model="name" id="name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                @readonly(!$isEditing)>
                        </div>
                        @if(!$isEditing)
                            <button type="button" wire:click="toggleEdit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Edit
                            </button>
                        @else
                            <div>
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                                    Save
                                </button>
                                <button type="button" wire:click="cancelEdit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                    Cancel
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="w-2/3">
                    <label for="email" class="block py-3 text-start text-md font-medium text-gray-500 uppercase">Email</label>
                    <input type="email" wire:model="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                </div>
            </div>
        </form>

        <h3 class="pl-5 text-4xl font-bold text-slate-500">Change password</h3>
        <form wire:submit.prevent="update" class="px-9 py-5 bg-white rounded shadow-lg mt-4">
            <div class="grid gap-4 mb-8 sm:grid-cols-1 gap-x-10">
                <div class="grid gap-4 sm:grid-cols-1 gap-x-10">
                    <div class="w-2/3">
                        <label for="currentPassword" class="block py-3 text-start text-md font-medium text-gray-500 uppercase">Current password</label>
                        <input type="password" wire:model="currentPassword" id="currentPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @error('currentPassword')
                        <p class="text-xs text-red-600 mt-2" id="email-error">{{  $message }}</p>
                        @enderror
                    </div>
                    <div class="w-2/3">
                        <label for="password" class="block py-3 text-start text-md font-medium text-gray-500 uppercase">New password</label>
                        <input
                            type="password"
                            wire:model="password"
                            id="password"
                            class="bg-gray-50 border {{ $errors->has('password') ? 'border-red-600' : 'border-gray-300' }} text-gray-900 text-sm rounded-md focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                        @error('password')
                        <p class="text-xs text-red-600 mt-2" id="email-error">{{  $message }}</p>
                        @enderror
                    </div>
                    <div class="w-2/3">
                        <label for="password_confirmation" class="block py-3 text-start text-md font-medium text-gray-500 uppercase">New password confirmation</label>
                        <input type="password" wire:model="password_confirmation" id="password_confirmation" class="bg-gray-50 border {{ $errors->has('password') ? 'border-red-600' : 'border-gray-300' }} text-gray-900 text-sm rounded-md focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Change password
            </button>
        </form>
    </div>
</div>
