@php use App\Enums\UserPrefixnameEnum; @endphp
@php use App\Enums\UserTypeEnum; @endphp
@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Add User</div>
        <div class="card-body">
            <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Prefix Name</label>
                    <div class="col-sm-10">
                        <select required name="prefixname" class="form-control">
                            @foreach(UserPrefixnameEnum::getValues() as $value)
                                <option value="{{ $value }}">{{ Str::title($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" required maxlength="255" name="firstname" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Middle Name</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="255" name="middlename" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="255" required name="lastname" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Suffix Name</label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="255" name="suffixname" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Email</label>
                    <div class="col-sm-10">
                        <input type="text" required maxlength="255" name="email" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Password</label>
                    <div class="col-sm-10">
                        <input type="password" required minlength="8" maxlength="16" name="password"
                               class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Password Confirmation</label>
                    <div class="col-sm-10">
                        <input type="password" required minlength="8" maxlength="16" name="password_confirmation"
                               class="form-control"/>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-label-form">Type</label>
                    <div class="col-sm-10">
                        <select name="type" required class="form-control">
                            @foreach(UserTypeEnum::getValues() as $value)
                                <option value="{{ $value }}">{{ Str::title($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-label-form">Image</label>
                    <div class="col-sm-10">
                        <input type="file" accept=".png,.jpeg,.jpg" name="photo"/>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Add"/>
                </div>
            </form>
        </div>
    </div>

@endsection('content')