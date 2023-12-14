<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class PostForm extends Form
{
    public $title = '';
    public $description = ''; 

    public function rules() 
    { 
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:5'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'title.required' => 'The title can not be empty',
    //         'title.min' => 'The title is too short',
    //         'description.required' => 'The description can not be empty',
    //         'description.min' => 'The description is too short',
    //     ];
    // }
}
