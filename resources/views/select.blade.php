@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-2">
            <div class="panel panel-info">
                <div class="panel-heading">PLAN A</div>
                <div class="panel-body">
                    <p>¥1,000</p>
                    <form action="/select" method="POST">
                        {{ csrf_field()}}
                        <input type="hidden" id="plan" name="plan" value="1000">
                        <input type="submit" value="Get Start!" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="panel panel-info">
                <div class="panel-heading">PLAN B</div>
                <div class="panel-body">
                    <p>¥3,000</p>
                    <form action="/select" method="POST">
                        {{ csrf_field()}}
                        <input type="hidden" id="plan" name="plan" value="3000">
                        <input type="submit" value="Get Start!" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="panel panel-info">
                <div class="panel-heading">PLAN C</div>
                <div class="panel-body">
                    <p>¥5,000</p>
                    <form action="/select" method="POST">
                        {{ csrf_field()}}
                        <input type="hidden" id="plan" name="plan" value="5000">
                        <input type="submit" value="Get Start!" class="btn btn-primary">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection