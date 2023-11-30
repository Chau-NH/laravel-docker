<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Title;

#[Title('Create Post')]
class Create extends Component
{
    public $posts, $title, $description;

    public function rules() 
    { 
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:5'
        ];
    }

    public function render()
    {
        return view('livewire.posts.create');
    }

    public function save()
    {
        $this->validate();
        try {
            Post::create([
                'title' => $this->title,
                'description' => $this->description
            ]);
            session()->flash('success', 'Post Created Successfully!!');
            return redirect()->to('posts');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->to('posts');
    }
}
