@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Список подписчиков рассылок
        </div>
        <table class="table table-border table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Согласие на рассылку</th>
                <th>Создан</th>
                <th>Изменён</th>
            </tr>
            </thead>
            <tbody>
            @foreach($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->id }}</td>
                    <td>{{ $subscriber->agreed }}</td>
                    <td>{{ $subscriber->created_at }}</td>
                    <td>{{ $subscriber->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

