<?php

namespace App\Livewire\Posts;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class Summarize extends Component
{
    #[Reactive]
    public $posts;

    public function mount($posts)
    {
        $this->posts = $posts;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="px-4 py-4 text-black uppercase font-bold">
            <!-- Loading spinner... -->
            Loading...
        </div>
        HTML;
    }

    public function render()
    {
        return <<<'HTML'
        <div class="px-4 py-4 text-black uppercase font-bold rounded">
            Total: {{ $posts->count() }}
        </div>
        HTML;
    }
}
