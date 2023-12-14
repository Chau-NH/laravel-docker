<div class="card">
    <div class="card-body">
        <div class="mb-6">
            <a wire:navigate href="{{ route('posts.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add New Post</a>
        </div>
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
                            <livewire:posts.item :post="$post" :key="$post->id"/>
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