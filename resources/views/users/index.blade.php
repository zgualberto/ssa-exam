@extends('layouts.app')

@section('content')
<div class="container">
    <user-list :users="{{ json_encode($users) }}"/>
</div>
@endsection
