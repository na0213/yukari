<x-admin-layout>
    <x-slot name="header">
        <div class="flex">
            <a href="{{ route('admin.backend.titles.index', ['region' => $region->id]) }}">
              <h2 class="text-xl text-gray-600 dark:text-gray-200 leading-tight">
                戻る
              </h2>
            </a>
            <h2 class="ml-10 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
              称号一覧
            </h2>
          </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.backend.titles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- 地域IDを隠しフィールドで送信 -->
                <input type="hidden" name="region_id" value="{{ $region->id }}">

                <div class="p-2 w-4/5 mx-auto">
                    <div class="relative">
                        <label for="name" class="leading-7 text-sm text-gray-600">地域名<span class="text-red-600"></span></label>
                        <input type="text" id="name" value="{{ $region->name }}" readonly class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-yellow-500 focus:bg-white focus:ring-2 focus:ring-yellow-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                </div>

                <div class="-m-2">
                    <div class="p-2 w-4/5 mx-auto">
                        <div class="relative">
                        <label for="title_name" class="leading-7 text-sm text-gray-600">称号名<span class="text-red-600">　※必須</span></label>
                        <input type="text" id="title_name" name="title_name" value="{{ old('title_name')}}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-yellow-500 focus:bg-white focus:ring-2 focus:ring-yellow-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                </div>

                <div class="m-2">
                    <div class="p-2 w-4/5 mx-auto">
                        <div class="relative">
                            <label for="total_point" class="leading-7 text-sm text-gray-600">ポイント<span class="text-red-600">　※必須</span></label>
                            <input type="number" id="total_point" name="total_point" value="{{ old('total_point') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-yellow-500 focus:bg-white focus:ring-2 focus:ring-yellow-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                </div>

                <div class="flex-container mb-4">
                    <div class="image-input">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">画像<span class="text-red-600">（2MB以下　※必須）</span></label>
                        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(this, 'preview_image')" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        <div class="image-preview mt-2" id="preview_image">
                            <img src="{{ asset('storage/noimage.jpg') }}" alt="No Image" class="image-preview">
                        </div>
                    </div>
                </div>

                <div class="p-2 w-full flex justify-around mt-4">
                    <button type="submit" class="text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg">登録</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewImage(input, previewId) {
            const maxFileSize = 2 * 1024 * 1024; // 5MBをバイト単位で定義
    
            if (input.files && input.files[0]) {
                // ファイルサイズチェック
                if (input.files[0].size > maxFileSize) {
                    // ファイルサイズが5MBを超える場合
                    alert('ファイルサイズは5MB以下にしてください。');
                    input.value = ''; // 選択されたファイルをクリア
                    document.getElementById(previewId).innerHTML = '<img src="{{ asset('storage/noimage.jpg') }}" alt="No Image" style="width: 200px; height: auto;">'; // プレビューをデフォルト画像にリセット
                    return; // これ以上処理を続行しない
                }
    
                // ファイルサイズが1MB以下の場合、画像をプレビュー
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).innerHTML = '<img src="' + e.target.result + '" alt="Image preview" style="width: 200px; height: auto;">';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin-layout>