<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace — DocuSen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold">Docu<span class="text-orange-500">Sen</span></h1>
        <div class="flex items-center gap-4">
            <a href="{{ route('citizen.requests.index') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Mes demandes
            </a>
            <a href="{{ route('citizen.requests.create') }}"
                class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                + Nouvelle demande
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-blue-200 hover:text-red-500 text-sm transition">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">

        {{-- Message de bienvenue --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-blue-900">
                Bonjour, {{ $user->nom }} 👋
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Bienvenue sur votre espace citoyen DocuSen
            </p>
        </div>

        {{-- Messages flash --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Cartes statistiques --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">
    {{-- Total --}}
    <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-xl">
            📋
        </div>
        <div>
            <p class="text-2xl font-bold text-blue-900">{{ $stats['total'] }}</p>
            <p class="text-gray-400 text-xs mt-0.5">Total</p>
        </div>
    </div>
    {{-- En attente --}}
    <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-xl">
            ⏳
        </div>
        <div>
            <p class="text-2xl font-bold text-orange-500">{{ $stats['en_attente'] }}</p>
            <p class="text-gray-400 text-xs mt-0.5">En attente</p>
        </div>
    </div>
    {{-- En traitement --}}
    <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-xl">
            🔄
        </div>
        <div>
            <p class="text-2xl font-bold text-blue-500">{{ $stats['en_traitement'] }}</p>
            <p class="text-gray-400 text-xs mt-0.5">En traitement</p>
        </div>
    </div>
    {{-- Approuvées --}}
    <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-xl">
            ✅
        </div>
        <div>
            <p class="text-2xl font-bold text-green-600">{{ $stats['approuve'] }}</p>
            <p class="text-gray-400 text-xs mt-0.5">Approuvées</p>
        </div>
    </div>
    {{-- Rejetées --}}
    <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-xl">
            ❌
        </div>
        <div>
            <p class="text-2xl font-bold text-red-500">{{ $stats['rejete'] }}</p>
            <p class="text-gray-400 text-xs mt-0.5">Rejetées</p>
        </div>
    </div>

</div>

        {{-- Dernières demandes --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-blue-900 text-lg">Dernières demandes</h3>
                <a href="{{ route('citizen.requests.index') }}"
                    class="text-orange-500 text-sm font-semibold hover:underline">
                    Voir tout →
                </a>
            </div>

            @if($dernieresDemandes->count() > 0)
                <div class="flex flex-col gap-3">
                    @foreach($dernieresDemandes as $demande)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg">
                                    📄
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">
                                        {{ $demande->documentType->nom }}
                                    </p>
                                    <p class="text-gray-400 text-xs mt-0.5">
                                        {{ $demande->numero_reference }} —
                                        {{ $demande->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $demande->statutBadge() }}">
                                    {{ $demande->statutLabel() }}
                                </span>
                                <a href="{{ route('citizen.requests.show', $demande->id) }}"
                                    class="text-blue-900 text-xs font-semibold hover:text-orange-500 transition">
                                    Détails →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-4xl mb-3">📭</p>
                    <p class="text-gray-500 text-sm">Aucune demande pour le moment</p>
                    <a href="{{ route('citizen.requests.create') }}"
                        class="inline-block mt-4 bg-blue-900 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
                        Faire une demande
                    </a>
                </div>
            @endif
        </div>

    </div>

</body>
</html>