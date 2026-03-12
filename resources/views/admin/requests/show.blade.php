<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail demande — DocuSen Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold">Docu<span class="text-orange-500">Sen</span> <span class="text-sm font-normal text-blue-300">Admin</span></h1>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.requests.index') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                ← Retour
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

    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-blue-900">Détail de la demande</h2>
                <p class="text-gray-500 text-sm mt-1">
                    Référence : <span class="font-mono font-bold text-blue-900">{{ $demande->numero_reference }}</span>
                </p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $demande->statutBadge() }}">
                {{ $demande->statutLabel() }}
            </span>
        </div>

        {{-- Messages flash --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Colonne principale --}}
            <div class="md:col-span-2 flex flex-col gap-6">

                {{-- Infos citoyen --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-blue-900 mb-4 pb-3 border-b border-gray-100">
                        👤 Informations du citoyen
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 font-medium">Nom complet</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $demande->user->nom }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Email</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $demande->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Téléphone</p>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $demande->user->phone ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Membre depuis</p>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $demande->user->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Infos demande --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-blue-900 mb-4 pb-3 border-b border-gray-100">
                        📋 Informations de la demande
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 font-medium">Type de document</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $demande->documentType->nom }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Date de soumission</p>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $demande->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Date de traitement</p>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $demande->date_traitement ? $demande->date_traitement->format('d/m/Y') : '—' }}
                            </p>
                        </div>
                    </div>

                    @if($demande->notes_citoyen)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-gray-400 font-medium text-sm">Notes du citoyen</p>
                            <p class="text-gray-700 text-sm mt-1">{{ $demande->notes_citoyen }}</p>
                        </div>
                    @endif
                </div>

                {{-- Fichiers --}}
                @if($demande->fichiers && count($demande->fichiers) > 0)
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-blue-900 mb-4 pb-3 border-b border-gray-100">
                        📎 Pièces justificatives
                    </h3>
                    <div class="flex flex-col gap-2">
                        @foreach($demande->fichiers as $fichier)
                            <a href="{{ Storage::url($fichier) }}" target="_blank"
                                class="flex items-center gap-3 px-4 py-3 bg-blue-50 rounded-xl border border-blue-100 hover:bg-blue-100 transition text-sm">
                                <span class="text-xl">📄</span>
                                <span class="text-blue-900 font-medium truncate">{{ basename($fichier) }}</span>
                                <span class="ml-auto text-blue-500 text-xs">Ouvrir →</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- Colonne actions --}}
            <div class="flex flex-col gap-4">

                {{-- Actions --}}
                @if($demande->statut === 'en_attente')
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-blue-900 mb-4">⚡ Actions</h3>

                    {{-- Mettre en traitement --}}
                    <form method="POST" action="{{ route('admin.requests.enTraitement', $demande->id) }}" class="mb-3">
                        @csrf
                        <button type="submit"
                            class="w-full bg-blue-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-600 transition">
                            🔄 Mettre en traitement
                        </button>
                    </form>
                </div>
                @endif

                @if(in_array($demande->statut, ['en_attente', 'en_traitement']))
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-blue-900 mb-4">✅ Approuver</h3>
                    <form method="POST" action="{{ route('admin.requests.approuver', $demande->id) }}">
                        @csrf
                        <textarea name="commentaire_admin" rows="3"
                            class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm resize-none mb-3"
                            placeholder="Commentaire (optionnel)..."></textarea>
                        <button type="submit"
                            class="w-full bg-green-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-green-600 transition">
                            ✅ Approuver la demande
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-red-600 mb-4">❌ Rejeter</h3>
                    <form method="POST" action="{{ route('admin.requests.rejeter', $demande->id) }}">
                        @csrf
                        <textarea name="commentaire_admin" rows="3"
                            class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-400 text-sm resize-none mb-3"
                            placeholder="Motif du rejet (obligatoire)..." required></textarea>
                        <button type="submit"
                            class="w-full bg-red-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition">
                            ❌ Rejeter la demande
                        </button>
                    </form>
                </div>
                @endif

                @if(in_array($demande->statut, ['approuve', 'rejete']))
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-blue-900 mb-2">Demande traitée</h3>
                    <p class="text-gray-500 text-sm">
                        Cette demande a été traitée le
                        {{ $demande->date_traitement?->format('d/m/Y') }}.
                    </p>
                    @if($demande->commentaire_admin)
                        <div class="mt-3 bg-gray-50 rounded-xl p-3 text-sm text-gray-700">
                            {{ $demande->commentaire_admin }}
                        </div>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>

</body>
</html>