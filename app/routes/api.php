<?php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TicketController;

//Boards
Route::get ('/boards', [BoardController::class, 'index'])->name('boards.index');
Route::get ('/boards/{board}',[BoardController::class, 'show'])->name('boards.show');

//Tickets
Route::get ('tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get ('/tickets/{ticket}',[TicketController::class, 'show'])->name('tickets.show');

//Nested: Tickets unter Board
Route::get ('/boards/{board}/tickets', [TicketController::class, 'indexForBoard'])->name('boards.tickets.index');

//Comments
Route::get ('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::get ('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');

//Nested: Comments unter Tickets
Route::get ('/tickets/{ticket}/comments', [CommentController::class, 'indexForTicket'])->name('tickets.comments.index');


//Auth Group
Route::middleware('auth:sanctum')->group(function(){
//Boards
Route::post ('/boards', [BoardController::class, 'store'])->name('boards.store');
Route::put('/boards/{board}', [BoardController::class, 'update'])->name('boards.update');
Route::delete('/boards/{board}', [BoardController::class, 'destroy'])->name('boards.destroy');

//Tickets
Route::post ('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::put ('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete ('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.delete');

//Comments
Route::post ('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::put ('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete ('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

//Nested Tickets unter Boards
Route::post('/boards/{board}/tickets', [TicketController::class, 'storeForBoard'])->name('boards.tickets.store');

//Nested Comments unter Tickets
Route::post ('/tickets/{ticket}/comments', [CommentController::class, 'storeForTicket'])->name('tickets.comments.store');
});