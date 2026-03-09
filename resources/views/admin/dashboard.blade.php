<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — DocuSen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="min-h-screen">

        {{-- Navbar --}}
        <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">DocuSen — Admin</h1>
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
                Tableau de bord Administrateur 🛠️
            </h2>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow p-6 flex items-center gap-4">
                    <div class="bg-blue-100 text-blue-900 text-3xl w-14 h-14 rounded-2xl flex items-center justify-center">
                        👥
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-blue-900">{{ $stats['total_users'] }}</p>
                        <p class="text-gray-500 text-sm">Citoyens inscrits</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow p-6 flex items-center gap-4">
                    <div class="bg-orange-100 text-orange-500 text-3xl w-14 h-14 rounded-2xl flex items-center justify-center">
                        🛡️
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-blue-900">{{ $stats['total_admins'] }}</p>
                        <p class="text-gray-500 text-sm">Administrateurs</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>