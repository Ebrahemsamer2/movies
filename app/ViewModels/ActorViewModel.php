<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class ActorViewModel extends ViewModel
{
    public $actor;
    public $social;
    public $credits;

    public function __construct($actor, $social, $credits)
    {
        $this->actor = $actor;
        $this->social = $social;
        $this->credits = $credits;
    }

    public function actor()
    {
        return collect($this->actor)->merge([
            'birthday' => \Carbon\Carbon::parse( $this->actor['birthday'] )->format('M d, Y'),
            'age' => \Carbon\Carbon::parse( $this->actor['birthday'] )->age,
            'profile_path' =>  $this->actor['profile_path'] ? 
            'https://image.tmdb.org/t/p/w300/' . $this->actor['profile_path']
            : 'https://www.via.placeholder.com/300x450',
        ]);
    }

    public function social()
    {
        return collect( $this->social )->merge([
            'facebook' => $this->social['facebook_id'] ? 'https://facebook.com/' . $this->social['facebook_id'] : null,
            'twitter' => $this->social['twitter_id'] ? 'https://twitter.com/' . $this->social['twitter_id'] : null,
            'instagram' => $this->social['instagram_id'] ? 'https://instagram.com/' . $this->social['instagram_id'] : null,
        ]);
    }

    public function knownForMovies()
    {
        $cast_movies = collect( $this->credits )->get('cast');

        return collect($cast_movies)->sortByDesc('popularity')->take(5)->map(function($movie){
            if( isset($movie['title']) )
            {
                $title = $movie['title'];
            }else if( isset($movie['name']) )
            {
                $title = $movie['name'];
            }else 
            {
                $title = "Untitled";
            }
            
            return collect($movie)->merge([
                'poster_path' => $movie['poster_path'] 
                    ? 'https://image.tmdb.org/t/p/w185/' . $movie['poster_path']
                    : 'https://via.placeholder.com/185x278',
                
                'title' => $title,
                'linkToPage' => $movie['media_type'] == 'movie'
                ? route('movies.show', $movie['id'])
                : route('tv.show', $movie['id']),
            ]);
        });
    }

    public function credits()
    {
        $cast_movies = collect( $this->credits )->get('cast');
        return collect($cast_movies)->map(function($movie){
            if( isset( $movie['release_date'] ) )
            {
                $release_date = $movie['release_date'];
            }else if ( isset( $movie['first_air_date'] ) )
            {
                $release_date = $movie['first_air_date'];
            }else 
            {
                $release_date = '';
            }

            if( isset( $movie['title'] ) )
            {
                $title = $movie['title'];
            }else if ( isset( $movie['name'] ) )
            {
                $title = $movie['name'];
            }else 
            {
                $title = 'Untitled';
            }

            return collect($movie)->merge([
                'release_date' => $release_date,
                'release_year' => isset($release_date) ? \Carbon\Carbon::parse( $release_date )->format('Y') : 'Future',
                'title' => $title,
                'character' => isset($movie['character']) ? $movie['character'] : '',
            ]);
        })->sortByDesc('release_date');
    }
}
