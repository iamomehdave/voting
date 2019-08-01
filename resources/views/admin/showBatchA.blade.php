@extends('layouts.inner')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
               <div class="card-header"><h4> <center>{{$value->fname}} Details</center> </h4></div>
                
                <p><img src="{{asset('images/'.$value->image)}}" alt="hello" class="thumbnail"></p>
                <p><strong>Name</strong>{{$value->fname}}</p>
                <p><strong>Email</strong>{{$value->email}}</p>
            </div>
        </div>
    </div>
</div>
@endsection
