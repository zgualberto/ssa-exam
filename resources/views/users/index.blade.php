@extends('layouts.app')

@section('content')
<div class="container">
    <div><a href="{{ route("users.create") }}">Add new user</a></div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Middle</th>
            <th scope="col" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr style="cursor: pointer;" onclick="location.href = '{{ route('users.show', $user->id) }}'">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->firstname }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->middlename }}</td>
                    <td class="text-center"><a class="btn btn-danger"
                        onclick="event.preventDefault();
                                      document.getElementById('delete-form').submit();">
                         {{ __('Delete') }}
                     </a>

                     <form id="delete-form" action="{{ route('users.delete', $user->id) }}" method="DELETE" class="d-none">
                         @csrf
                     </form></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
