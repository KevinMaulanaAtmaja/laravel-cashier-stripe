<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
      <a class="navbar-brand" href="/">Cashier Stripe</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar">
        <div class="navbar-nav">
          <a class="nav-link" href="/">Home</a>
          <a class="nav-link" href="{{ route('subscriptions.plans') }}">Plan</a>
          <a class="nav-link" href="{{ route('subscriptions.checkout') }}">Checkout</a>
          <a class="nav-link disabled">Dashboard</a>
        </div>
      </div>
    </div>
  </nav>