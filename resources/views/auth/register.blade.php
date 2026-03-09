<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — DocuSen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-900 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-900">DocuSen</h1>
            <p class="text-gray-500 mt-1 text-sm">Créer votre compte citoyen</p>
        </div>

        {{-- Erreurs --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nom --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Nom complet
                </label>
                <input type="text" name="nom" value="{{ old('nom') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                    placeholder="Ex: Pape Mbaye" required />
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Adresse email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                    placeholder="exemple@email.com" required />
            </div>

            {{-- Téléphone --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Téléphone <span class="text-gray-400 font-normal">(optionnel)</span>
                </label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                    placeholder="+221 77 000 00 00" />
            </div>

            {{-- Mot de passe --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Mot de passe
                </label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                    placeholder="Minimum 8 caractères" required />
            </div>

            {{-- Confirmation --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Confirmer le mot de passe
                </label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                    placeholder="Répétez le mot de passe" required />
            </div>

            {{-- Bouton --}}
            <button type="submit"
                class="w-full bg-blue-900 text-white py-3 rounded-xl font-semibold hover:bg-blue-800 transition">
                Créer mon compte
            </button>

        </form>

        {{-- Lien login --}}
        <p class="text-center text-sm text-gray-500 mt-6">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:underline">
                Se connecter
            </a>
        </p>

    </div>

</body>
</html>