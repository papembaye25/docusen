<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil DocuSen — Vos documents administratifs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{--NAVBAR --}}
<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="text-2xl font-bold">
            Docu<span class="text-orange-500">Sen</span>
        </a>

        {{-- Menu desktop --}}
        <div class="hidden md:flex items-center gap-6">
            <a href="{{ route('home') }}#documents" class="text-gray-600 hover:text-blue-900 text-sm font-medium transition">
                Documents
            </a>
            <a href="{{ route('home') }}#comment" class="text-gray-600 hover:text-blue-900 text-sm font-medium transition">
                Comment ça marche 
            </a>

            @auth
            {{-- ici on gere l'affichage du menu selon le role de l'utilisateur --}}
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="bg-blue-900 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('citizen.dashboard') }}"
                        class="bg-blue-900 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
                        Mon Espace
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="text-blue-900 font-semibold text-sm hover:text-orange-500 transition">
                    Se connecter
                </a>
                <a href="{{ route('register') }}"
                    class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                    S'inscrire
                </a>
            @endauth
        </div>

        {{-- Menu hamburger mobile --}}
        <button @click="open = !open" class="md:hidden text-blue-900 focus:outline-none">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

    </div>

    {{-- Menu mobile --}}
    <div x-show="open" x-transition class="md:hidden bg-white border-t border-gray-100 px-4 py-4 flex flex-col gap-4">
        <a href="{{ route('home') }}#documents" class="text-gray-600 text-sm font-medium">Documents</a>
        <a href="{{ route('home') }}#comment" class="text-gray-600 text-sm font-medium">Comment ça marche</a>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-blue-900 text-white px-4 py-2 rounded-xl text-sm font-semibold text-center">
                    Dashboard Admin
                </a>
            @else
                <a href="{{ route('citizen.dashboard') }}"
                    class="bg-blue-900 text-white px-4 py-2 rounded-xl text-sm font-semibold text-center">
                    Mon Espace
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="text-blue-900 font-semibold text-sm text-center">
                Se connecter
            </a>
            <a href="{{ route('register') }}"
                class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold text-center">
                S'inscrire
            </a>
        @endauth
    </div>
</nav>

    {{-- ── HERO SECTION --}}
<section class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 text-white py-20 md:py-32 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        {{-- Texte --}}
        <div>
            <span class="bg-orange-500 text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">
                🇸🇳 République du Sénégal
            </span>
            <h1 class="text-4xl md:text-5xl font-bold mt-6 mb-4 leading-tight">
                Vos documents administratifs
                <span class="text-orange-400">en ligne</span>
            </h1>
            <p class="text-blue-200 text-lg mb-8 leading-relaxed">
                DocuSen simplifie vos démarches administratives. Soumettez, suivez
                et recevez vos documents officiels sans vous déplacer.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('register') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold text-lg transition shadow-lg text-center">
                    🚀 Faire une demande
                </a>
                <a href="{{ route('login') }}"
                    class="bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-2xl font-bold text-lg transition border border-white/30 text-center">
                    Se connecter
                </a>
            </div>
        </div>

        {{-- Illustration --}}
        <div class="hidden md:flex justify-center">
            <div class="bg-white/10 rounded-3xl p-8 backdrop-blur-sm border border-white/20 w-full max-w-sm">
                <div class="flex flex-col gap-4">
                    <div class="bg-white/10 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center text-2xl">📄</div>
                        <div>
                            <p class="font-bold text-sm">Acte de naissance</p>
                            <p class="text-blue-200 text-xs">Délai : 3 jours ouvrables</p>
                        </div>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-1 rounded-full">✓</span>
                    </div>
                    <div class="bg-white/10 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center text-2xl">🪪</div>
                        <div>
                            <p class="font-bold text-sm">Renouvellement CNI</p>
                            <p class="text-blue-200 text-xs">Délai : 14 jours ouvrables</p>
                        </div>
                        <span class="ml-auto bg-orange-400 text-white text-xs px-2 py-1 rounded-full">⏳</span>
                    </div>
                    <div class="bg-white/10 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center text-2xl">✈️</div>
                        <div>
                            <p class="font-bold text-sm">Demande de passeport</p>
                            <p class="text-blue-200 text-xs">Délai : 21 jours ouvrables</p>
                        </div>
                        <span class="ml-auto bg-blue-400 text-white text-xs px-2 py-1 rounded-full">🔄</span>
                    </div>
                    <div class="bg-orange-500 rounded-2xl p-4 text-center">
                        <p class="font-bold text-sm">✅ Demande soumise avec succès !</p>
                        <p class="text-orange-100 text-xs mt-1">Référence : DOC-2026-0042</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

    {{-- ── STATS --}}
<section class="bg-white py-12 px-6 shadow-sm">
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div class="p-4">
            <p class="text-4xl font-bold text-blue-900">8+</p>
            <p class="text-gray-500 text-sm mt-1">Types de documents</p>
        </div>
        <div class="p-4">
            <p class="text-4xl font-bold text-orange-500">100%</p>
            <p class="text-gray-500 text-sm mt-1">En ligne</p>
        </div>
        <div class="p-4">
            <p class="text-4xl font-bold text-blue-900">24/7</p>
            <p class="text-gray-500 text-sm mt-1">Disponible</p>
        </div>
        <div class="p-4">
            <p class="text-4xl font-bold text-orange-500">🇸🇳</p>
            <p class="text-gray-500 text-sm mt-1">Sénégal</p>
        </div>
    </div>
</section>

    {{-- ── DOCUMENTS DISPONIBLES --}}
    <section id="documents" class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold font-heading text-blue-900">
                    Documents disponibles
                </h3>
                <p class="text-gray-500 mt-2">
                    Faites votre demande en quelques clics
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($documentTypes as $type)
                <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg hover:border-blue-200 transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl mb-4">
                        @php
                            $icones = [
                                'Acte de naissance'            => '👶',
                                'Extrait de casier judiciaire' => '⚖️',
                                'Certificat de résidence'      => '🏠',
                                'Certificat de nationalité'    => '🇸🇳',
                                'Renouvellement CNI'           => '🪪',
                                'Attestation de célibat'       => '💍',
                                'Demande de passeport'         => '✈️',
                                'Acte de mariage'              => '💒',
                            ];
                            echo $icones[$type->nom] ?? '📄';
                        @endphp
                    </div>
                        <h4 class="font-bold text-blue-900 text-lg mb-2">{{ $type->nom }}</h4>
                        <p class="text-gray-500 text-sm mb-4">{{ $type->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-orange-500 font-semibold bg-orange-50 px-3 py-1 rounded-full">
                                ⏱ {{ $type->delai_traitement }} jours
                            </span>
                            <a href="{{ route('register') }}"
                                class="text-blue-900 text-sm font-semibold hover:text-orange-500 transition">
                                Demander →
                            </a>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── COMMENT ÇA MARCHE --}}
    <section id="comment" class="bg-blue-900 text-white py-20 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold font-heading">Comment ça marche ?</h3>
                <p class="text-blue-200 mt-2">3 étapes simples</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        1
                    </div>
                    <h4 class="font-bold text-lg mb-2">Créez un compte</h4>
                    <p class="text-blue-200 text-sm">
                        Inscrivez-vous gratuitement avec votre email et vos informations personnelles.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        2
                    </div>
                    <h4 class="font-bold text-lg mb-2">Soumettez votre demande</h4>
                    <p class="text-blue-200 text-sm">
                        Choisissez le document, remplissez le formulaire et uploadez vos pièces justificatives.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        3
                    </div>
                    <h4 class="font-bold text-lg mb-2">Suivez en temps réel</h4>
                    <p class="text-blue-200 text-sm">
                        Recevez des notifications à chaque étape et suivez votre demande depuis votre espace.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── FOOTER --}}
<footer class="bg-gray-900 text-white py-16 px-6">
    <div class="max-w-6xl mx-auto">

        {{-- Grille footer --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">

            {{-- Logo + description --}}
            <div>
                <p class="text-2xl font-bold mb-3">
                    Docu<span class="text-orange-500">Sen</span>
                </p>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Plateforme officielle de gestion des documents administratifs de la République du Sénégal.
                </p>
                <div class="flex gap-3 mt-4">
                    <span class="bg-white/10 px-3 py-1 rounded-full text-xs text-gray-300">🇸🇳 Sénégal</span>
                    <span class="bg-white/10 px-3 py-1 rounded-full text-xs text-gray-300">🔒 Sécurisé</span>
                </div>
            </div>

            {{-- Liens rapides --}}
            <div>
                <p class="font-bold text-white mb-4">Liens rapides</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        🏠 Accueil
                    </a>
                    <a href="{{ route('home') }}#documents" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        📄 Documents disponibles
                    </a>
                    <a href="{{ route('home') }}#comment" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        ❓ Comment ça marche
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        ✍️ S'inscrire
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        🔑 Se connecter
                    </a>
                </div>
            </div>

            {{-- Documents populaires --}}
            <div>
                <p class="font-bold text-white mb-4">Documents populaires</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        👶 Acte de naissance
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        🪪 Renouvellement CNI
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        ✈️ Demande de passeport
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        ⚖️ Casier judiciaire
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-orange-500 text-sm transition">
                        🏠 Certificat de résidence
                    </a>
                </div>
            </div>

        </div>

        {{-- Ligne séparatrice --}}
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">
                © {{ date('Y') }} DocuSen. Tous droits réservés.
            </p>
            <p class="text-gray-500 text-sm">
                Développé par <span class="text-orange-500 font-semibold">Pape Mbaye Gaye</span>
            </p>
        </div>

    </div>
</footer>

</body>
</html>