@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
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
            <input type="submit" value="退会する" class="btn btn-danger">
        </form>
        @else
        <p>課金していません</p>
        <p>課金する場合はプランを選択してください</p>
        @component('components.select_plan')
        @endcomponent
        @endif
        @endif
    </div>
</div>
@endsection