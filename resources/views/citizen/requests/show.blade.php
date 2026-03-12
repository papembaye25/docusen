<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail demande — DocuSen</title>
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 py-10">

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

        {{-- Infos demande --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h3 class="font-bold text-blue-900 mb-4 pb-3 border-b border-gray-100">
                Informations de la demande
            </h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 font-medium">Type de document</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $demande->documentType->nom }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium">Date de soumission</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $demande->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium">Délai estimé</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $demande->documentType->delai_traitement }} jours ouvrables
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium">Date de traitement</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $demande->date_traitement ? $demande->date_traitement->format('d/m/Y') : '—' }}
                    </p>
                </div>
            </div>

            {{-- Notes citoyen --}}
            @if($demande->notes_citoyen)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-gray-400 font-medium text-sm">Vos notes</p>
                    <p class="text-gray-700 text-sm mt-1">{{ $demande->notes_citoyen }}</p>
                </div>
            @endif
        </div>

        {{-- Commentaire admin --}}
        @if($demande->commentaire_admin)
            <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6 mb-6">
                <h3 class="font-bold text-orange-700 mb-2">
                    💬 Message de l'administration
                </h3>
                <p class="text-orange-800 text-sm">{{ $demande->commentaire_admin }}</p>
            </div>
        @endif

        {{-- Fichiers uploadés --}}
        @if($demande->fichiers && count($demande->fichiers) > 0)
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <h3 class="font-bold text-blue-900 mb-4 pb-3 border-b border-gray-100">
                    Pièces justificatives
                </h3>
                <div class="flex flex-col gap-2">
                    @foreach($demande->fichiers as $fichier)
                        <a href="{{ Storage::url($fichier) }}" target="_blank"
                            class="flex items-center gap-3 px-4 py-3 bg-blue-50 rounded-xl border border-blue-100 hover:bg-blue-100 transition text-sm">
                            <span class="text-xl">📄</span>
                            <span class="text-blue-900 font-medium truncate">
                                {{ basename($fichier) }}
                            </span>
                            <span class="ml-auto text-blue-500 text-xs">Voir →</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Timeline statut --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h3 class="font-bold text-blue-900 mb-4 pb-3 border-b border-gray-100">
                Suivi de la demande
            </h3>
            <div class="flex flex-col gap-3">
                @foreach(['en_attente' => 'En attente', 'en_traitement' => 'En traitement', 'approuve' => 'Approuvé', 'rejete' => 'Rejeté'] as $statut => $label)
                    @php
                        $statuts = ['en_attente', 'en_traitement', 'approuve', 'rejete'];
                        $actuel  = array_search($demande->statut, $statuts);
                        $current = array_search($statut, $statuts);
                        $fait    = $current <= $actuel;
                        $estActuel = $statut === $demande->statut;
                    @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0
                            {{ $estActuel ? 'bg-blue-900 text-white' : ($fait ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400') }}">
                            {{ $fait && !$estActuel ? '✓' : ($current + 1) }}
                        </div>
                        <span class="text-sm font-medium
                            {{ $estActuel ? 'text-blue-900 font-bold' : ($fait ? 'text-green-600' : 'text-gray-400') }}">
                            {{ $label }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Bouton retour --}}
        <a href="{{ route('citizen.requests.index') }}"
            class="block text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
            ← Retour à mes demandes
        </a>

    </div>

</body>
</html>