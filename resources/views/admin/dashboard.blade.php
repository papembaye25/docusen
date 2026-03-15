<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — DocuSen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold">Docu<span class="text-orange-500">Sen</span> <span class="text-sm font-normal text-blue-300">Admin</span></h1>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.requests.index') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Demandes
            </a>
            <a href="{{ route('admin.document-types.index') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Documents
            </a>

            {{-- lien Utilisateurs visibles uniquement pour le super admins --}}
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}"
                class="text-blue-200 hover:text-white text-sm transition">
                Gestion des Utilisateurs
                </a>
            @endif

            <span class="text-blue-300 text-sm">{{ auth()->user()->nom }}</span>
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

        {{-- En-tête --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-blue-900">Tableau de bord</h2>
            <p class="text-gray-500 text-sm mt-1">Vue d'ensemble de la plateforme DocuSen</p>
        </div>

        {{-- Cartes statistiques --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

            <div class="bg-white rounded-2xl shadow p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg">📋</div>
                    <p class="text-gray-400 text-xs font-medium">Total demandes</p>
                </div>
                <p class="text-3xl font-bold text-blue-900">{{ $stats['total_demandes'] }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-lg">⏳</div>
                    <p class="text-gray-400 text-xs font-medium">En attente</p>
                </div>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['en_attente'] }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-lg">✅</div>
                    <p class="text-gray-400 text-xs font-medium">Approuvées</p>
                </div>
                <p class="text-3xl font-bold text-green-600">{{ $stats['approuve'] }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-lg">👥</div>
                    <p class="text-gray-400 text-xs font-medium">Citoyens</p>
                </div>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_citoyens'] }}</p>
            </div>

        </div>

        {{-- Graphique + Statuts --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            {{-- Graphique mensuel --}}
            <div class="md:col-span-2 bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-blue-900 mb-4">Demandes par mois</h3>
                <canvas id="chartMois" height="120"></canvas>
            </div>

            {{-- Répartition statuts --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-blue-900 mb-4">Répartition statuts</h3>
                <canvas id="chartStatuts" height="200"></canvas>
                <div class="mt-4 flex flex-col gap-2 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-orange-400"></div>
                        <span class="text-gray-600">En attente ({{ $stats['en_attente'] }})</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-400"></div>
                        <span class="text-gray-600">En traitement ({{ $stats['en_traitement'] }})</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        <span class="text-gray-600">Approuvées ({{ $stats['approuve'] }})</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <span class="text-gray-600">Rejetées ({{ $stats['rejete'] }})</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Dernières demandes --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-blue-900 text-lg">Dernières demandes</h3>
                <a href="{{ route('admin.requests.index') }}"
                    class="text-orange-500 text-sm font-semibold hover:underline">
                    Voir tout →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="pb-3 text-left text-gray-400 font-medium">Référence</th>
                            <th class="pb-3 text-left text-gray-400 font-medium">Citoyen</th>
                            <th class="pb-3 text-left text-gray-400 font-medium">Document</th>
                            <th class="pb-3 text-left text-gray-400 font-medium">Date</th>
                            <th class="pb-3 text-left text-gray-400 font-medium">Statut</th>
                            <th class="pb-3 text-left text-gray-400 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dernieresDemandes as $demande)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-3 font-mono font-bold text-blue-900 text-xs">
                                {{ $demande->numero_reference }}
                            </td>
                            <td class="py-3 text-gray-700">{{ $demande->user->nom }}</td>
                            <td class="py-3 text-gray-600">{{ $demande->documentType->nom }}</td>
                            <td class="py-3 text-gray-400 text-xs">
                                {{ $demande->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $demande->statutBadge() }}">
                                    {{ $demande->statutLabel() }}
                                </span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('admin.requests.show', $demande->id) }}"
                                    class="text-blue-900 font-semibold hover:text-orange-500 transition text-xs">
                                    Voir →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    {{-- pour generer les graphiques --}}
    {{-- Scripts Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Données depuis Laravel
        const demandesParMois = @json($demandesParMois);
        const moisLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];

        // Préparer données mensuelles
        const dataMois = Array(12).fill(0);
        demandesParMois.forEach(item => {
            dataMois[item.mois - 1] = item.total;
        });

        // Graphique mensuel
        new Chart(document.getElementById('chartMois'), {
            type: 'bar',
            data: {
                labels: moisLabels,
                datasets: [{
                    label: 'Demandes',
                    data: dataMois,
                    backgroundColor: 'rgba(30, 58, 138, 0.8)',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Graphique statuts
        new Chart(document.getElementById('chartStatuts'), {
            type: 'doughnut',
            data: {
                labels: ['En attente', 'En traitement', 'Approuvées', 'Rejetées'],
                datasets: [{
                    data: [
                        {{ $stats['en_attente'] }},
                        {{ $stats['en_traitement'] }},
                        {{ $stats['approuve'] }},
                        {{ $stats['rejete'] }}
                    ],
                    backgroundColor: ['#fb923c', '#60a5fa', '#4ade80', '#f87171'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                cutout: '70%',
            }
        });
    </script>

</body>
</html>