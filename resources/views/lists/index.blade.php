@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Списки рассылок</h4>
                <a href="{{ route('lists.create') }}" class="btn btn-primary btn-sm">Новый список рассылок</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-border table-hover mb-0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Подписчики</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                    <tr>
                        <td>{{ $list->id }}</td>
                        <td><a href="{{ route('lists.show', ['id' => $list->id]) }}">{{ $list->name }}</a></td>
                        <td>{{ $list->subscribers->count() }}</td>
                        <td>
                            <a href="{{ route('lists.edit', ['id' => $list->id]) }}" class="btn btn-outline-success btn-sm">Редактировать</a>
                            <a href="{{ route('lists.show', ['id' => $list->id]) }}" class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); $('#del_{{ $list->id }}').submit();">Удалить</a>
                            <form action="{{ route('lists.destroy', ['id' => $list->id]) }}" id="del_{{ $list->id }}" method="post" style="display: none;">
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

