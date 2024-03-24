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
            <a href="/">
            <span class="ml-3 text-xl">Yukari</span>
            </a>
          </a>
          <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
            <a href="{{ route('guest.regions.index') }}">
                <div class="mr-5 text-black hover:text-green-600">地域名所</div>
            </a>
            <a href="" class="mr-5 text-black hover:text-green-600">ログイン</a>
            <a href="" class="mr-5 text-black hover:text-green-600">新規登録</a>
          </nav>
        </div>
      </header>
      <!-- header -->
          
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
</body>
</html>