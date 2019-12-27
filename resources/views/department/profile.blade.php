@extends('home')

@section('title')
    User Profile
@endsection

@section('main')
<div class="card p-4">
    <div class="row">
        <div class="col-4">
            <div class="card d-flex">
                <img src="{{ asset('assets/default_avatar_m.png') }}" class="image-thumbnail rounded py-3" alt="">
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Account ID: <span class="mx-5">{{ $admin->admin_id }}</span></h5>
                    <h5 class="card-title">Last Name: <span class="mx-5">{{ $user->last_name }}</span></h5>
                    <h5 class="card-title">First Name: <span class="mx-5">{{ $user->first_name }}</span></h5>
                    <h5 class="card-title">Gender: <span class="mx-5">{{ $user->gender }}</span></h5>
                    <h5 class="card-title">Department Assigned: <span class="mx-5">{{ $admin->departments->first()->name }}</span></h5>
                    <h5 class="card-title">Role: <span class="mx-5">{{ $admin->roles->first()->name }}</span></h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
