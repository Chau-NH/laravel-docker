<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Edit Post
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="col-md-8">
                    @if (session()->has('error'))
                        <div class="mb-4 rounded-lg bg-red-100 px-6 py-5 text-base text-red-700" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="border-b border-gray-900/10 pb-12">
                        <form>
                            <div class="sm:col-span-4">
                                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title:</label>
                                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('title') is-invalid @enderror" id="title" placeholder="Enter Title" wire:model='title' />
                                @error ('title')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-4">
                                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description:</label>
                                <textarea class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('description') is-invalid @enderror" id="description" wire:model="description" placeholder="Enter Description"></textarea>
                                @error ('description')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-6 flex justify-end gap-2">
                                <button wire:click.prevent="save()" wire:loading.attr="disabled" class="px-4 py-2 text-white bg-green-600 rounded">
                                    <span>Update</span>
                                    <x-loading wire:loading.delay.long wire:target="save()" />
                                </button>
                                <button wire:click.prevent="cancel()" class="px-4 py-2 text-white bg-gray-600 rounded">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
