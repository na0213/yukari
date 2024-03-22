<x-admin-layout>
  <x-slot name="header">
    <div class="flex">
      <a href="{{ route('admin.backend.regions.index') }}">
        <h2 class="text-xl text-gray-600 dark:text-gray-200 leading-tight">
          地域へ戻る
        </h2>
      </a>
      <h2 class="ml-10 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        称号一覧
      </h2>
    </div>
  </x-slot>

  <div class="mx-5 py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="mb-5 text-lg font-bold">【{{ $region->name }}】</h2>
        <a href="{{ route('admin.backend.titles.create', ['region' => $region->id]) }}">
          <button type="button" class="text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 text-lg">称号登録</button>
        </a>
      </div>
  </div>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-11/12 mx-auto mb-10 text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              ID
            </th>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              称号名
            </th>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              総ポイント
            </th>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              編集
            </th>
        </tr>
      </thead>
      <tbody>
        @forelse ($titles as $title)
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $title->id }}
            </td>
            <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $title->title_name }}
            </td>
            <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $title->total_point }}
            </td>
            <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              <a href="{{ route('admin.backend.titles.edit', ['region' => $region->id, 'title' => $title->id]) }}">
                  <button type="button" class="text-white bg-orange-500 border-0 py-1 px-4 focus:outline-none hover:bg-orange-600 text-base">編集</button>
                </a>
            </td>
          </tr>
          @empty
          <p class="p-5">まだ登録されていません。</p>
      @endforelse
      </tbody>
    </table>
  </div>
</x-admin-layout>