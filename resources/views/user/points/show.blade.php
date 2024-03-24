<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <h2 class="text-2xl font-bold">{{ $region->name }}</h2>
                    <p>合計ポイント: {{ $totalPoints }}</p>
                    @if ($title)
                        <h3 class="mt-10 mb-10 text-xl font-bold">称号: {{ $title->title_name }}</h3>
                        <img src="{{ $title->image }}" alt="称号画像" style="margin: auto; display: block;">
                    @else
                        <p>称号はありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>
