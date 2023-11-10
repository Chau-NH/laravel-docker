<div class="card space-y-12">
    <div class="card-body border-b border-gray-900/10 pb-12">
        <form>
            <div class="sm:col-span-4">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title:</label>
                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('title') is-invalid @enderror" id="title" placeholder="Enter Title" wire:model.live='title'/>
                @error ('title')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="sm:col-span-4">
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description:</label>
                <textarea class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('description') is-invalid @enderror" id="description" wire:model.live="description" placeholder="Enter Description"></textarea>
                @error ('description')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button wire:click.prevent="storePost()" class="px-4 py-2 text-white bg-green-600 rounded">Save</button>
                <button wire:click.prevent="cancelPost()" class="px-4 py-2 text-white bg-gray-600 rounded">Cancel</button>
            </div>
        </form>
    </div>
</div>