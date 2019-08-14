@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <div class="card">
                <div class="card-header">PLAN A</div>
                <div class="card-body">
                    <p>¥1,000</p>
                    <a class="btn btn-outline-primary" href="/">
                        選択
                    </a>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="card">
                <div class="card-header">PLAN B</div>
                <div class="card-body">
                    <p>¥2,000</p>
                    <a class="btn btn-outline-primary" href="/">
                        選択
                    </a>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="card">
                <div class="card-header">PLAN C</div>
                <div class="card-body">
                    <p>¥5,000</p>
                    <a class="btn btn-outline-primary" href="/">
                        選択
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection