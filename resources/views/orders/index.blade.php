@extends('layouts.app')

@section('content')
    <h1>Order History</h1>
    <ul>
        @foreach ($orders as $order)
            <li>Order #{{ $order->id }} - {{ $order->status }}</li>
        @endforeach
    </ul>
@endsection