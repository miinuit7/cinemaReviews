<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{

    public function showMovieDetails($id)
    {
        // TMDb APIキーを環境変数から取得
        $apiKey = env('TMDB_API_KEY');

        // TMDb APIから映画の詳細データを取得
        $response = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
            'api_key' => $apiKey,
            'language' => 'ja-JP',
        ]);

        // レスポンスをJSON形式で取得
        $detail = $response->json();

        // 取得したデータをビューに渡す
        $reviews = Review::where('movie_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('detail.show', compact('detail', 'reviews'));
    }

}
