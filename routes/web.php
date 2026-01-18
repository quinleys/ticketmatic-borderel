<?php

use App\Livewire\BorderelDetail;
use App\Livewire\EventsList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('events.index');
})->name('home');

Route::get('/events', EventsList::class)->name('events.index');
Route::get('/events/{event}/borderel', BorderelDetail::class)->name('events.borderel');
