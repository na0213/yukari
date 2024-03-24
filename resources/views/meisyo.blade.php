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
                <a href="" class="mr-5 hover:text-gray-900">地域名所</a>
                <a href="" class="mr-5 hover:text-gray-900">地域称号</a>
                <a href="" class="mr-5 hover:text-gray-900">マイページ</a>
              </nav>
              <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">Button
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
              </button>
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

                <!-- カード1 -->
                
         <!-- 現在の本 -->
        @if (count($places) > 0)
            @foreach ($places as $place)
                <x-collection id="{{ $place->id }}" info="{{ $place->place_info }}" >{{ $place->place_name }}</x-collection>
            @endforeach
        @endif
    </div>
            </div>
        </div>
      </section>
</body>
</html>