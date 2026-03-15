<?php

namespace App\Notifications;

use App\Models\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StatusChangedNotification extends Notification
{
    use Queueable;

    protected DocumentRequest $demande;

    public function __construct(DocumentRequest $demande)
    {
        $this->demande = $demande;
    }

    // ── Canal de notification
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    // ── Contenu de l'email
    public function toMail(object $notifiable): MailMessage
    {
        $statut  = $this->demande->statutLabel();
        $ref     = $this->demande->numero_reference;
        $type    = $this->demande->documentType->nom;

        return (new MailMessage)
            ->subject("DocuSen — Votre demande {$ref} a été mise à jour")
            ->greeting("Bonjour {$notifiable->nom} !")
            ->line("Votre demande de **{$type}** (référence : **{$ref}**) a changé de statut.")
            ->line("Nouveau statut : **{$statut}**")
            ->when($this->demande->commentaire_admin, function ($mail) {
                return $mail->line("Message de l'administration : {$this->demande->commentaire_admin}");
            })
            ->action('Voir ma demande', url("/citizen/requests/{$this->demande->id}"))
            ->line("Merci d'utiliser DocuSen.")
            ->salutation("L'équipe DocuSen");
    }
}