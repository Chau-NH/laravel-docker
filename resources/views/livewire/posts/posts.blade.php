<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Posts
    </h2>
</x-slot>
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
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
                </div>
                <div class="col-md-8">
                    @include('livewire.posts._list')
                </div>
            </div>
        </div>
    </div>
</div>