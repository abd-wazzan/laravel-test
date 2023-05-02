<?php

namespace App\Services;


use App\DataTransferObjects\UserData;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

interface IUserService
{
    public function store(UserData $data): User;
    public function find(int $id): ?User;
    public function update(UserData $data): bool;
    public function destroy(int $id): bool;
    public function delete(int $id): bool;
    public function restore(int $id): bool;
    public function list(): LengthAwarePaginator;
    public function listTrashed(): LengthAwarePaginator;
    public function upload(UploadedFile $file): string;
    public function hash(string $key): string;
}