@extends('layouts.app')

@section('content')
<div class="container">
    <div><a href="{{ route("users.create") }}">Add new user</a></div>

    <user-list :users="{{ json_encode($users) }}"/>
</div>
@endsection
