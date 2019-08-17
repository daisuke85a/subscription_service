@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    Administrator registration
                </div>

                @component('components.register_body')
                @endcomponent

            </div>
        </div>
    </div>
</div>
@endsection
