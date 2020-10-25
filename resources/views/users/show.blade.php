@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inspect User') }}</div>
                <div class="card-body">
                    <user-info :user="{{ json_encode($user) }}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
