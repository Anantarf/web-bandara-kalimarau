<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(StoreContactRequest $request)
    {
        // Silent drop if honeypot was filled by automated spam bot
        if ($request->filled('website_url_hp')) {
            return redirect()->route('contact.index')
                ->with('success', 'Terima kasih, pesan Anda telah berhasil dikirim. Kami akan menindaklanjuti pesan Anda secepatnya.');
        }

        // Add to database
        ContactMessage::create($request->validated());

        return redirect()->route('contact.index')
            ->with('success', 'Terima kasih, pesan Anda telah berhasil dikirim. Kami akan menindaklanjuti pesan Anda secepatnya.');
    }
}
