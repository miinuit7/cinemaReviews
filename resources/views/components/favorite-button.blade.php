@props(['movie'])

@auth
    @php
        $favorites = Auth::user()->favorites ?? collect();
        $isFavorite = $favorites->contains('movie_id', $movie['id']);
    @endphp
    <form action="{{ $isFavorite ? route('favorites.destroy', ['id' => $movie['id']]) : route('favorites.store') }}" method="POST" class="ml-4">
        @csrf
        @if($isFavorite)
            @method('DELETE')
            <button type="submit" class="ml-2">
                <span class="material-icons text-red-500">favorite</span>
            </button>
        @else
            <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
            <button type="submit" class="ml-2">
                <span class="material-icons text-blue-500">favorite_border</span>
            </button>
        @endif
    </form>
@endauth