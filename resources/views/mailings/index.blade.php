@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Рассылки
        </div>
        <table class="table table-border table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Текст</th>
                <th>Прикрепления</th>
                <th>Список рассылки</th>
                <th>Отправлена</th>
                <th>Создана</th>
                <th>Изменена</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mailings as $mailing)
                <tr>
                    <td>{{ $mailing->id }}</td>
                    <td>{{ $mailing->name }}</td>
                    <td style="white-space: pre-wrap;">{{ $mailing->text }}</td>
                    <td>{{ $mailing->attachments }}</td>
                    <td>{{ $mailing->mailingList->name }}</td>
                    <td>{{ $mailing->send_at }}</td>
                    <td>{{ $mailing->created_at }}</td>
                    <td>{{ $mailing->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

