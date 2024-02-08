<?php

namespace App\Livewire;

use App\Mail\ContactoMailable;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $messageContent;

    protected $rules = [

        'name' => 'required|min:3',
        'email' => 'required|email',
        'messageContent' => 'required|min:20'
    ];

    public function submit()
    {
        $this->validate();

        Mail::to('03e8b74cbc-d4644b@inbox.mailtrap.io')->send(new ContactoMailable($this->name, $this->email, $this->messageContent));
        session()->flash('success', "Tu mensaje fue enviado correctamente. Gracias por comunicarte con nosotros, nos pondremos en contacto a la brevedad.");
        $this->reset();
    }
    public function render()
    {
        return view('livewire.contact-form');
    }
}
