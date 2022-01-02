<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Carbon;

class MoviesViewModel extends ViewModel
{
    public $popular_movies;
    public $genres;
    public $now_playing;

    public function __construct($popular_movies, $genres, $now_playing)
    {
        $this->popular_movies = $popular_movies;
        $this->genres = $genres;
        $this->now_playing = $now_playing;
    }

    public function popularMovies()
    {
        return $this->formatMovies($this->popular_movies);
    }

    public function genres()
    {
        return collect($this->genres)->mapWithKeys(function($genre){
            return [ $genre['id'] => $genre['name'] ];
        });
    }

    public function nowPlayingMovies()
    {
        return $this->formatMovies($this->now_playing);
    }

    public function formatMovies($movies)
    {
        return collect($movies)->map(function($movie){
            $genres_formatted = collect($movie['genre_ids'])->mapWithKeys(function($value){
                return [$value => $this->genres()->get($value)];
            })->implode(', ');

            return collect($movie)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'],
                'vote_average' => ($movie['vote_average'] * 10 ). '%',
                'release_date' => \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y'),
                'genres' => $genres_formatted,
            ])->only([
                'poster_path', 'id', 'genre_ids', 'title', 'vote_average', 'overview', 'release_date', 'genres'
            ]);
        });
    }

}