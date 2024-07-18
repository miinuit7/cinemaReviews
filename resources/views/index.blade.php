<x-app-layout>
    <div class="flex justify-center mt-5 w-auto">
        <x-searchbar></x-searchbar>
    </div>
    <div>
        <p class="mt-5 text-4xl ml-12">人気の映画</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
        @foreach($movies as $movie)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-700 flex flex-col overflow-hidden">
            <a href="{{ route('detail.show', ['id' => $movie['id']]) }}" class="flex flex-col h-full">
                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="Poster" class="w-full h-60 object-contain">
                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div class="flex items-center">
                        <p class="text-2xl font-bold flex-grow">{{ $movie['title'] }}</p>
                        <x-favorite-button :movie="$movie" />
                    </div>
                    <p class="text-xs">{{ $movie['original_title'] }}</p>
                    <div class="mt-2 flex-grow overflow-auto">
                        <p class="text-lg">{{ mb_substr($movie['overview'], 0, 94) }}{{ mb_strlen($movie['overview']) > 94 ? '...' : '' }}</p>
                    </div>
                    <p class="text-emerald-400 text-right mt-4">>>続きを読む</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>


    <script>
        // 後で消す　APIで取得したデータをconsoleに出力するコード（JS)
        let movies = @json($movies);
        console.log(movies);
    </script>

    <x-footer></x-footer>
</x-app-layout>