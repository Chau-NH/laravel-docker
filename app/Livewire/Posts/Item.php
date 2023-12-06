<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class Item extends Component
{
    public $post;

    public function render()
    {
        return view('livewire.posts.item');
    }
}
