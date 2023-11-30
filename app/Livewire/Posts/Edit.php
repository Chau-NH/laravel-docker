<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Title;

#[Title('Edit Post')]
class Edit extends Component
{
    public $post, $title, $description;

    public function rules() 
    { 
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:5'
        ];
    }

    public function mount($id)
    {
        try {
            $this->post = Post::findOrFail($id);
            if (!$this->post) {
                session()->flash('error','Post not found');
            } else {
                $this->fill(
                    $this->post->only(['title', 'description', 'id'])
                );
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $this->post->update([
                'title' => $this->title,
                'description' => $this->description
            ]);
            session()->flash('success','Post Updated Successfully!!');
            return redirect()->to('posts');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->to('posts');
    }

    public function render()
    {
        return view('livewire.posts.edit');
    }
}
