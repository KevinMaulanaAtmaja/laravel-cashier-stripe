@extends('layout.main')
@section('konten')
<div class="container col-md-5">
    <h1 class="text-primary">Checkout</h1>
    <div class="card p-3 mt-5">
        <form action="{{ route('subscriptions.store') }}" method="POST" id="form-element">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Name of card</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Amelia">
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">Card details</label>
                <div class="form-control" id="card-element"></div>
            </div>
            <input type="hidden" name="plan" value="{{ $plans }}">
            <button 
                type="submit"
                class="btn btn-dark px-5" id="card-btn" data-secret="{{ $intent->client_secret }}">
                PAY
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const stripe = Stripe('{{ config('cashier.key') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const form = document.getElementById('form-element');
    const cardBtn = document.getElementById('card-btn');
    const cardName = document.getElementById('nama');
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        // console.log('submit');
        cardBtn.disabled = true;
        const {setupIntent, error} = await stripe.confirmCardSetup(
            cardBtn.dataset.secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name:  cardName.value
                    }
                }
            }
        );

        if (error) {
            console.log(error);
            cardBtn.disabled = false;
        } else {
            // console.log(setupIntent);
            
            let token = document.createElement('input');
            token.setAttribute('type','hidden');
            token.setAttribute('name','token');
            token.setAttribute('value',setupIntent.payment_method);

            form.appendChild(token);
            form.submit();
        }
    });
</script>
@endsection
