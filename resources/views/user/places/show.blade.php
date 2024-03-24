<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-wrap w-full mb-20">
            <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
              <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">{{ $place->place_name }}</h1>
              <div class="h-1 w-20 bg-green-500 rounded animate-pulse"></div>
            </div>
            <p class="lg:w-1/2 w-full leading-relaxed text-gray-500">QRコードを読み込んでポイントをゲットしよう！</p>
          </div>
          <p><span class="text-red-600 font-bold text-2xl">{{ $place->place_point }}</span>ポイントゲットできるよ</p>
          <div class="w-full px-5 py-24 mx-auto">
            <div class="flex flex-wrap -m-4">
              <div class="w-full p-4">
                <div class="bg-gradient-to-r from-green-400 to-green-600 p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <img class="h-100 rounded w-full object-cover object-center mb-6" src="{{ $place->place_image }}" alt="content">
                    <p class="text-white leading-relaxed text-base">{!! nl2br(e($place->place_info)) !!}</p>

                </div>
            </div>
            </div>
          </div>
        </div>
    </section>
</x-app-layout>