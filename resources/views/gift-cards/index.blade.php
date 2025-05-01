@extends('layouts.app')

@section('content')
    <h1>Gift Cards</h1>
    <ul>
        @foreach ($giftCards as $giftCard)
            <li>Code: {{ $giftCard->code }} - Balance: ${{ $giftCard->balance }}</li>
        @endforeach
    </ul>
@endsection