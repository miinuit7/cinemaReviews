<form class="flex" method="GET" action="{{ route('search') }}">
    <div class="form-group mr-2">
        <input type="search" class="form-control w-full" name="query" value="{{ request('query') }}" placeholder="キーワードを入力" aria-label="検索..." size="70">
    </div>
    <x-primary-button class="w-90">
      検索
    </x-primary-button>
</form>
