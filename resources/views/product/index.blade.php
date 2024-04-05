@extends('layout.main')
@section('konten')

    @foreach ($products as $p)
        <div class="d-flex justify-content-center align-items-center flex-column">
            <img src="{{ $p->image }}" alt="" class="rounded " width="200">
            {{-- <div >{{ $p->image }}</div> --}}
            <div>{{ $p->name }}</div>
            <div>{{ $p->price }}</div>
        </div>
    @endforeach
    <form action="{{ route('checkout') }}" method="POST" class="text-center m-5">
        @csrf
        <button class="btn btn-outline-dark">Checkout</button>
    </form>
@endsection