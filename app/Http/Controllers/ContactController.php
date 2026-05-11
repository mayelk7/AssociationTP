<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function sendMail(Request $request)
    {
        try {
            // Validation des champs
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $data = $request->only('name', 'email', 'subject', 'message');

            // Envoi du mail avec une closure
            Mail::raw(
                "Nom : {$data['name']}\nEmail : {$data['email']}\nSujet : {$data['subject']}\n\nMessage : {$data['message']}", 
                function($message) use ($data) {
                    $message->to('mael.kerivel@gmail.com')
                            ->subject('Nouveau message Journée des assos : ' . $data['subject'])
                            ->replyTo($data['email'], $data['name']);
                }
            );

            return redirect()->back()->with('success', 'Votre message a été envoyé avec succès !');
        } catch (\Throwable $th) {
            // Log de l'erreur (visible dans storage/logs/laravel.log)
            Log::error('Erreur lors de l\'envoi du mail : '.$th->getMessage());

            // Message pour l’utilisateur
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer plus tard.');
        }
    }
}
