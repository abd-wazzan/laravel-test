<?php

namespace App\Services;

use App\DataTransferObjects\UserData;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    public function __construct(
        protected User $user
    ) {
    }

    public function list(): LengthAwarePaginator
    {
        return $this->user->newQuery()->paginate();
    }

    public function listTrashed(): LengthAwarePaginator
    {
        return $this->user->newQuery()->onlyTrashed()->paginate();
    }

    public function store(UserData $data): User
    {
        $data->password = $this->hash($data->password);

        if ($data->photo_file?->isFile()) {
            $data->photo = $this->upload($data->photo_file);
        }

        return $this->user->newQuery()->create($data->only(
            'prefixname',
            'firstname',
            'middlename',
            'lastname',
            'suffixname',
            'email',
            'password',
            'type',
            'photo'
        )->toArray());
    }

    public function update(UserData $data): bool
    {
        if ($data->photo_file?->isFile()) {
            $data->photo = $this->upload($data->photo_file);
        }

        return (bool) $this->user->newQuery()->where(['id' => $data->id])
            ->update($data->only(
            'prefixname',
            'firstname',
            'middlename',
            'lastname',
            'suffixname',
            'email',
            'type',
            'photo'
        )->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        return $this->user->newQuery()->where(['id' => $id])->delete();
    }

    public function delete(int $id): bool
    {
        return $this->user->newQuery()->onlyTrashed()->where(['id' => $id])->forceDelete();
    }

    public function restore(int $id): bool
    {
        return $this->user->newQuery()->onlyTrashed()->where(['id' => $id])->restore();
    }

    public function upload(UploadedFile $file): string
    {
        return $file->store('public/images');
    }

    public function hash(string $key): string
    {
        if (Hash::needsRehash($key)) {
            $key = Hash::make($key);
        }
        return $key;
    }
}
