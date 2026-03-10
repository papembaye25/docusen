<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'nom'              => 'Acte de naissance',
                'description'      => 'Document officiel attestant la naissance d\'une personne.',
                'conditions'       => "- CNI ou passeport valide\n- Formulaire de demande rempli\n- Justificatif de lien de parenté si demande pour un tiers",
                'delai_traitement' => 3,
                'actif'            => true,
            ],
            [
                'nom'              => 'Extrait de casier judiciaire',
                'description'      => 'Document attestant des antécédents judiciaires d\'une personne.',
                'conditions'       => "- CNI valide\n- Formulaire de demande\n- Photo d'identité récente",
                'delai_traitement' => 5,
                'actif'            => true,
            ],
            [
                'nom'              => 'Certificat de résidence',
                'description'      => 'Document attestant la résidence habituelle d\'une personne.',
                'conditions'       => "- CNI ou passeport valide\n- Justificatif de domicile récent\n- Formulaire de demande",
                'delai_traitement' => 2,
                'actif'            => true,
            ],
            [
                'nom'              => 'Certificat de nationalité',
                'description'      => 'Document attestant la nationalité sénégalaise d\'une personne.',
                'conditions'       => "- Acte de naissance\n- CNI valide\n- Justificatif de nationalité des parents",
                'delai_traitement' => 7,
                'actif'            => true,
            ],
            [
                'nom'              => 'Renouvellement CNI',
                'description'      => 'Renouvellement de la Carte Nationale d\'Identité sénégalaise.',
                'conditions'       => "- Ancienne CNI ou déclaration de perte\n- Acte de naissance\n- 2 photos d'identité récentes",
                'delai_traitement' => 14,
                'actif'            => true,
            ],
            [
                'nom'              => 'Attestation de célibat',
                'description'      => 'Document attestant qu\'une personne est célibataire.',
                'conditions'       => "- CNI valide\n- Acte de naissance\n- Déclaration sur l'honneur",
                'delai_traitement' => 3,
                'actif'            => true,
            ],
            [
                'nom'              => 'Demande de passeport',
                'description'      => 'Demande de passeport biométrique sénégalais.',
                'conditions'       => "- CNI valide\n- Acte de naissance\n- 2 photos biométriques\n- Justificatif de domicile",
                'delai_traitement' => 21,
                'actif'            => true,
            ],
            [
                'nom'              => 'Acte de mariage',
                'description'      => 'Copie certifiée conforme de l\'acte de mariage.',
                'conditions'       => "- CNI des deux époux\n- Livret de famille\n- Formulaire de demande",
                'delai_traitement' => 3,
                'actif'            => true,
            ],
        ];

        foreach ($types as $type) {
            DocumentType::create($type);
        }

        $this->command->info('✅ ' . count($types) . ' types de documents créés.');
    }
}