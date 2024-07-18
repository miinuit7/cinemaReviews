<x-app-layout>
    <div class="container mx-auto mt-5 mb-14">
        <div class="flex justify-center mb-5">
            <x-searchbar></x-searchbar>
        </div>
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-700 p-4">
            <div class="flex flex-col md:flex-row">
                <img src="https://image.tmdb.org/t/p/w500{{ $detail['poster_path'] }}" alt="Poster" class="w-full md:w-1/4 rounded-lg mb-4 md:mb-0 md:mr-4">
                <div class="flex flex-col justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">{{ $detail['title'] }}</h1>
                        <h2 class="text-lg text-gray-500 mb-4">{{ $detail['original_title'] }}</h2>
                        <!-- 平均点表示 -->
                        @php
                        $averageRating = $reviews->avg('rating');
                        @endphp
                        <div class="flex items-center mb-4">
                            <div class="flex">
                                @for ($i = 0; $i < 5; $i++) <svg class="w-6 h-6 {{ $i < $averageRating ? 'text-yellow-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.465 9.384c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.957z" />
                                    </svg>
                                    @endfor
                            </div>
                        </div>
                        <p class="text-base mb-4">{{ $detail['overview'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- レビュー投稿箇所 -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            @auth
            <form method="post" action="{{ route('review.store') }}" onsubmit="reloadPage()">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $detail['id'] }}">
                <div class="mb-4">
                    <label for="body" class="block text-gray-700 text-sm font-bold mb-2">レビュー投稿:</label>
                    <!-- 星評価 -->
                    <div id="star">
                        <star-rating v-model="rating" :star-size="30" class="pb-3" :increment="1" name="rating"></star-rating>
                        <input type="hidden" name="rating" :value="rating">
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
                    <script src="https://unpkg.com/vue-star-rating/dist/star-rating.min.js"></script>
                    <script>
                        Vue.component('star-rating', window['vue-star-rating'].default);

                        new Vue({
                            el: '#star',
                            data: {
                                rating: 0
                            }
                        });
                    </script>
                    <!-- テキストフォーム -->
                    <textarea name="body" id="body" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="レビュー内容を入力してください">{{ old('body') }}</textarea>
                </div>
                <div class="mt-2 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">投稿する</button>
                </div>
            </form>
            @else
            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                <label for="body" class="block text-gray-700 text-sm font-bold mb-2">レビュー投稿:</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-2" placeholder="レビューの入力にはログインが必要です" disabled></textarea>
                <div class="mt-2 flex justify-end">
                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">ログイン</a>
                    <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">会員登録</a>
                </div>
            </div>
            @endauth
        </div>

        <!-- レビュー表示箇所 -->
        <div id="reviews" class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold mb-4 text-center">レビュー一覧</h2>
            @if($reviews->isEmpty())
            <p class="text-center text-gray-500">この映画にはまだレビューが投稿されていません。</p>
            @else
            @foreach($reviews as $review)
            <div class="bg-gray-100 p-4 rounded-lg mb-4 shadow-md">
                <div class="text-sm font-semibold ml-1">
                    <p class="text-xl text-gray-500">{{ $review->user->name }}</p>
                </div>
                <!-- 星評価表示 -->
                <div class="flex items-center">
                    @for ($i = 0; $i < 5; $i++) <svg class="w-6 h-6 {{ $i < $review->rating ? 'text-yellow-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.465 9.384c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.957z" />
                        </svg>
                        @endfor
                </div>
                <div v-if="isEditing[{{ $review->id }}]">
                    <textarea v-model="editBody[{{ $review->id }}]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    <div class="flex justify-end mt-2">
                        <button @click="saveEdit({{ $review->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline mr-2">保存</button>
                        <button @click="cancelEdit({{ $review->id }})" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline">キャンセル</button>
                    </div>
                </div>
                <p v-else id="review-body-{{ $review->id }}" class="text-base mt-2">{{ $review->body }}</p>
                <div class="text-right">
                    <p class="text-xs text-gray-500">{{ $review->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <!-- 編集・削除ボタン -->
                @if(Auth::check() && Auth::user()->id == $review->user_id)
                <div class="flex justify-end mt-2">
                    <button @click="editReview({{ $review->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline mr-2">編集</button>
                    <form method="POST" action="{{ route('review.destroy', $review->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline">削除</button>
                    </form>
                </div>
                @endif

                <!-- コメント表示 -->
                <div class="mt-4">
                    <h3 class="text-lg font-bold mb-2">
                        <i class="material-icons text-base">comment</i> コメント ({{ $review->comments->count() }})
                    </h3>
                    @foreach($review->comments as $comment)
                    <div class="bg-white p-2 rounded-lg shadow-md mb-2">
                        <p class="text-sm text-gray-700">{{ $comment->user->name }}: {{ $comment->body }}</p>
                        <p class="text-xs text-gray-500 text-right">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- コメント投稿フォーム -->
                @auth
                <div class="mt-4">
                    <a href="javascript:void(0);" onclick="toggleCommentForm({{ $review->id }})" id="comment-link-{{ $review->id }}" class="text-blue-500 hover:underline">コメントする</a>
                    <form id="comment-form-{{ $review->id }}" method="post" action="{{ route('comment.store') }}" class="mt-4 hidden">
                        @csrf
                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                        <textarea name="body" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="コメントを入力してください">{{ old('body') }}</textarea>
                        <div class="mt-2 flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">投稿する</button>
                        </div>
                    </form>
                </div>
                @endauth
            </div>
            @endforeach
            @endif
        </div>

        <!-- 後で消す　APIで取得したデータをconsoleに出力するJS) -->
        <!-- <script>
            let detail = @json($detail);
            console.log(detail);
        </script> -->
</x-app-layout>

<script>
    new Vue({
        el: '.container',
        data: {
            isEditing: {},
            editBody: {}
        },
        methods: {
            editReview(reviewId) {
                this.$set(this.isEditing, reviewId, true);
                const reviewBodyElement = document.querySelector(`#review-body-${reviewId}`);
                if (reviewBodyElement) {
                    this.$set(this.editBody, reviewId, reviewBodyElement.innerText.trim());
                } else {
                    console.error(`Element #review-body-${reviewId} not found`);
                }
            },
            saveEdit(reviewId) {
                fetch(`/reviews/${reviewId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        body: this.editBody[reviewId]
                    })
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                }).then(data => {
                    if (data.success) {
                        this.isEditing[reviewId] = false;
                        const reviewBodyElement = document.querySelector(`#review-body-${reviewId}`);
                        if (reviewBodyElement) {
                            reviewBodyElement.innerText = this.editBody[reviewId];
                        } else {
                            console.error(`Element #review-body-${reviewId} not found`);
                        }
                        // ページをリロード
                        location.reload();
                    } else {
                        alert('保存に失敗しました。');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('保存に失敗しました。');
                });
            },
            cancelEdit(reviewId) {
                this.isEditing[reviewId] = false;
            }
        }
    });
</script>

<script>
    function toggleCommentForm(reviewId) {
        const form = document.getElementById(`comment-form-${reviewId}`);
        const link = document.getElementById(`comment-link-${reviewId}`);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            link.classList.add('hidden');
        } else {
            form.classList.add('hidden');
            link.classList.remove('hidden');
        }
    }
</script>