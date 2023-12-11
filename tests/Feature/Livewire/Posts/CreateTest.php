<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\Post;

class CreateTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Create::class)
            ->assertStatus(200);
    }

    /** @test */
    public function redirect_to_posts()
    {
        Livewire::test(Create::class)
            ->call('cancel')->assertRedirect('/posts');
    }
}
