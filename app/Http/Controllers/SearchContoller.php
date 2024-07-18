<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class SearchContoller extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('TMDB_API_KEY');
        $response = Http::get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
            'language' => 'ja-JP',
        ]);


        if ($response->successful() && isset($response->json()['results'])) {
            $results = $response->json()['results'];
        } else {
            $results = [];
        }

        return view('search', compact('results'));
    }
}