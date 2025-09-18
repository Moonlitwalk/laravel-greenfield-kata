<?php
use App\Http\Controllers\Postcontroller;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);