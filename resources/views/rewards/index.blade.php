@extends('layouts.app')

@section('content')
    <h1>Loyalty Rewards</h1>
    <ul>
        @foreach ($rewards as $reward)
            <li>{{ $reward->name }} - {{ $reward->points }} points</li>
        @endforeach
    </ul>
@endsection