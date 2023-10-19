<div>
    <div class="col-md-8">
        @if (session()->has('success'))
            <div class="text-green-600" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="text-red-600" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
        @includeWhen($addPost, 'livewire.create')
        @includeWhen($updatePost, 'livewire.update')
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if (!$addPost)
                    <button wire:click="createPost()" class="px-4 py-2 text-white bg-blue-600 float-right rounded" >Add New Post</button>
                @endif
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
                            @if (count($posts) > 0)
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200">
                                            {{ $post->title }}
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200">
                                            {{ $post->description }}
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200">
                                            <button wire:click="editPost({{ $post->id }})" class="px-4 py-2 text-white bg-green-600 rounded">Edit</button>
                                            <button wire:click="deletePost({{ $post->id }})" class="px-4 py-2 text-white bg-red-600 rounded">Delete</button>
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
    </div>
</div>
