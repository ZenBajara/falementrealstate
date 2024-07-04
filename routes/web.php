<?php

use App\Livewire\Home;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Livewire\PropertyDetails;



Route::get('/',Home::class);
Route::get('/property/{propertyId}', PropertyDetails::class)->name('property.details');



