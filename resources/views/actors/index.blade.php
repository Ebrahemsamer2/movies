@extends('layouts.main')

@section('content')
	
	<div class="container mx-auto px-16 py-16">
		<div class="popular-movies">
			<h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Movies</h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach($popular_actors as $actor)

                    <div class="actor mt-8">
                        <a href="{{ route('actors.show', $actor['id']) }}">
                            <img 
                            class='hover:opacity-75 transition ease-in-out duration-150'
                            src="{{ $actor['profile_path'] }}" 
                            alt="{{ $actor['name'] }} Profile Image">
                        </a>
                        <div class='mt-2'>
                            <a class='text-lg hover:text-gray-300' href="#">{{ $actor['name'] }}</a>
                            <div class='text-sm truncate text-gray-400'>
                                {{ $actor['known_for'] }}
                            </div>
                        </div>
                    </div>

                @endforeach
			</div>
		</div>

        <!-- <div class="flex justify-between mt-16">
            @if( $previous )
                <a href="/actors/page/{{ $previous }}">Previous</a>
            @else 
            <div></div>
            @endif

            @if($next)
                <a href="/actors/page/{{ $next }}">Next</a>
            @else 
            <div></div>
            @endif
        </div> -->


        <div class="page-load-status my-8">

            <div class='flex justify-center'>
                <div class='infinite-scroll-request spinner my-8 text-4xl'>&nbsp;</div>
            </div>
            
            <p class="infinite-scroll-last">End of content</p>
            <p class="infinite-scroll-error">Error</p>
            
        </div>

	</div>
	
@endsection

@section('scripts')
<script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>

<script>
    let elem = document.querySelector('.grid');
    let infScroll = new InfiniteScroll( elem, {
        path: '/actors/page/@{{#}}',
        append: '.actor',
        status: 'page-load-status'
    });
</script>
@endsection