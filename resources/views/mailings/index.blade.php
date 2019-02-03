@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Рассылки</h4>
                <a href="{{ route('mailings.create') }}" class="btn btn-primary btn-sm">Новая рассылка</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-border mb-0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Список рассылки</th>
                    <th>Время рассылки</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($mailings as $mailing)
                    <tr>
                        <td>{{ $mailing->id }}</td>
                        <td><a href="{{ route('mailings.show', ['id' => $mailing->id]) }}">{{ $mailing->name }}</a></td>
                        <td>{{ $mailing->mailingList->name }}</td>
                        <td>{{ $mailing->send_at }}</td>
                        <td>
                            <a href="{{ route('mailings.show', ['id' => $mailing->id]) }}" aria-disabled="true" class="btn btn-outline-primary btn-sm">Отправить</a>
                            <a href="{{ route('mailings.edit', ['id' => $mailing->id]) }}" class="btn btn-outline-success btn-sm">Редактировать</a>
                            <a href="{{ route('mailings.show', ['id' => $mailing->id]) }}" class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); $('#del_{{ $mailing->id }}').submit();">Удалить</a>
                            <form action="{{ route('mailings.destroy', ['id' => $mailing->id]) }}" id="del_{{ $mailing->id }}" method="post" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

