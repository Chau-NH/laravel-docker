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
        @includeWhen($addPost, 'livewire.post.create')
        @includeWhen($updatePost, 'livewire.post.update')
    </div>
    <div class="col-md-8">
        @includeWhen($listPost, 'livewire.post.list')
    </div>
</div>
