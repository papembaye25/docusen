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
    <nav class="bg-blue-900 text-white shadow-lg sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">
                Docu<span class="text-orange-500">Sen</span>
            </a>

            {{-- Desktop --}}
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('citizen.dashboard') }}"
                    class="text-blue-200 hover:text-white text-sm transition">
                    Dashboard
                </a>
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
                    <button type="submit" class="text-blue-200 hover:text-white text-sm transition">
                        Déconnexion
                    </button>
                </form>
            </div>

            {{-- Hamburger --}}
            <button @click="open = !open" class="md:hidden focus:outline-none">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Menu mobile --}}
        <div x-show="open" x-transition class="md:hidden bg-blue-800 px-4 py-4 flex flex-col gap-3">
            <a href="{{ route('citizen.dashboard') }}" class="text-blue-200 text-sm">Dashboard</a>
            <a href="{{ route('citizen.requests.index') }}" class="text-blue-200 text-sm">Mes demandes</a>
            <a href="{{ route('citizen.requests.create') }}"
                class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold text-center">
                + Nouvelle demande
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-blue-200 text-sm w-full text-left">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Message de bienvenue --}}
        <div class="mb-6">
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
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center text-center">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg mb-2">📋</div>
                <p class="text-2xl font-bold text-blue-900">{{ $stats['total'] }}</p>
                <p class="text-gray-400 text-xs mt-0.5">Total</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center text-center">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-lg mb-2">⏳</div>
                <p class="text-2xl font-bold text-orange-500">{{ $stats['en_attente'] }}</p>
                <p class="text-gray-400 text-xs mt-0.5">En attente</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center text-center">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg mb-2">🔄</div>
                <p class="text-2xl font-bold text-blue-500">{{ $stats['en_traitement'] }}</p>
                <p class="text-gray-400 text-xs mt-0.5">En traitement</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center text-center">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-lg mb-2">✅</div>
                <p class="text-2xl font-bold text-green-600">{{ $stats['approuve'] }}</p>
                <p class="text-gray-400 text-xs mt-0.5">Approuvées</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center text-center col-span-2 md:col-span-1">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-lg mb-2">❌</div>
                <p class="text-2xl font-bold text-red-500">{{ $stats['rejete'] }}</p>
                <p class="text-gray-400 text-xs mt-0.5">Rejetées</p>
            </div>
        </div>

        {{-- Bouton nouvelle demande mobile --}}
        <div class="md:hidden mb-6">
            <a href="{{ route('citizen.requests.create') }}"
                class="block bg-orange-500 text-white py-3 rounded-xl font-semibold text-center hover:bg-orange-600 transition">
                + Nouvelle demande
            </a>
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
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">
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
                            <div class="flex items-center gap-3 ml-13">
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