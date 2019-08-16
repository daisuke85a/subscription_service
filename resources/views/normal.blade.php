@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (Auth::check() === true)
                    @if (Auth::user()->status === 1)
                    <p>月に¥{{Auth::user()->plan}}のコースで課金中です</p>
                    <form action="/unsubscribe" method="POST">
                        {{ csrf_field()}}
                        <input type="submit" value="退会する" class="btn btn-outline-primary">
                    </form>
                    @else
                    <p>課金していません</p>
                    <p>課金する場合はプランを選択してください</p>
                    <div class="row justify-content-center">
                        <div class="col-2">
                            <div class="card">
                                <div class="card-header">PLAN A</div>
                                <div class="card-body">
                                    <p>¥1,000</p>
                                    <form action="/select" method="POST">
                                        {{ csrf_field()}}
                                        <input type="hidden" id="plan" name="plan" value="1000">
                                        <input type="submit" value="Get Start!" class="btn btn-outline-primary">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <div class="card-header">PLAN B</div>
                                <div class="card-body">
                                    <p>¥3,000</p>
                                    <form action="/select" method="POST">
                                        {{ csrf_field()}}
                                        <input type="hidden" id="plan" name="plan" value="3000">
                                        <input type="submit" value="Get Start!" class="btn btn-outline-primary">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <div class="card-header">PLAN C</div>
                                <div class="card-body">
                                    <p>¥5,000</p>
                                    <form action="/select" method="POST">
                                        {{ csrf_field()}}
                                        <input type="hidden" id="plan" name="plan" value="5000">
                                        <input type="submit" value="Get Start!" class="btn btn-outline-primary">
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection