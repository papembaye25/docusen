<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion utilisateurs — DocuSen Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold">Docu<span class="text-orange-500">Sen</span> <span class="text-sm font-normal text-blue-300">Super Admin</span></h1>
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

    <div class="max-w-6xl mx-auto px-4 py-10">

        {{-- Messages flash --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Section Admins --}}
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-blue-900">Gestion des admins</h2>
                    <p class="text-gray-500 text-sm mt-1">Créez et gérez les comptes administrateurs</p>
                </div>
            </div>

            {{-- Formulaire création admin --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <h3 class="font-bold text-blue-900 mb-4">➕ Créer un nouveau compte admin</h3>
                <form method="POST" action="{{ route('admin.users.store') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <input type="text" name="nom"
                        placeholder="Nom complet"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                        required />
                    <input type="email" name="email"
                        placeholder="Email"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                        required />
                    <select name="role"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                    <button type="submit"
                        class="bg-blue-900 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
                        Créer le compte
                    </button>
                </form>
                <p class="text-gray-400 text-xs mt-2">
                    ⚠️ Mot de passe par défaut : <span class="font-mono font-bold">Admin@2026</span>
                </p>
            </div>

            {{-- Liste admins --}}
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Nom</th>
                            <th class="px-4 py-3 text-left font-semibold">Email</th>
                            <th class="px-4 py-3 text-left font-semibold">Rôle</th>
                            <th class="px-4 py-3 text-left font-semibold">Statut</th>
                            <th class="px-4 py-3 text-left font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $admin->nom }}
                                @if($admin->id === auth()->id())
                                    <span class="text-xs text-blue-400">(vous)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $admin->email }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $admin->role === 'super_admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $admin->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $admin->status === 'actif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $admin->status === 'actif' ? 'Actif' : 'Suspendu' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($admin->id !== auth()->id())
                                <div class="flex items-center gap-3">
                                    {{-- Suspendre/Activer --}}
                                    <form method="POST"
                                        action="{{ route('admin.users.toggleStatus', $admin->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="{{ $admin->status === 'actif' ? 'text-orange-500 hover:text-orange-700' : 'text-green-500 hover:text-green-700' }} font-semibold text-xs transition">
                                            {{ $admin->status === 'actif' ? 'Suspendre' : 'Activer' }}
                                        </button>
                                    </form>
                                    {{-- Supprimer --}}
                                    <form method="POST"
                                        action="{{ route('admin.users.destroy', $admin->id) }}"
                                        onsubmit="return confirm('Supprimer ce compte ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 font-semibold text-xs transition">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section Citoyens --}}
        <div>
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-blue-900">Citoyens inscrits</h2>
                <p class="text-gray-500 text-sm mt-1">Liste de tous les citoyens enregistrés</p>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Nom</th>
                            <th class="px-4 py-3 text-left font-semibold">Email</th>
                            <th class="px-4 py-3 text-left font-semibold">Téléphone</th>
                            <th class="px-4 py-3 text-left font-semibold">Inscrit le</th>
                            <th class="px-4 py-3 text-left font-semibold">Statut</th>
                            <th class="px-4 py-3 text-left font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citoyens as $citoyen)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $citoyen->nom }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $citoyen->email }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $citoyen->phone ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $citoyen->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $citoyen->status === 'actif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $citoyen->status === 'actif' ? 'Actif' : 'Suspendu' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST"
                                    action="{{ route('admin.users.toggleStatus', $citoyen->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="{{ $citoyen->status === 'actif' ? 'text-orange-500 hover:text-orange-700' : 'text-green-500 hover:text-green-700' }} font-semibold text-xs transition">
                                        {{ $citoyen->status === 'actif' ? 'Suspendre' : 'Activer' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                Aucun citoyen inscrit
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($citoyens->hasPages())
                    <div class="px-4 py-4 border-t border-gray-100">
                        {{ $citoyens->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

</body>
</html>