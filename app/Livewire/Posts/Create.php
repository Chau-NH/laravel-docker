<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Title;

#[Title('Create Post')]
class Create extends Component
{
    public PostForm $form;

    public function render()
    {
        return view('livewire.posts.create');
    }

    public function save()
    {
        $this->validate();
        try {
            Post::create([
                'title' => $this->form->title,
                'description' => $this->form->description,
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
