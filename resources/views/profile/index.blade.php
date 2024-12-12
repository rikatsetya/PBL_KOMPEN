<!-- resources/views/profile/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    <p>This is your profile page.</p>
@endsection
