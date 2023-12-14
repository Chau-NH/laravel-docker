<tr>
    <td class="px-6 py-4 border-b border-gray-200">
        {{ $post->title }}
    </td>
    <td class="px-6 py-4 border-b border-gray-200">
        {{ $post->description }}
    </td>
    <td class="px-6 py-4 border-b border-gray-200">
        <a wire:navigate class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800" href="{{ route('posts.edit', ['id' => $post->id]) }}">Edit</a>
        <button wire:click="$dispatch('delete-post', {id: {{ $post->id }}})" wire:confirm="Are you sure you want to delete this post?" class="px-4 py-2 text-white bg-red-600 rounded-lg">Delete</button>
    </td>
</tr>
