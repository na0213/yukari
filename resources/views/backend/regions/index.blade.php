<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            地域一覧
        </h2>
    </x-slot>

    <div class="mx-5 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <a href="{{ route('admin.backend.regions.create') }}">
              <button type="button" class="text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 text-lg">地域登録</button>
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
              編集
            </th>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              地域名
            </th>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              県名
            </th>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              名所
            </th>
            <th scope="col" class="px-6 py-2 whitespace-nowrap">
              称号
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse ($regions as $region)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $region->id }}
              </td>
              <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <a href="{{ route('admin.backend.regions.edit', $region->id) }}">
                  <button type="button" class="text-white bg-blue-500 border-0 py-1 px-4 focus:outline-none hover:bg-blue-600 rounded text-sm">編集</button>
                </a>
              </td>
              <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $region->name }}
              </td>
              <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $region->prefecture }}
              </td>
              <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <a href="{{ route('admin.backend.places.index', ['region' => $region->id]) }}">
                    <button type="button" class="text-white bg-yellow-500 border-0 py-1 px-4 focus:outline-none hover:bg-yellow-600 text-base">詳細</button>
                </a>
              </td>
              <td scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <a href="{{ route('admin.backend.titles.index', ['region' => $region->id]) }}">
                    <button type="button" class="text-white bg-orange-500 border-0 py-1 px-4 focus:outline-none hover:bg-orange-600 text-base">詳細</button>
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