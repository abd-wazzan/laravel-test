@extends('layouts.app')

@section('content')
    @if($message = Session::get('success'))

        <div class="alert alert-success">
            {{ $message }}
        </div>

    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>User Data</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm float-end">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Image</th>
                    <th>Prefix Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Suffix Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Type</th>
                </tr>
                @if(count($data) > 0)
                    @foreach($data as $row)

                        <tr>
                            <td><img src="{{ $row->avatar }}" width="75"/></td>
                            <td>{{ $row->prefixname }}</td>
                            <td>{{ $row->firstname }}</td>
                            <td>{{ $row->middlename }}</td>
                            <td>{{ $row->lastname }}</td>
                            <td>{{ $row->suffixname }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->type }}</td>
                            <td>
                                <form method="post" action="{{ route('users.destroy', $row->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('users.show', $row->id) }}"
                                       class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('users.edit', $row->id) }}"
                                       class="btn btn-warning btn-sm">Edit</a>
                                    <input type="submit" class="btn btn-danger btn-sm" value="Delete"/>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                @endif
            </table>
            <div class="d-flex">
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection
