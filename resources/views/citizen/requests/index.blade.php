<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes demandes — DocuSen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold">Docu<span class="text-orange-500">Sen</span></h1>
        <div class="flex items-center gap-4">
            <a href="{{ route('citizen.dashboard') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">

        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-blue-900">Mes demandes</h2>
                <p class="text-gray-500 text-sm mt-1">Historique de toutes vos demandes</p>
            </div>
            <a href="{{ route('citizen.requests.create') }}"
                class="bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800 transition shadow">
                + Nouvelle demande
            </a>
        </div>

        {{-- Message succès --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Table des demandes --}}
        @if($demandes->count() > 0)
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Référence</th>
                            <th class="px-4 py-3 text-left font-semibold">Document</th>
                            <th class="px-4 py-3 text-left font-semibold">Date</th>
                            <th class="px-4 py-3 text-left font-semibold">Statut</th>
                            <th class="px-4 py-3 text-left font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demandes as $demande)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-mono font-bold text-blue-900">
                                {{ $demande->numero_reference }}
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ $demande->documentType->nom }}
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ $demande->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $demande->statutBadge() }}">
                                    {{ $demande->statutLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('citizen.requests.show', $demande->id) }}"
                                    class="text-blue-900 font-semibold hover:text-orange-500 transition text-xs">
                                    Voir détails →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $demandes->links() }}
            </div>

        @else
            {{-- Aucune demande --}}
            <div class="bg-white rounded-2xl shadow p-12 text-center">
                <p class="text-5xl mb-4">📭</p>
                <h3 class="text-xl font-bold text-blue-900 mb-2">Aucune demande pour le moment</h3>
                <p class="text-gray-500 mb-6">Commencez par soumettre votre première demande de document.</p>
                <a href="{{ route('citizen.requests.create') }}"
                    class="bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800 transition">
                    Faire une demande
                </a>
            </div>
        @endif

    </div>

</body>
</html>