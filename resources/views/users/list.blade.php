@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="p-3">{{ $caption }}</h3>
    @if ($caption == 'Active Users')
        <div class="p-3 text-right">
            <a class="btn btn-outline-primary" href="user/create">Add New User</a>
        </div>
    @endif
    <user-list 
        :users="{{ json_encode($users) }}" 
        :count="{{ $users_count }}" 
        :limit="{{ $limit }}" 
        :actions="{{ json_encode($actions) }}"
        :page="{{ $page }}"
    />
</div>
@endsection
