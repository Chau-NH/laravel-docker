<?php

namespace App\Livewire;

use App\Models\Post as PostModel;
use Livewire\Component;

class Post extends Component
{
    public $posts, $title, $description, $postId;
    public $updatePost = false;
    public $addPost = false;
    public $listPost = true;
    
    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'title' => 'required',
        'description' => 'required'
    ];

    /**
     * Reseting all inputted fields
     * @return void
     */
    protected function resetField()
    {
        $this->title = '';
        $this->description = '';
    }

    public function render()
    {
        $this->posts = PostModel::select('id', 'title', 'description')->get();
        return view('livewire.post.post');
    }

    /**
     * Open Add Post form
     * @return void
     */
    public function createPost()
    {
        $this->resetField();
        $this->addPost = true;
        $this->updatePost = false;
        $this->listPost = false;
    }

    /**
     * Store post data into database
     * @return void
     */
    public function storePost()
    {
        $this->validate();
        try {
            PostModel::create([
                'title' => $this->title,
                'description' => $this->description
            ]);
            session()->flash('success', 'Post Created Successfully!!');
            $this->resetField();
            $this->addPost = false;
            $this->listPost = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    /**
     * Cancel Add/Edit form
     * @return void
     */
    public function cancelPost() 
    {
        $this->reset(['addPost', 'updatePost', 'listPost']);
        $this->resetField();
    }

    /**
     * show existing post data in edit post form
     * @param mixed $id
     * @return void
     */
    public function editPost($id) 
    {
        try {
            $post = PostModel::findOrFail($id);
            if (!$post) {
                session()->flash('error','Post not found');
            } else {
                $this->title = $post->title;
                $this->description = $post->description;
                $this->postId = $post->id;
                $this->addPost = false;
                $this->updatePost = true;
                $this->listPost = false;
            }
        } catch (\Exception $e) {
            session()->flash('error','Something goes wrong!!');
        }
    }

    /**
     * update the post data
     * @return void
     */
    public function modifyPost() 
    {
        $this->validate();
        try {
            PostModel::whereId($this->postId)->update([
                'title' => $this->title,
                'description' => $this->description
            ]);
            session()->flash('success','Post Updated Successfully!!');
            $this->resetField();
            $this->updatePost = false;
            $this->listPost = true;
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * delete specific post data from the posts table
     * @param mixed $id
     * @return void
     */
    public function deletePost($id)
    {
        try {
            PostModel::find($id)->delete();
            session()->flash('success',"Post Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}
