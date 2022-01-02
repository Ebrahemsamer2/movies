<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class TvsViewModel extends ViewModel
{
    public $popular_tvs;
    public $genres;
    public $top_rated;

    public function __construct($popular_tvs, $top_rated, $genres)
    {
        $this->popular_tvs = $popular_tvs;
        $this->genres = $genres;
        $this->top_rated = $top_rated;
    }

    public function popularTvs()
    {
        return $this->formatMovies($this->popular_tvs);
    }

    public function genres()
    {
        return collect($this->genres)->mapWithKeys(function($genre){
            return [ $genre['id'] => $genre['name'] ];
        });
    }

    public function topRatedTvs()
    {
        return $this->formatMovies($this->top_rated);
    }

    public function formatMovies($tv)
    {
        return collect($tv)->map(function($tvshow){
            $genres_formatted = collect($tvshow['genre_ids'])->mapWithKeys(function($value){
                return [$value => $this->genres()->get($value)];
            })->implode(', ');

            return collect($tvshow)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500/' . $tvshow['poster_path'],
                'vote_average' => ($tvshow['vote_average'] * 10 ). '%',
                'first_air_date' => \Carbon\Carbon::parse($tvshow['first_air_date'])->format('M d, Y'),
                'genres' => $genres_formatted,
            ])->only([
                'poster_path', 'id', 'genre_ids', 'name', 'vote_average', 'overview', 'first_air_date', 'genres'
            ]);
        });
    }
}
