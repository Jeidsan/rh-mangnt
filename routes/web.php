<?php

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/email', function() {
    Mail::raw('Mensagem de teste do RH MANGNT', function(Message $message) {
        $message->to('teste@gmail.com')
                ->subject('Teste de email do RH MANGNT')
                ->from('rh@rh-mangnt.com.br');
    });

    echo 'Email enviado com sucesso!';
});
