@extends('layouts.app')

@section('content')
<div class="container">
    <div class="p-3 text-right">
        <a class="btn btn-outline-primary" href="user/create">Add New User</a>
    </div>
    <user-list :users="{{ json_encode($users) }}" :actions="{{ json_encode($actions) }}"/>
</div>
@endsection
