<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
        ]);

        $user = Auth::user();
        $movieId = $request->input('movie_id');

        // 既にお気に入りに追加されているか確認
        if ($user->favorites()->where('movie_id', $movieId)->exists()) {
            return back()->with('status', 'この映画は既にお気に入りに追加されています。');
        }

        // お気に入りに追加
        Favorite::create([
            'user_id' => $user->id,
            'movie_id' => $movieId,
        ]);

        return back()->with('status', 'お気に入りに追加しました。');
    }

    public function destroy(Request $request, $id)
    {
        $favorite = Favorite::where('user_id', Auth::id())->where('movie_id', $id)->firstOrFail();
        $favorite->delete();

        return back()->with('status', 'お気に入り解除しました。');
    }
}