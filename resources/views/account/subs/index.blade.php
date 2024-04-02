@extends('layout.main')
@section('konten')
    @include('layout.sidebar')
    <div class="d-flex justify-content-center align-items-center ">
        <div class="d-flex justify-content-center align-items-center flex-column text-center rounded mt-3 w-50 h-100 border border-success ">
            <h2>Subs Detail</h2>
            {{-- @dd(!auth()->user()->subscription('Year')->cancel() == null) --}}

            @if (auth()->user()->subscribed())
            @if (!auth()->user()->subscription('default')->canceled())
                <form action="{{ route('account.subs.cancel') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger m-5" >Cancel Subs</button>
                </form> 
            @endif
            @endif

            @if (auth()->user()->subscribed())
            @if (auth()->user()->subscription('default')->canceled())
                <form action="{{ route('account.resume.store') }}" method="POST">
                    @csrf
                    <button class="btn btn-warning m-5" >Resume Subs</button>
                </form> 
            @endif
            @endif
        </div>
    </div>

@endsection