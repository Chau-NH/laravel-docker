<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Posts')]
class Posts extends Component
{
    public $title, $description;
    
    /**
     * List of add/edit form rules
     */
    public function rules() 
    { 
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:5'
        ];
    }

    #[Computed]
    public function posts()
    {
        return Post::select('id', 'title', 'description')->get();
    }

    public function render()
    { 
        return view('livewire.posts.posts');
    }

    /**
     * Open Add Post form
     * @return void
     */
    public function create()
    {
       return redirect()->route('posts.create');
    }

    /**
     * show existing post data in edit post form
     * @param mixed $id
     * @return void
     */
    public function edit($id) 
    {
        return to_route('posts.edit', ['id' => $id]);
    }

    /**
     * Listening to an event to delete a specific post
     * @param mixed $id
     * @return void
     */
    #[On('delete-post')]
    public function delete($id)
    {
        try {
            Post::find($id)->delete();
            session()->flash('success',"Post Deleted Successfully!!");
            unset($this->posts);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}
