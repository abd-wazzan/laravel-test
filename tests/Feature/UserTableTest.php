<?php

use Illuminate\Support\Facades\Schema;

test('test user table schema', function (): void {
    $table = 'users';
    expect(Schema::hasTable($table))->toBeTrue();
    $columns = [
        'prefixname' => 'string',
        'firstname' => 'string',
        'middlename' => 'string',
        'lastname' => 'string',
        'suffixname' => 'string',
        'username' => 'string',
        'email' => 'string',
        'password' => 'text',
        'photo' => 'text',
        'type' => 'string',
        'remember_token' => 'string',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    expect(Schema::hasColumns($table, array_keys($columns)))->toBeTrue();

    foreach ($columns as $column => $type) {
        expect(Schema::getColumnType($table, $column))->toBe($type);
    }
});


