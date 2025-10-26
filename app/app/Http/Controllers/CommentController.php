<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentForTicketRequest;
use App\Http\Resources\CommentResource;
use App\Models\{Comment, Ticket};
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::query()
        ->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
    //GET /api/tickets/{ticket}/comments
    public function indexForTicket(Ticket $ticket, Request $request)
    {
        // Doku min ist weird, i guess bei "find the lowest value" ist der need eines max werts given
        $perPage = min($request->integer('per_page', 10), 100);

        return Comment::query()
            ->whereBelongsTo($ticket)  //WHERE ticket_id = $ticket->id; greift auf id attribute vom objekt des typs ticket zu
            ->with(['user:id, name'])  //Eager Loading, lade user mit spalten id und name
            ->latest()                 // created_at Desc
            ->paginate($perPage);      // data/links/meta
    }


    public function storeForTicket(Ticket $ticket, StoreCommentForTicketRequest $request)
    {

        //Policy
        $this->authorize('create', [Comment::class, $ticket]);

        $data = $request->validated();

        //fallback login Lösung, machen noch keine auth
        $userId = $request->user()?->id ?? ($data['user_id'] ?? null);

        $comment = $ticket->comments()->create([
            'body' => $data['body'],
            'user_id' => $userId,
        ]);

        return (new CommentResource($comment->load('user:id,name')))->response()->setStatusCode(201);
    }


}
