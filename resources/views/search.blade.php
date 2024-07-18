<x-app-layout>
    <div class="flex justify-center mt-5 w-auto">
        <x-searchbar></x-searchbar>
    </div>
    @if(isset($results))
    @if(count($results) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
        @foreach($results as $result)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-700 flex flex-col overflow-hidden">
            <a href="{{ route('detail.show', ['id' => $result['id']]) }}" class="flex flex-col h-full">
                <img src="https://image.tmdb.org/t/p/w500{{ $result['poster_path'] }}" alt="Poster" class="w-full h-60 object-contain">
                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div class="flex items-center">
                        <p class="text-2xl font-bold flex-grow">{{ $result['title'] }}</p>
                        <x-favorite-button :movie="$result" />
                    </div>
                    <p class="text-xs">{{ $result['original_title'] }}</p>
                    <div class="mt-2 flex-grow overflow-auto">
                        <p class="text-lg">{{ mb_substr($result['overview'], 0, 94) }}{{ mb_strlen($result['overview']) > 94 ? '...' : '' }}</p>
                    </div>
                    <p class="text-emerald-400 text-right mt-4">>>続きを読む</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center mt-5 text-2xl">検索結果が見つかりませんでした。</p>
    @endif
    @endif
</x-app-layout>