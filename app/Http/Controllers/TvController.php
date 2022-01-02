<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ViewModels\TvsViewModel;
use App\ViewModels\TvViewModel;

class TvController extends Controller
{
    public function index()
    {
        $popular_tvs = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/tv/popular')
        ->json()['results'];

        $top_rated_tv = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/tv/top_rated')
        ->json()['results'];

        $genres = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/genre/movie/list')
        ->json()['genres'];

        $movies_view_model = new TvsViewModel($popular_tvs, $top_rated_tv, $genres);
        return view('tv.index', $movies_view_model);
    }
    
    public function show($id)
    {
        $tv = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/tv/'.$id.'?append_to_response=credits,videos,images')
        ->json();

        $movie_model = new TvViewModel($tv);
        return view('tv.show', $movie_model);
    }
}
