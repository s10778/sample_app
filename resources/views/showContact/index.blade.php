<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      お問い合わせ一覧
    </h2>
    <x-message :message="session('message')" />
  </x-slot>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="my-6">
      <table class="text-left w-full border-collapse mt-8">
        <tr class="bg-green-600">
          <th class="p-3 text-left text-white">id</th>
          <th class="p-3 text-left text-white">mail</th>
          <th class="p-3 text-left text-white">タイトル</th>
          <th class="p-3 text-left text-white">本文</th>
          <th class="p-3 text-left text-white">編集</th>
          <th class="p-3 text-left text-white">削除</th>
        </tr>
        @foreach($contacts as $contact)
            <tr class="bg-white">
              <td class="border-gray-light border hover:bg-gray-100 p-3">{{$contact->id}}</td>
              <td class="border-gray-light border hover:bg-gray-100 p-3">{{$contact->email}}</td>
              <td class="border-gray-light border hover:bg-gray-100 p-3">{{$contact->title}}</td>
              <td class="border-gray-light border hover:bg-gray-100 p-3">{{Str::limit ($contact->body, 10, '...')}}</td>
              <td class="border-gray-light border hover:bg-gray-100 p-3">
                  <a href="{{route('showContact.show', $contact)}}">
                    <x-primary-button class="bg-teal-700">詳細へ</x-primary-button>
                  </a>
              </td>
              <td class="border-gray-light border hover:bg-gray-100 p-3">
                  <form method="post" action="{{route('showContact.delete', $contact)}}">
                      @csrf
                      @method('delete')
                      <x-primary-button class="bg-red-700" onClick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                  </form>
              </td>
            </tr>
        @endforeach
      </table>
    </div>
  </div>
</x-app-layout>
