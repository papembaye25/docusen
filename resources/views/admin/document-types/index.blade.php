<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types de documents — DocuSen Admin</title>
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
            <a href="{{ route('admin.requests.index') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Demandes
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
                <h2 class="text-2xl font-bold text-blue-900">Types de documents</h2>
                <p class="text-gray-500 text-sm mt-1">Gérez les types de documents disponibles</p>
            </div>
            <a href="{{ route('admin.document-types.create') }}"
                class="bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800 transition shadow">
                + Nouveau type
            </a>
        </div>

        {{-- Messages flash --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Nom</th>
                        <th class="px-4 py-3 text-left font-semibold">Délai</th>
                        <th class="px-4 py-3 text-left font-semibold">Statut</th>
                        <th class="px-4 py-3 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-800">{{ $type->nom }}</p>
                            <p class="text-gray-400 text-xs mt-0.5">{{ Str::limit($type->description, 60) }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $type->delai_traitement }} jours
                        </td>
                        <td class="px-4 py-3">
                            @if($type->actif)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Actif
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    Inactif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.document-types.edit', $type->id) }}"
                                    class="text-blue-900 font-semibold hover:text-orange-500 transition text-xs">
                                    Modifier
                                </a>
                                <form method="POST"
                                    action="{{ route('admin.document-types.destroy', $type->id) }}"
                                    onsubmit="return confirm('Supprimer ce type ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 font-semibold hover:text-red-700 transition text-xs">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-gray-400">
                            Aucun type de document trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($types->hasPages())
                <div class="px-4 py-4 border-t border-gray-100">
                    {{ $types->links() }}
                </div>
            @endif
        </div>

    </div>

</body>
</html>