<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande — DocuSen</title>
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
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-blue-900">Nouvelle demande</h2>
            <p class="text-gray-500 text-sm mt-1">
                Remplissez le formulaire et uploadez vos pièces justificatives
            </p>
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
            <form method="POST" action="{{ route('citizen.requests.store') }}"
                enctype="multipart/form-data">
                @csrf

                {{-- Type de document --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Type de document <span class="text-red-500">*</span>
                    </label>
                    <select name="document_type_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                        onchange="afficherInfos(this)">
                        <option value="">-- Sélectionnez un document --</option>
                        @foreach($documentTypes as $type)
                            <option value="{{ $type->id }}"
                                data-description="{{ $type->description }}"
                                data-conditions="{{ $type->conditions }}"
                                data-delai="{{ $type->delai_traitement }}"
                                {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Infos du document sélectionné --}}
                <div id="infos-document" class="hidden mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm">
                    <p class="font-semibold text-blue-900 mb-1" id="info-description"></p>
                    <p class="text-blue-700 mb-2" id="info-delai"></p>
                    <div class="text-blue-800">
                        <p class="font-semibold mb-1">Pièces requises :</p>
                        <p id="info-conditions" class="whitespace-pre-line"></p>
                    </div>
                </div>

                {{-- Notes citoyen --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Informations complémentaires
                        <span class="text-gray-400 font-normal">(optionnel)</span>
                    </label>
                    <textarea name="notes_citoyen" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm resize-none"
                        placeholder="Ajoutez des informations supplémentaires si nécessaire...">{{ old('notes_citoyen') }}</textarea>
                </div>

                {{-- Upload fichiers --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Pièces justificatives
                        <span class="text-gray-400 font-normal">(PDF, JPG, PNG — max 5MB par fichier)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-blue-400 hover:bg-blue-50 transition cursor-pointer"
                        onclick="document.getElementById('fichiers').click()">
                        <p class="text-4xl mb-2">📎</p>
                        <p class="text-gray-500 text-sm">
                            Cliquez pour sélectionner vos fichiers
                        </p>
                        <p class="text-gray-400 text-xs mt-1">Maximum 5 fichiers</p>
                        <input type="file" id="fichiers" name="fichiers[]"
                            multiple accept=".pdf,.jpg,.jpeg,.png"
                            class="hidden"
                            onchange="previewFiles(this, 'preview-fichiers')" />
                    </div>
                    {{-- Prévisualisation --}}
                    <div id="preview-fichiers" class="mt-3 flex flex-col gap-2"></div>
                </div>

                {{-- Boutons --}}
                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-blue-900 text-white py-3 rounded-xl font-semibold hover:bg-blue-800 transition">
                        Soumettre la demande
                    </button>
                    <a href="{{ route('citizen.requests.index') }}"
                        class="flex-1 text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Script affichage infos document --}}
    <script>
        function afficherInfos(select) {
            const option = select.options[select.selectedIndex];
            const infos  = document.getElementById('infos-document');

            if (select.value) {
                document.getElementById('info-description').textContent = option.dataset.description;
                document.getElementById('info-delai').textContent = '⏱ Délai estimé : ' + option.dataset.delai + ' jours ouvrables';
                document.getElementById('info-conditions').textContent = option.dataset.conditions;
                infos.classList.remove('hidden');
            } else {
                infos.classList.add('hidden');
            }
        }
    </script>

</body>
</html>