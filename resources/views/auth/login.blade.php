<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — DocuSen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-900 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-900">DocuSen</h1>
            <p class="text-gray-500 mt-1 text-sm">Connectez-vous à votre espace</p>
        </div>

        {{-- Message succès (ex: après reset password) --}}
        @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Erreurs --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Adresse email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                    placeholder="exemple@email.com" required autofocus />
            </div>

            {{-- Mot de passe --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Mot de passe
                </label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                    placeholder="Votre mot de passe" required />
            </div>

            {{-- Se souvenir + Mot de passe oublié --}}
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-blue-600" />
                    Se souvenir de moi
                </label>
                <a href="{{ route('password.request') }}"
                    class="text-sm text-orange-500 font-semibold hover:underline">
                    Mot de passe oublié ?
                </a>
            </div>

            {{-- Bouton --}}
            <button type="submit"
                class="w-full bg-blue-900 text-white py-3 rounded-xl font-semibold hover:bg-blue-800 transition">
                Se connecter
            </button>

        </form>

        {{-- Lien register --}}
        <p class="text-center text-sm text-gray-500 mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:underline">
                S'inscrire
            </a>
        </p>

    </div>

</body>
</html>