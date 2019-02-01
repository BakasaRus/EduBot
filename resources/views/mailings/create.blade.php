@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Новая рассылка</h5>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('mailings.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="nameId">Название</label>
                    <input type="text" class="form-control" name="name" id="nameId" aria-describedby="nameHelpId" placeholder="">
                    <small id="nameHelpId" class="form-text text-muted">Введите название рассылки. Оно должно быть уникальным</small>
                </div>
                <div class="form-group">
                    <label for="textId">Текст рассылки</label>
                    <textarea class="form-control" name="text" id="textId" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="attachmentsId">Прикрепления</label>
                    <input type="text" class="form-control" name="attachments" id="attachmentsId" aria-describedby="attachmentsHelpId" placeholder="wall1_2048795,photo1_456316251">
                    <small id="attachmentsHelpId" class="form-text text-muted">Здесь можно указать вложения, которые будут прикреплены к сообщению. Они уже должны быть загружены ВК</small>
                </div>
                <div class="form-group">
                    <label for="mailingListId">Список рассылки</label>
                    <select class="form-control" name="mailing_list_id" id="mailingListId">
                        @foreach($lists as $list)
                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sendAtId">Время рассылки</label>
                    <input type='datetime-local' class="form-control" name="send_at" id='sendAtId' aria-describedby="sendAtHelpId" />
                    <small id="sendAtHelpId" class="form-text text-muted">Дата и время начала рассылки сообщений</small>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

