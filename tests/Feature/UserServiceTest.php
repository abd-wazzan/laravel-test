<?php

use App\DataTransferObjects\UserData;
use App\Models\User;
use App\Services\IUserService;

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
        'type' => $userDefinition['type'],
    ];
    $user = app(IUserService::class)->store(UserData::from($data));
    $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $userDefinition['email']]);
    $this->assertDatabaseCount('users', 1);
});

it('can update a user', function (): void {
    try {
        $user = User::factory()->create();
        $userDefinition = User::factory()->definition();
        $updatedData = [
            'firstname' => $userDefinition['firstname'],
            'lastname' => $userDefinition['lastname'],
            'email' => $userDefinition['email'],
        ];
        $userData = array_merge($user->toArray(), $updatedData);
        app(IUserService::class)->update(UserData::from($userData));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $userDefinition['email']]);
        $this->assertDatabaseCount('users', 1);
    }catch (Exception $e) {dd($e->getMessage());}
});

it('can list the users', function (): void {
        User::factory()->count(20)->create();
        $this->assertDatabaseCount('users', 20);
        $data = app(IUserService::class)->list(25);
        expect(count($data->items()))->toBe(20);
});

it('can list the trashed users', function (): void {
    User::factory()->trashed()->count(20)->create();
    User::factory()->count(20)->create();
    $this->assertDatabaseCount('users', 40);
    $data = app(IUserService::class)->listTrashed(25);
    expect(count($data->items()))->toBe(20);
});

it('can destroy a user', function (): void {
    $user = User::factory()->create();
    $this->assertDatabaseCount('users', 1);
    $data = app(IUserService::class)->destroy($user->id);
    expect(User::count())->toBe(0);
});

it('can delete a user', function (): void {
    $user = User::factory()->trashed()->create();
    $this->assertDatabaseCount('users', 1);
    $data = app(IUserService::class)->delete($user->id);
    $this->assertDatabaseCount('users', 0);
});

it('can restore a user', function (): void {
    $user = User::factory()->trashed()->create();
    $this->assertDatabaseCount('users', 1);
    expect(User::count())->toBe(0);
    $data = app(IUserService::class)->restore($user->id);
    expect(User::count())->toBe(1);
    $this->assertDatabaseCount('users', 1);
});

it('can find a user', function (): void {
    $createdUser = User::factory()->create();
    $this->assertDatabaseCount('users', 1);
    $user = app(IUserService::class)->find($createdUser->id);
    expect($user->id)->toBe($createdUser->id);
});

it('can upload file', function (): void {
    $file = \Illuminate\Http\UploadedFile::fake()->create('img.png', 200);
    $file = app(IUserService::class)->upload($file);
    \Illuminate\Support\Facades\Storage::assertExists($file);
});
