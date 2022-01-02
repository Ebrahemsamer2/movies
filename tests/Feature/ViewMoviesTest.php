<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ViewMoviesTest extends TestCase
{
    public function the_main_page_shows_correctly()
    {
        // to fake the request ot the api
        // Http::fake([
        //     'https://api.themoviedb.org/3/movie/popular' => Http::response([

        //     ])
        // ]); 

        // $response = $this->get( route('movies.index') );
        // $response->assertSuccessful();
        // $response->assetSee('POPULAR MOVIES');
    }
}
