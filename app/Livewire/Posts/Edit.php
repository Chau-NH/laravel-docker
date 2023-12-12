<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\Post;
use Exception;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Renderless;

#[Title('Edit Post')]
class Edit extends Component
{
    public $post;

    public $title;

    public $description;

    public function rules() 
    { 
        return [
            'title' => [
                'required', 'min:5',
                Rule::unique('posts')->ignore($this->post)
            ],
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
                    // Bulk Assignment
                    $this->post->only(['title', 'description'])
                );
            }
        } catch (Exception $e) {
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
            $this->redirect('/posts');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // public function updatingTitle($value)
    // {
    //     if ($value === 'title') {
    //         throw new Exception('Title is invalid value');
    //     }
    // }

    // public function updated($property)
    // {
    //     if ($property === 'title') {
    //         $this->title = strtoupper($this->title);
    //     }
    // }

    public function cancel()
    {
        $this->redirect('/posts');
    }

    #[Renderless]
    public function increaseViewCount()
    {
        $this->post->increment('views');
    }

    public function render()
    {
        return view('livewire.posts.edit');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="px-4 py-4 text-black uppercase font-bold text-center">
            <!-- Loading spinner... -->
            Loading...
        </div>
        HTML;
    }
}
