@extends('layouts.app')

@section('content')

<div class="row justify-content-center pt-5">
    <div class="col-6">
        <div class="alert alert-danger" role="alert">
            <h3 class="text-center">No room is activated!</h3>
        </div>
    </div>
</div>
<div class="row justify-content-center pt-5">
    <div class="col-3">
        <div class="text-center">
            <a href="/room" class="btn btn-block  btn-lg">
                <i class="far fa-arrow-alt-circle-right fa-4x"></i>
                <h3>Go to room</h3>
            </a> 
        </div>
    </div>
</div>

@endsection