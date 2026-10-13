<?php

use App\Models\User;

it('has login page', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

it('can login', function () {
    $user = User::factory()->create();


    $creds = [
        'email' => $user->email,
        'password' => 'password',
    ];


    $this->post('/login', $creds)
        ->assertRedirect('/scolarite');
});

