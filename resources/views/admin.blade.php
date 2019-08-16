@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">管理画面</div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">メールアドレス</th>
                            <th scope="col">プラン</th>
                            <th scope="col">ステータス</th>
                            <th scope="col">作成日時</th>
                            <th scope="col">更新日時</th>
                            </tr>           
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->plan }}</td>
                            <td>{{ $user->status_text }}</td>
                            <td>{{ $user->created_due_date }}</td>
                            <td>{{ $user->updated_due_date }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
