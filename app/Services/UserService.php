<?php

namespace App\Services;

use App\DataTransferObjects\UserData;
use App\Models\Detail;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    public function __construct(
        protected User $user,
        protected Detail $detail
    )
    {
    }

    public function list(int $count = 15): LengthAwarePaginator
    {
        return $this->user->newQuery()->paginate($count);
    }

    public function listTrashed(int $count = 15): LengthAwarePaginator
    {
        return $this->user->newQuery()->onlyTrashed()->paginate($count);
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

    public function hash(string $key): string
    {
        if (Hash::needsRehash($key)) {
            $key = Hash::make($key);
        }
        return $key;
    }

    public function upload(UploadedFile $file): string
    {
        return $file->store('public/images');
    }

    public function update(UserData $data): User
    {
        if ($data->photo_file?->isFile()) {
            $data->photo = $this->upload($data->photo_file);
        }

        return tap($this->user->newQuery()->find($data->id))
            ->updateByArray($data->only(
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

    public function find(int $id): ?User
    {
        return $this->user->newQuery()->findOrFail($id);
    }

    public function destroy(int $id): bool
    {
        return $this->user->newQuery()->where(['id' => $id])->delete();
    }

    public function delete(int $id): bool
    {
        try {
            DB::beginTransaction();
            $this->detail->where(['user_id' => $id])->forceDelete();
            $this->user->newQuery()->onlyTrashed()->where(['id' => $id])->forceDelete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public function restore(int $id): bool
    {
        return $this->user->newQuery()->onlyTrashed()->where(['id' => $id])->restore();
    }

    public function saveDetails(User $user): Collection
    {
        return $user->details()->createMany([
            ['key' => 'Full name', 'value' => $user->fullname, 'type' => 'bio'],
            ['key' => 'Middle Initial', 'value' => $user->middleinitial, 'type' => 'bio'],
            ['key' => 'Avatar', 'value' => $user->avatar, 'type' => 'bio'],
            ['key' => 'Gender', 'value' => $user->gender, 'type' => 'bio'],
        ]);
    }
}
