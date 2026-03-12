<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes — DocuSen Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold">Docu<span class="text-orange-500">Sen</span> <span class="text-sm font-normal text-blue-300">Admin</span></h1>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Dashboard
            </a>
            <a href="{{ route('admin.document-types.index') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Documents
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

    <div class="max-w-6xl mx-auto px-4 py-10">

        {{-- En-tête --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-blue-900">Toutes les demandes</h2>
            <p class="text-gray-500 text-sm mt-1">Gérez et traitez les demandes des citoyens</p>
        </div>

        {{-- Messages flash --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Filtres --}}
        <div class="bg-white rounded-2xl shadow p-4 mb-6">
            <form method="GET" action="{{ route('admin.requests.index') }}"
                class="flex flex-wrap gap-3 items-center">

                {{-- Recherche --}}
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Rechercher par nom, email ou référence..."
                    class="flex-1 min-w-48 px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm" />

                {{-- Filtre statut --}}
                <select name="statut"
                    class="px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en_traitement" {{ request('statut') == 'en_traitement' ? 'selected' : '' }}>En traitement</option>
                    <option value="approuve" {{ request('statut') == 'approuve' ? 'selected' : '' }}>Approuvées</option>
                    <option value="rejete" {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejetées</option>
                </select>

                <button type="submit"
                    class="bg-blue-900 text-white px-6 py-2 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
                    Filtrer
                </button>

                @if(request('search') || request('statut'))
                    <a href="{{ route('admin.requests.index') }}"
                        class="text-gray-500 text-sm hover:text-red-500 transition">
                        Réinitialiser
                    </a>
                @endif

            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Référence</th>
                        <th class="px-4 py-3 text-left font-semibold">Citoyen</th>
                        <th class="px-4 py-3 text-left font-semibold">Document</th>
                        <th class="px-4 py-3 text-left font-semibold">Date</th>
                        <th class="px-4 py-3 text-left font-semibold">Statut</th>
                        <th class="px-4 py-3 text-left font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandes as $demande)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-mono font-bold text-blue-900 text-xs">
                            {{ $demande->numero_reference }}
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-800">{{ $demande->user->nom }}</p>
                            <p class="text-gray-400 text-xs">{{ $demande->user->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $demande->documentType->nom }}
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs">
                            {{ $demande->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $demande->statutBadge() }}">
                                {{ $demande->statutLabel() }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.requests.show', $demande->id) }}"
                                class="text-blue-900 font-semibold hover:text-orange-500 transition text-xs">
                                Traiter →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                            Aucune demande trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($demandes->hasPages())
                <div class="px-4 py-4 border-t border-gray-100">
                    {{ $demandes->links() }}
                </div>
            @endif
        </div>

    </div>

</body>
</html>