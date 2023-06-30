<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      お問い合わせ詳細
    </h2>
    <x-message :message="session('message')" />
  </x-slot>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-yellow-50 h-screen">
      <div class="mx-4 sm:p-8">
          <div class="w-full flex flex-col">
              <div class="font-semibold leading-none mt-4">id</div>
              <p>{{$contact->id}}</p>
          </div>
          <div class="w-full flex flex-col">
              <div class="font-semibold leading-none mt-4">email</div>
              <p>{{$contact->email}}</p>
          </div>
          <div class="w-full flex flex-col">
              <div class="font-semibold leading-none mt-4">タイトル</div>
              <p>{{$contact->title}}</p>
          </div>
          <div class="w-full flex flex-col mb-5">
              <div class="font-semibold leading-none mt-4">本文</div>
              <p>{{$contact->body}}</p>
          </div>


          <a href="/showContact/index">
          <x-secondary-button class="ml-3">
              戻る
          </x-secondary-button>
          </a>
      </div>
  </div>
</x-app-layout>
