  <!-- 本: 削除ボタン -->
<div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gradient-to-r from-green-400 to-green-600 p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/720x400" alt="content">
                        <h3 class="text-white text-xs font-medium title-font mb-2">名前</h3>
                        <h2 class="text-white text-lg font-medium title-font mb-4">{{ $slot }}</h2>
                        <p class="text-white leading-relaxed text-base">{{ $info }}</p>
                        <div class="flex items-center justify-end">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <h1><a href="{{ url('edit2/'.$id) }}">詳細</a></h1>    
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
