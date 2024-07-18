<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'review_id' => $request->review_id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back();
    }
}
