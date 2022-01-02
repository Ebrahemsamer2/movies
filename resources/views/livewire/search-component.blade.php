<div class="relative mt-3 md:mt-0" 
x-data="{isOpen: true}" 
@click.away="isOpen=false">

    <input 
    wire:model.debounce.500ms="search" 
    x-ref="search"
    @keydown.window="if(event.keyCode === 191){ event.preventDefault();$refs.search.focus(); }"
    @focus="isOpen=true" 
    @keydown="isOpen=true"
    @keydown.escape.window="isOpen=false" 
    @keydown.shift.tab="isOpen=false"
    type="text" class="bg-gray-800 pl-8 rounded-full px-4 py-1 w-64 focus:outline-none focus:shadow-outline" placeholder="Search" name="search">
    <div class="absolute top-0">
        <svg class="fill-current w-4 text-gray-500 mt-2 ml-2" viewBox="0 0 24 24">
            <path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/></svg>
    </div>
    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>
    @if(strlen($search) >= 2)
        <div 
        class='z-50 absolute bg-gray-800 text-sm rounded w-64 mt-4' 
        x-show.transition.opacity="isOpen">

            @if( $search_results->count() > 0 )
            <ul>
                @foreach($search_results as $result)
                <li class='border-b border-gray-700'>
                    <a @if($loop->last) @keydown.tab="isOpen=false" @endif href="{{ route('movies.show', $result['id']) }}" class='block flex items-center hover:bg-gray-700 px-3 py-3'>
                        @if( $result['poster_path'] )
                            <img class='w-8' src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt="poster">
                        @else
                            <img class='w-8' src="https://via.placeholder.com/50x75" alt="poster">
                        @endif
                        <span class='ml-4'>{{ $result['title'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p class='px-3 py-3'>No Results For "{{ $search }}"</p>
            @endif
        </div>
    @endif
</div>