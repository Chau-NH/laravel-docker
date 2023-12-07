<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Posts\Posts;
use App\Livewire\Posts\Create;
use App\Livewire\Posts\Edit;

// LIVEWIRE
Route::get('/posts',Posts::class)->middleware(['auth'])->name('posts.index');
Route::get('/posts/create',Create::class)->middleware(['auth'])->name('posts.create');
Route::get('/posts/{id}',Edit::class)->middleware(['auth'])->name('posts.edit')->lazy();
