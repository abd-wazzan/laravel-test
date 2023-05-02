@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Edit User</div>
        <div class="card-body">
            <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Prefix Name</label>
                    <div class="col-sm-10">
                        <select required name="prefixname" class="form-control">
                            @foreach(\App\Enums\UserPrefixnameEnum::getValues() as $value)
                                <option value="{{ $value }}">{{ \Illuminate\Support\Str::title($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" required maxlength="255" name="firstname" class="form-control" value="{{ $user->firstname }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Middle Name</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="255" name="middlename" class="form-control" value="{{ $user->middlename }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="255" required name="lastname" class="form-control" value="{{ $user->lastname }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Suffix Name</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="255" name="suffixname" class="form-control" value="{{ $user->suffixname }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Username</label>
                    <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="{{ $user->username }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Email</label>
                    <div class="col-sm-10">
                            <input type="text" required maxlength="255" name="email" class="form-control" value="{{ $user->email }}" />
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-label-form">Type</label>
                    <div class="col-sm-10">
                        <select name="type" required class="form-control">
                            @foreach(\App\Enums\UserTypeEnum::getValues() as $value)
                                <option value="{{ $value }}">{{ \Illuminate\Support\Str::title($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-label-form">Image</label>
                    <div class="col-sm-10">
                        <input type="file" accept=".png,.jpeg,.jpg" name="photo_file" />
                        <br />
                        <img src="{{ $user->avatar }}" width="100" class="img-thumbnail" />
                        <input type="hidden" name="hidden_photo" value="{{ $user->photo }}" />
                    </div>
                </div>
                <div class="text-center">
                    <input type="hidden" name="hidden_id" value="{{ $user->id }}" />
                    <input type="submit" class="btn btn-primary" value="Edit" />
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementsByName('type')[0].value = "{{ $user->type }}";
        document.getElementsByName('prefixname')[0].value = "{{ $user->prefixname }}";
    </script>


@endsection('content')