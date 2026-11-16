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
    public function create(): Response
    {
        return Inertia::render('Contact');
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        // 1. Sauvegarde
        $contactMessage = ContactMessage::create($request->validated());

        // 2. Envoi de l'e-mail
        Mail::to(config('mail.from.address'))->send(new ContactMessageReceived($contactMessage));

        // 3. Message Flash et retour
        Inertia::flash('toast', ['type' => 'success', 'message' => 'Merci, votre message est bien parti.']);

        return to_route('contact');
    }
}
