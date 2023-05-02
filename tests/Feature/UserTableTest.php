<?php

use App\Models\User;

it('can create a user table', function (): void {

    $userDefinition = User::factory()->definition();
    $this->actingAs(User::factory()->create());
    $this->assertAuthenticated('web');
    $data = [
        'prefixname' => $userDefinition['prefixname'],
        'firstname' => $userDefinition['firstname'],
        'middlename' => $userDefinition['middlename'],
        'lastname' => $userDefinition['lastname'],
        'suffixname' => $userDefinition['suffixname'],
        'email' => $userDefinition['email'],
        'password' => 'password',
        'password_confirmation' => 'password',
        'type' => $userDefinition['type'],
    ];
    $this->assertDatabaseCount('users', 1);
    $this->post(route('users.store'), $data)->assertStatus(302);
    $this->assertDatabaseHas('users', ['email' => $userDefinition['email']]);
    $this->assertDatabaseCount('users', 2);
});


