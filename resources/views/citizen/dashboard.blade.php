<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — DocuSen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="min-h-screen">

        {{-- Navbar --}}
        <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">DocuSen</h1>
            <div class="flex items-center gap-4">
                <span>Bonjour, {{ auth()->user()->nom }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-orange-500 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-orange-600">
                        Déconnexion
                    </button>
                </form>
            </div>
        </nav>

        {{-- Contenu --}}
        <div class="max-w-4xl mx-auto mt-10 px-4">
            <h2 class="text-2xl font-bold text-blue-900 mb-6">
                Bienvenue sur votre espace citoyen 👋
            </h2>

            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-gray-600">
                    Vous êtes connecté en tant que
                    <span class="font-bold text-blue-900">{{ auth()->user()->nom }}</span>
                </p>
                <p class="text-gray-600 mt-2">
                    Email : {{ auth()->user()->email }}
                </p>
                <p class="text-gray-600 mt-2">
                    Rôle : <span class="font-bold text-orange-500">{{ auth()->user()->role }}</span>
                </p>
            </div>
        </div>

    </div>

</body>
</html>