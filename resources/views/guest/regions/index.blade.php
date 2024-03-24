<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
    rel="stylesheet"
  />
    <title>Document</title>
</head>
<body>
    <!-- header -->
    <header class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
          <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24"> -->
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span class="ml-3 text-xl">Yukari</span>
          </a>
          <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
            <a href="{{ route('guest.regions.index') }}">
                <div class="mr-5 text-black hover:text-white">地域名所</div>
            </a>
            <a href="" class="mr-5 text-black hover:text-white">ログイン</a>
            <a href="" class="mr-5 text-black hover:text-white">新規登録</a>
          </nav>
        </div>
      </header>
      <!-- header -->
          
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-wrap w-full mb-20">
            <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
              <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">地域名所一覧</h1>
              <div class="h-1 w-20 bg-green-500 rounded animate-pulse"></div>
            </div>
            <p class="lg:w-1/2 w-full leading-relaxed text-gray-500">各名所を回って地域ポイントをゲットしよう！</p>
          </div>
          <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap -m-4">
                @forelse ($places as $place)
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gradient-to-r from-green-400 to-green-600 p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ $place->place_image }}" alt="content">
                        <h3 class="text-white text-xs font-medium title-font mb-2">{{ $place->region->name }}</h3>
                        <h2 class="text-white text-lg font-medium title-font mb-4">{{ $place->place_name }}</h2>
                        <p class="text-white leading-relaxed text-base">{{ $place->place_info }}</p>
                        <div class="flex items-center justify-end">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                @empty
                    <p>名所が登録されていません。</p>
                @endforelse
            </div>
          </div>
        </div>
      </section>
</body>
</html>