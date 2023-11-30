<div class="card">
    <div class="card-body">
        <button wire:click="create()" class="px-4 py-2 text-white bg-blue-600 float-right rounded" >Add New Post</button>
        <div class="relative overflow-x-auto">
            <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Title</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($this->posts) > 0)
                        @foreach ($this->posts as $post)
                            <tr wire:key="{{ $post->id }}">
                                <td class="px-6 py-4 border-b border-gray-200">
                                    {{ $post->title }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-200">
                                    {{ $post->description }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-200">
                                    <button wire:click="edit({{ $post->id }})" class="px-4 py-2 text-white bg-green-600 rounded">Edit</button>
                                    <button wire:click="$dispatch('delete-post', {id: {{ $post->id }}})" wire:confirm="Are you sure you want to delete this post?" class="px-4 py-2 text-white bg-red-600 rounded">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="content-center">
                                No Posts Found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>