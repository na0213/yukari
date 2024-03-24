<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($points->groupBy('region_id') as $regionId => $regionPoints)
                @php
                    $region = $regionPoints->first()->region;
                    $totalPoints = $regionPoints->sum('point'); // 各regionのポイントを合計
                @endphp
                <div class="mb-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                        <h3 class="text-lg font-bold">{{ $region->name }}</h3>
                        <span><a href="{{ route('user.points.show', $regionId) }}">{{ $totalPoints }} ポイント ▶︎</a></span>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        名所
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        ポイント
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        獲得日時
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($regionPoints as $point)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $point->title }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $point->point }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $point->created_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
</x-app-layout>