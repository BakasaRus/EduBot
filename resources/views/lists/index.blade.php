@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Списки рассылок
        </div>
        <table class="table table-border table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Подписчики</th>
                <th>Создана</th>
                <th>Изменена</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $list)
                <tr>
                    <td>{{ $list->id }}</td>
                    <td>{{ $list->name }}</td>
                    <td>{{ $list->subscribers->pluck('id') }}</td>
                    <td>{{ $list->created_at }}</td>
                    <td>{{ $list->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

