<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PopularController extends Controller
{
    public function index()
    {
        $apiKey = env('TMDB_API_KEY');
        $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
            'api_key' => $apiKey,
            'language' => 'ja-JP'
        ]);

        $movies = $response->json()['results'];

        return view('index', compact('movies'));
    }
}