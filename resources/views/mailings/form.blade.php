<div class="form-group">
    <label for="nameId">Название</label>
    <input type="text" class="form-control" name="name" id="nameId" aria-describedby="nameHelpId" placeholder="" value="{{ old('name') ?? $mailing->name ?? "" }}">
    <small id="nameHelpId" class="form-text text-muted">Введите название рассылки. Оно должно быть уникальным</small>
</div>
<div class="form-group">
    <label for="textId">Текст рассылки</label>
    <textarea class="form-control" name="text" id="textId" rows="3">{{ old('text') ?? $mailing->text ?? "" }}</textarea>
</div>
<div class="form-group">
    <label for="attachmentsId">Прикрепления</label>
    <input type="text" class="form-control" name="attachments" id="attachmentsId" aria-describedby="attachmentsHelpId" placeholder="" value="{{ old('attachments') ?? $mailing->attachments ?? "" }}">
    <small id="attachmentsHelpId" class="form-text text-muted">Здесь можно указать вложения, которые будут прикреплены к сообщению. Они уже должны быть загружены ВК</small>
</div>
<div class="form-group">
    <label for="mailingListId">Список рассылки</label>
    <select class="form-control" name="mailing_list_id" id="mailingListId">
        @isset($mailing)
            @foreach($lists as $list)
                <option value="{{ $list->id }}" {{ (old('mailing_list_id') ?? $mailing->mailingList->id) == $list->id ? "selected" : "" }}>{{ $list->name }}</option>
            @endforeach
        @else
            @foreach($lists as $list)
                <option value="{{ $list->id }}" {{ old('mailing_list_id') == $list->id ? "selected" : "" }}>{{ $list->name }}</option>
            @endforeach
        @endisset
    </select>
</div>
<div class="form-group">
    <label for="sendAtId">Время рассылки</label>
    <input type='datetime-local' class="form-control" name="send_at" id='sendAtId' aria-describedby="sendAtHelpId" value="{{ old('send_at') ?? $mailing->send_at ?? "" }}"/>
    <small id="sendAtHelpId" class="form-text text-muted">Дата и время начала рассылки сообщений</small>
</div>