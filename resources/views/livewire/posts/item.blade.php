<tr>
    <td class="px-6 py-4 border-b border-gray-200">
        {{ $post->title }}
    </td>
    <td class="px-6 py-4 border-b border-gray-200">
        {{ $post->description }}
    </td>
    <td class="px-6 py-4 border-b border-gray-200">
        <button wire:click="$parent.edit({{ $post->id }})" class="px-4 py-2 text-white bg-green-600 rounded">Edit</button>
        <button wire:click="$dispatch('delete-post', {id: {{ $post->id }}})" wire:confirm="Are you sure you want to delete this post?" class="px-4 py-2 text-white bg-red-600 rounded">Delete</button>
        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('posts.edit', ['id' => $post->id]) }}">Edit</a>
    </td>
</tr>
