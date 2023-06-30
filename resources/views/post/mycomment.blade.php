<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            コメントした投稿一覧
        </h2>

        <x-message :message="session('message')" />

    </x-slot>

    {{-- 投稿一覧表示用のコード --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (count($comments) == 0)
        <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <p class="mt-4 ml-12 font-semibold text-[30px] ">
                                あなたはまだコメントしていません!
                            </p>
                        </div>
                    </div>
                </div>
        </div>
        @else
        @foreach ($comments->unique('post_id') as $comment)
            @php
                $post=$comment->post;
            @endphp
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    @if ($post->category === '施術')
                    <div class="text-blue-600 text-center  w-20 bg-blue-200 mb-2 rounded">{{ $post->category }}</div>
                    @else
                    <div class="text-orange-600 text-center w-20 bg-orange-200 mb-2 rounded">{{ $post->category }}</div>
                    @endif
                    <div class="bg-white w-full  rounded-2xl px-10 pt-2 pb-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="flex">
                            <div class="rounded-full w-12 h-12">
                                {{-- アバター表示 --}}
                                <img src="{{asset('storage/avatar/'.($post->user->avatar??'user_default.jpg'))}}" class="rounded-full">
                            </div>
                            <h1 class="text-xl text-indigo-700 font-semibold hover:underline cursor-pointer float-left pt-3 ml-4">
                                <a href="{{route('post.show', $post)}}">{{ $post->title }}</a>
                            </h1>
                        </div>
                        <hr class="w-full">
                        <div class="flex justify-end mt-4">
                        <a href="{{route('post.show', $post)}}"><x-primary-button class="float-right">詳細へ</x-primary-button></a>
                        </div>
                        <p class="mt-4 text-gray-600 py-4">{{Str::limit ($post->body, 100, '...') }}</p>
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            <p>{{ $post->user->name??'削除されたユーザー' }}•{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                        <hr class="w-full mb-2">
                        @if ($post->comments->count())
                        <span class="badge">
                            返信 {{$post->comments->count()}}件
                        </span>
                        @else
                        <span class="badge2">コメントなし</span>
                        @endif
                        @if($post->category === '施術')
                            @if($post->user_id === Auth()->user()->id)
                            <a href="{{route('post.show', $post)}}" style="color:white;">
                            <x-primary-button class="float-right">コメントする</x-primary-button>
                            </a>
                            @else
                            @can('admin')
                            <a href="{{route('post.show', $post)}}" style="color:white;">
                            <x-primary-button class="float-right">コメントする</x-primary-button>
                            </a>
                            @endcan
                            @endif
                        @else
                        <a href="{{route('post.show', $post)}}" style="color:white;">
                            <x-primary-button class="float-right">コメントする</x-primary-button>
                        </a>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</x-app-layout>
