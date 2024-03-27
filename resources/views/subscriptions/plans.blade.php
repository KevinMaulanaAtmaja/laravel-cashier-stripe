@extends('layout.main')
@section('konten')
<div class="container d-flex justify-content-center align-items-center vh-100">
        @foreach ($plan as $p)
            <div class="col-md-4">
                <div class="card " style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$p->title}}</h5>
                        <p class="card-text">{{$p->slug}}</p>
                        <a href="#" class="btn btn-primary">{{$p->title}}</a>
                    </div>
                </div>
        </div>
        @endforeach    
</div>
@endsection
