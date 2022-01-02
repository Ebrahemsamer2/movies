<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class ActorsViewModel extends ViewModel
{
    public $popular_actors;
    public $page;
    public function __construct( $popular_actors, $page)
    {
        $this->page = $page;
        $this->popular_actors = $popular_actors;
    }

    public function popular_actors()
    {
        return collect($this->popular_actors)->map(function($actor){
            return collect($actor)->merge([
                'profile_path' => $actor['profile_path'] ? 
                'https://image.tmdb.org/t/p/w235_and_h235_face/' . $actor['profile_path']
                : 'https://via.placeholder.com/300x450',
                'known_for' => collect( $actor['known_for'] )->where('media_type', 'movie')->pluck('title')
                                ->union( collect( $actor['known_for'] )->where('media_type', 'tv')->pluck('name') )
                                ->implode(', ')
            ])->only([
                'profile_path', 'id', 'name', 'known_for'
            ]);
        });
    }

    public function previous()
    {
        return $this->page > 1 ? $this->page - 1 : null;
    }

    public function next()
    {
        return $this->page < 500 ? $this->page + 1 : null;
    }
    
}
