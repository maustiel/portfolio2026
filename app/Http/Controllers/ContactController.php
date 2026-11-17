<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    // Si quelqu'un tape /contact dans l'URL, on le redirige vers le dossier
    public function create()
    {
        return redirect('/?tab=contact');
    }

    public function store(ContactMessageRequest $request)
    {
        // 1. Sauvegarde
        $contactMessage = ContactMessage::create($request->validated());

        // 2. Envoi de l'e-mail
        Mail::to(config('mail.from.address'))->send(new ContactMessageReceived($contactMessage));

        // 3. Message Flash
        Inertia::flash('toast', ['type' => 'success', 'message' => 'Merci, votre message est bien parti.']);

        // 4. LA CORRECTION EST ICI : on redirige vers l'accueil avec le bon onglet d'ouvert !
        return redirect('/?tab=contact');
    }
}
