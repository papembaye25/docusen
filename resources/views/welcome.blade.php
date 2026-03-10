<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocuSen — Vos documents administratifs en ligne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- ── NAVBAR --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold font-heading">
            Docu<span class="text-orange-500">Sen</span>
        </h1>
        <div class="flex items-center gap-4">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('citizen.dashboard') }}"
                        class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                        Mon Espace
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="text-white hover:text-orange-400 text-sm font-medium transition">
                    Se connecter
                </a>
                <a href="{{ route('register') }}"
                    class="bg-orange-500 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                    S'inscrire
                </a>
            @endauth
        </div>
    </nav>

    {{-- ── HERO SECTION --}}
    <section class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 text-white py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <span class="bg-orange-500 text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">
                République du Sénégal
            </span>
            <h2 class="text-4xl md:text-5xl font-bold font-heading mt-6 mb-4 leading-tight">
                Vos documents administratifs
                <span class="text-orange-400">en ligne</span>
            </h2>
            <p class="text-blue-200 text-lg mb-10 max-w-2xl mx-auto">
                DocuSen simplifie vos démarches administratives. Soumettez, suivez
                et recevez vos documents officiels sans vous déplacer.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold text-lg transition shadow-lg">
                    Faire une demande
                </a>
                <a href="{{ route('login') }}"
                    class="bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-2xl font-bold text-lg transition border border-white/30">
                    Se connecter
                </a>
            </div>
        </div>
    </section>

    {{-- ── STATS --}}
    <section class="bg-white py-12 px-6 shadow-sm">
        <div class="max-w-4xl mx-auto grid grid-cols-3 gap-8 text-center">
            <div>
                <p class="text-3xl font-bold text-blue-900">8+</p>
                <p class="text-gray-500 text-sm mt-1">Types de documents</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-blue-900">100%</p>
                <p class="text-gray-500 text-sm mt-1">En ligne</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-blue-900">24/7</p>
                <p class="text-gray-500 text-sm mt-1">Disponible</p>
            </div>
        </div>
    </section>

    {{-- ── DOCUMENTS DISPONIBLES --}}
    <section class="py-20 px-6">
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
                                'Acte de naissance'          => '👶',
                                'Extrait de casier judiciaire' => '⚖️',
                                'Certificat de résidence'    => '🏠',
                                'Certificat de nationalité'  => '🇸🇳',
                                'Renouvellement CNI'         => '🪪',
                                'Attestation de célibat'     => '💍',
                                'Demande de passeport'       => '✈️',
                                'Acte de mariage'            => '💒',
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
    <section class="bg-blue-900 text-white py-20 px-6">
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

    {{-- ── FOOTER  --}}
    <footer class="bg-gray-900 text-gray-400 py-8 px-6 text-center text-sm">
        <p class="font-bold text-white text-lg mb-1">
            Docu<span class="text-orange-500">Sen</span>
        </p>
        <p>Plateforme de gestion des documents administratifs — République du Sénégal</p>
        <p class="mt-2">© {{ date('Y') }} DocuSen. Tous droits réservés.</p>
    </footer>

</body>
</html>