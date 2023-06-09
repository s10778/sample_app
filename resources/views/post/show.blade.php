<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿の個別表示
        </h2>

        <x-message :message="session('message')" />

    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="px-10 mt-4">
                <div class="bg-white w-full  rounded-2xl px-10 pt-2 pb-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="flex">
                            <div class="rounded-full w-12 h-12">
                                {{-- アバター表示 --}}
                                <img src="{{asset('storage/avatar/'.($post->user->avatar??'user_default.jpg'))}}" class="rounded-full">
                            </div>
                            <h1 class="text-xl font-semibold float-left pt-3 ml-4">
                                {{ $post->title }}
                            </h1>
                        </div>
                        <hr class="w-full">
                        <div class="flex justify-end mt-4">
                            @if($post->user_id === auth()->id())
                            <a href="{{route('post.edit', $post)}}"><x-primary-button class="bg-teal-700 float-right">編集</x-primary-button></a>
                            <form method="post" action="{{route('post.destroy', $post)}}">
                                @csrf
                                @method('delete')
                                <x-primary-button class="bg-red-700 float-right ml-4" onClick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                            </form>
                            @else
                            @can('admin')
                            <a href="{{route('post.edit', $post)}}"><x-primary-button class="bg-teal-700 float-right">編集</x-primary-button></a>
                            <form method="post" action="{{route('post.destroy', $post)}}">
                                @csrf
                                @method('delete')
                                <x-primary-button class="bg-red-700 float-right ml-4" onClick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                            </form>
                            @endcan
                            @endif
                            <a href="/post">
                                <x-secondary-button class="ml-3">
                                    戻る
                                </x-secondary-button>
                            </a>
                        </div>
                        <div>
                            <p class="mt-4 text-gray-600 py-4 overflow-hidden">{{$post->body}}</p>
                            @if(isset($post->image))
                            <img src="{{ asset('storage/images/'.$post->image) }}" class="mx-auto" style="height:300px;">
                            @endif
                            <div class="text-sm font-semibold flex flex-row-reverse">
                            <p> {{ $post->user->name??'削除されたユーザー' }} • {{$post->created_at->diffForHumans()}}</p>
                            </div>
                            <hr class="w-full mb-2">
                        </div>
                            <span>
                            {{-- もし$niceがあれば=ユーザーが「いいね」をしていたら --}}
                            @if($nice)
                            {{-- 「いいね」取消用ボタンを表示 --}}
                                <a href="{{ route('unnice', $post) }}" class="btn btn-success btn-sm">
                                    <img src="{{asset('logo/nicebutton.png')}}" width="30px" class="">
                                    いいね
                                    {{-- 「いいね」数を表示 --}}
                                    <span class="badge">
                                        {{ $post->nices->count() }}
                                    </span>
                                </a>
                            @else
                            {{-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 --}}
                                <a href="{{ route('nice', $post)}}" class="btn btn-secondary btn-sm">
                                    <img src="{{asset('logo/heart-regular.svg')}}" width="30px" class="">
                                    いいね
                                    {{-- 「いいね」の数を表示 --}}
                                    <span class="badge">
                                        {{ $post->nices->count() }}
                                    </span>
                                </a>
                            @endif
                            </span>
                    </div>
                </div>
                @foreach ($post->comments as $comment)
                <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500 mt-8">
                    {{$comment->body}}
                    <div class="text-sm font-semibold flex flex-row-reverse">
                        <p class="float-left pt-4"> {{ $comment->user->name??'削除されたユーザー' }} • {{$comment->created_at->diffForHumans()}}</p>
                        <span class="rounded-full w-10 h-10 mr-1 mt-1">
                        <img src="{{asset('storage/avatar/'.($comment->user->avatar??'user_default.jpg'))}}" class="rounded-full">
                        </span>
                    </div>
                </div>
                @endforeach
                @if($post->category === '施術')
                @can('admin')
                <div class="mt-4 mb-12">
                    <form method="post" action="{{route('comment.store')}}">
                        @csrf
                        <input type="hidden" name='post_id' value="{{$post->id}}">
                        <textarea name="body" class="bg-white w-full  rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500" id="body" cols="30" rows="3" placeholder="コメントを入力してください">{{old('body')}}</textarea>
                        <x-primary-button class="float-right mr-4 mb-12">コメントする</x-primary-button>
                    </form>
                </div>
                @endcan
                @else
                <div class="mt-4 mb-12">
                    <form method="post" action="{{route('comment.store')}}">
                        @csrf
                        <input type="hidden" name='post_id' value="{{$post->id}}">
                        <textarea name="body" class="bg-white w-full  rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500" id="body" cols="30" rows="3" placeholder="コメントを入力してください">{{old('body')}}</textarea>
                        <x-primary-button class="float-right mr-4 mb-12">コメントする</x-primary-button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
