@extends('layouts.app')

@section('content')
    <h1>Notifications</h1>
    <ul>
        @foreach ($notifications as $notification)
            <li>{{ $notification->message }} - {{ $notification->created_at->format('M d, Y H:i') }}</li>
        @endforeach
        </ul>
 @endsection