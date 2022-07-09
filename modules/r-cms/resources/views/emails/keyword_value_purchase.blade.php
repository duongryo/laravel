@extends('emails.layout')

@section('content')
    <div class="card-image">
        <span class="title">
            Payment Success
        </span>
        <img class="image" src="https://i.imgur.com/7iJYnBZ.png" alt="">
    </div>

    <div class="card-content">
        <p class="text-hello">Hello
            <span style="font-weight:700">{{ $user->name }},</span>
        </p>

        <p class="content-email">
            Your payment of {{ number_format($transaction->amount) }}
            USD for the purchase of WriterZen 
            @if($transaction->keyword_value)
            {{ number_format($transaction->keyword_value) }} keyword credit 
            @endif
            @if($transaction->content_value)
            {{ number_format($transaction->content_value) }} content credit 
            @endif
            was processed successfully on {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}.
            <br>
            <br>
            Enjoy creating your very own KILLER content!
            <br>
            <br>
            Best,
            <br>
            WriterZen
        </p>
    </div>
@endsection
