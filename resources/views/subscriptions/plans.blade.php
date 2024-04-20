@extends('layout.main')
@section('konten')
<div class="container d-grid justify-content-center">
    <h2 class="text-info">Subscribe Plans</h2>
    @if (auth()->user()->stripe_id)
        <div class="alert alert-success text-center">Sudah Subscribe</div>
    @endif
    <div class="row">
        @foreach ($plan as $p)
        <div class="col-12 col-md-auto">
            <div class="card my-3 p-5">
                <img src="{{ asset('img/anya.png') }}"class="card-img-top img-fluid" alt="" style="width: 200px;">
                <div class="card-body">
                    <h5 class="card-title">{{$p->title}}</h5>
                    <p class="card-text">{{$p->slug}}</p>
                    <a href="{{ route('subscriptions.checkout', ['plan' => $p->slug]) }}" class="btn btn-primary">{{$p->title}}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
