<x-mail::message>
# Nouveau message depuis le portfolio

**De :** {{ $contactMessage->name }} ({{ $contactMessage->email }})

{{ $contactMessage->message }}

Répondez directement à cet e-mail pour lui écrire.
</x-mail::message>
