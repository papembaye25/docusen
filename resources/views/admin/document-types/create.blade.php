<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau type — DocuSen Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
<nav class="bg-blue-900 text-white shadow-lg sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold">
            Docu<span class="text-orange-500">Sen</span>
            <span class="text-xs font-normal text-blue-300 ml-1">Admin</span>
        </a>

        {{-- Desktop --}}
        <div class="hidden md:flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-200 hover:text-white text-sm transition">Dashboard</a>
            <a href="{{ route('admin.requests.index') }}" class="text-blue-200 hover:text-white text-sm transition">Demandes</a>
            <a href="{{ route('admin.document-types.index') }}" class="text-blue-200 hover:text-white text-sm transition">Documents</a>
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}" class="text-blue-200 hover:text-white text-sm transition">Utilisateurs</a>
            @endif
            <span class="text-blue-300 text-sm">{{ auth()->user()->nom }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
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
        <a href="{{ route('admin.dashboard') }}" class="text-blue-200 text-sm">Dashboard</a>
        <a href="{{ route('admin.requests.index') }}" class="text-blue-200 text-sm">Demandes</a>
        <a href="{{ route('admin.document-types.index') }}" class="text-blue-200 text-sm">Documents</a>
        @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.users.index') }}" class="text-blue-200 text-sm">Utilisateurs</a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold w-full text-center">
                Déconnexion
            </button>
        </form>
    </div>
</nav>

    <div class="max-w-2xl mx-auto px-4 py-10">

        {{-- En-tête --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-blue-900">Nouveau type de document</h2>
            <p class="text-gray-500 text-sm mt-1">Ajoutez un nouveau type de document disponible</p>
        </div>

        {{-- Erreurs --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulaire --}}
        <div class="bg-white rounded-2xl shadow p-8">
            <form method="POST" action="{{ route('admin.document-types.store') }}">
                @csrf

                {{-- Nom --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Nom du document <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                        placeholder="Ex: Acte de naissance" required />
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm resize-none"
                        placeholder="Description du document...">{{ old('description') }}</textarea>
                </div>

                {{-- Conditions --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Pièces requises
                    </label>
                    <textarea name="conditions" rows="4"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm resize-none"
                        placeholder="- CNI valide&#10;- Photo d'identité&#10;- Formulaire de demande">{{ old('conditions') }}</textarea>
                    <p class="text-gray-400 text-xs mt-1">Une pièce par ligne</p>
                </div>

                {{-- Délai --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Délai de traitement (jours) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="delai_traitement" value="{{ old('delai_traitement', 5) }}"
                        min="1"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                        required />
                </div>

                {{-- Actif --}}
                <div class="mb-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="actif" value="1"
                            {{ old('actif', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 text-blue-600" />
                        <span class="text-sm font-semibold text-gray-700">
                            Document actif (visible par les citoyens)
                        </span>
                    </label>
                </div>

                {{-- Boutons --}}
                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-blue-900 text-white py-3 rounded-xl font-semibold hover:bg-blue-800 transition">
                        Créer le type
                    </button>
                    <a href="{{ route('admin.document-types.index') }}"
                        class="flex-1 text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                        Annuler
                    </a>
                </div>

            </form>
        </div>

    </div>

</body>
</html>