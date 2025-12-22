<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - NutriGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-emerald-600">403</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mt-4">Akses Ditolak</h2>
        <p class="text-gray-600 mt-2 mb-8">Maaf, Anda tidak memiliki izin untuk masuk ke area ini.</p>
        
        <div class="flex justify-center gap-4">
            <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-bold">
                Kembali ke Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-bold">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</body>
</html>
