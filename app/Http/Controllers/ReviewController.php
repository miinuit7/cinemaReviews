<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'body' => 'required|max:1000',
            'movie_id' => 'required|integer',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $review = new Review();
        $review->body = $request->input('body');
        $review->rating = $request->input('rating');
        $review->movie_id = $request->input('movie_id');
        $review->user_id = auth()->id();
        $review->save();

        return redirect()->back()->with('success', 'レビューが投稿されました。');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    // バリデーション
    $request->validate([
        'body' => 'required|max:1000',
    ]);

    // レビューの更新
    $review = Review::findOrFail($id);
    $review->body = $request->input('body');
    $review->save();

    return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('detail.show', $review->movie_id)->with('success', 'レビューを削除しました。');
    }


}
