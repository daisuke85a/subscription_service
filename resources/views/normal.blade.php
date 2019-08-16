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
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection