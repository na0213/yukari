<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
    <title>Document</title>
</head>
<body>
    <section class="text-gray-600 body-font flex justify-center items-center h-screen">
        <div class="container mx-auto">
            <div class="p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                <div class="mb-10 text-2xl text-center text-gray-500 dark:text-gray-400">Welcome to {{ $place->place_name }}</div>
                <p class="mb-10 text-center text-gray-500 dark:text-gray-400">
                    <span class="text-red-600 font-bold text-2xl">{{ $place->place_point }}</span>ポイント
                </p>
                <div class="flex justify-center">
                    <form action="{{ route('user.points.store', ['place' => $place->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            Get
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>