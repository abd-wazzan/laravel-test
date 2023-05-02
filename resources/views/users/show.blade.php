@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>User Details</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm float-end">View All</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm float-end me-1">Edit</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form"><b>Prefix Name</b></label>
                <div class="col-sm-10">
                    {{ $user->prefixname }}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form"><b>First Name</b></label>
                <div class="col-sm-10">
                    {{ $user->firstname }}
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form"><b>Middle Name</b></label>
                <div class="col-sm-10">
                    {{ $user->middlename }}
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form"><b>Last Name</b></label>
                <div class="col-sm-10">
                    {{ $user->lastname }}
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form"><b>Suffix Name</b></label>
                <div class="col-sm-10">
                    {{ $user->suffixname }}
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form"><b>Username</b></label>
                <div class="col-sm-10">
                    {{ $user->username }}
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form"><b>Email</b></label>
                <div class="col-sm-10">
                    {{ $user->email }}
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form"><b>Type</b></label>
                <div class="col-sm-10">
                    {{ $user->type }}
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form"><b>Image</b></label>
                <div class="col-sm-10">
                    <img src="{{ $user->avatar }}" width="200" class="img-thumbnail" />
                </div>
            </div>
        </div>
    </div>

@endsection('content')