@if(isset($payment['name']))
    @if($payment['name'] == config('stripe.name'))
        @include('front.payments.stripe')
    @elseif($payment['name'] == config('cash-on-delivery.name'))
        @include('front.payments.cash-on-delivery')
    @endif
@endif