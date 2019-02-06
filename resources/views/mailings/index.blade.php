@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                    @if(Request::get('deleted', 0) == 0)
                        <h4 class="mb-0">Запланированные рассылки</h4>
                        <div>
                            <a href="{{ route('mailings.create') }}" class="btn btn-primary btn-sm">Новая рассылка</a>
                            <a href="{{ route('mailings.index', ['deleted' => 1]) }}" class="btn btn-outline-secondary btn-sm">Отправленные и удалённые рассылки</a>
                        </div>
                    @else
                        <h4 class="mb-0">Отправленные и удалённые рассылки</h4>
                        <a href="{{ route('mailings.index') }}" class="btn btn-outline-success btn-sm">Запланированные рассылки</a>
                    @endif
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-border table-hover mb-0">
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
                        <td>{{ $mailing->send_at ?? "Не задано" }}</td>
                        <td>
                            @if($mailing->trashed())
                                <a href="{{ route('mailings.show', ['id' => $mailing->id]) }}" class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); $('#del_{{ $mailing->id }}').submit();">Удалить навсегда</a>
                            @else
                                <a href="{{ route('mailings.show', ['id' => $mailing->id]) }}" class="btn btn-outline-primary btn-sm" onclick="event.preventDefault(); $('#send_{{ $mailing->id }}').submit();">Отправить</a>
                                <a href="{{ route('mailings.edit', ['id' => $mailing->id]) }}" class="btn btn-outline-success btn-sm">Редактировать</a>
                                <a href="{{ route('mailings.show', ['id' => $mailing->id]) }}" class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); $('#del_{{ $mailing->id }}').submit();">Удалить</a>
                            @endif
                            <form action="{{ route('mailings.send', ['id' => $mailing->id]) }}" id="send_{{ $mailing->id }}" method="post" style="display: none;">
                                @csrf
                            </form>
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
        <div class="card-footer">
            При отправке рассылки она автоматически удаляется
        </div>
    </div>
@endsection

