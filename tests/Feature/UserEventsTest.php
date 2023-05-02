<?php

use App\Events\UserSavedEvent;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\User;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->assertAuthenticated('web');
});

it('can dispatch UserSavedEvent', function (): void {
//    Event::fake();
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
    Event::fake([UserSavedEvent::class]);
    Event::assertListening(
        UserSavedEvent::class,
        SaveUserBackgroundInformation::class
    );
    $this->post(route('users.store'), $data)->assertStatus(302);
    Event::assertDispatched(UserSavedEvent::class);
});

test('test SaveUserBackgroundInformation event handling', function () {
    $user = User::factory()->createQuietly();
    $this->assertDatabaseCount('details', 4);
    $event = new UserSavedEvent($user);
    $listener = app(SaveUserBackgroundInformation::class);
    $listener->handle($event);
    $this->assertDatabaseCount('details', 8);
});
