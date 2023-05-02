<?php

use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->assertAuthenticated('web');
});

it('can create a user', function (): void {
    $userDefinition = User::factory()->definition();
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
    $this->assertDatabaseCount('details', 4);
    $this->post(route('users.store'), $data)->assertStatus(302);
    $this->assertDatabaseHas('users', ['email' => $userDefinition['email']]);
    $this->assertDatabaseCount('users', 2);
    $this->assertDatabaseCount('details', 8);
});

it('can update a user', function (): void {
    $createdUser = User::factory()->create();
    $userDefinition = User::factory()->definition();
    $data = [
        'prefixname' => $userDefinition['prefixname'],
        'firstname' => $userDefinition['firstname'],
        'middlename' => $userDefinition['middlename'],
        'lastname' => $userDefinition['lastname'],
        'suffixname' => $userDefinition['suffixname'],
        'email' => $userDefinition['email'],
        'type' => $userDefinition['type'],
    ];
    $this->assertDatabaseCount('users', 2);
    $this->put(route('users.update', $createdUser->id), $data)->assertStatus(302);
    $this->assertDatabaseHas('users', ['id' => $createdUser->id, 'email' => $data['email']]);
    $this->assertDatabaseCount('users', 2);
});

it('can destroy a user', function (): void {
    $createdUser = User::factory()->create();
    $this->assertDatabaseCount('users', 2);
    $this->delete(route('users.destroy', $createdUser->id))->assertStatus(302);
    expect(User::count())->toBe(1);
});

it('can restor a user', function (): void {
    $createdUser = User::factory()->trashed()->create();
    $this->assertDatabaseCount('users', 2);
    expect(User::count())->toBe(1);
    $this->patch(route('users.restore', $createdUser->id))->assertStatus(302);
    expect(User::count())->toBe(2);
});

it('can delete a user', function (): void {
    $createdUser = User::factory()->trashed()->create();
    $this->assertDatabaseCount('users', 2);
    expect(User::count())->toBe(1);
    $this->delete(route('users.delete', $createdUser->id))->assertStatus(302);
    $this->assertDatabaseCount('users', 1);
});

it('can list the users', function (): void {
    User::factory()->count(20)->create();
    $this->get(route('users.index'))->assertSuccessful();
});

it('can list trashed the users', function (): void {
    User::factory()->count(20)->trashed()->create();
    $this->get(route('users.trashed'))->assertSuccessful();
});

it('can show a user', function (): void {
    $createdUser = User::factory()->create();
    $this->get(route('users.show', $createdUser->id))->assertSuccessful();
});

it('can show create user page', function (): void {
    $this->get(route('users.create'))->assertSuccessful();
});

it('can show update user page', function (): void {
    $createdUser = User::factory()->create();
    $this->get(route('users.update', $createdUser->id))->assertSuccessful();
});