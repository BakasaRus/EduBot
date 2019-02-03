<div class="form-group">
    <label for="nameId">Название</label>
    <input type="text"
           class="form-control" name="name" id="nameId" aria-describedby="nameHelpId" placeholder="" value="{{ old('name') ?? $list->name ?? "" }}">
    <small id="nameHelpId" class="form-text text-muted">Введите название списка рассылки. Оно должно быть уникальным</small>
</div>
<div class="form-group">
    <label for="subscribersId">Получатели</label>
    <select multiple class="form-control" name="subscribers[]" aria-describedby="subscribersHelpId" id="subscribersId">
        @foreach($subscribers as $subscriber)
            @isset($list)
                <option value="{{ $subscriber->id }}" {{ (old('subscribers') ?? $list->subscribers)->contains($subscriber) ? "selected" : "" }}>{{ $subscriber->full_name }}</option>
            @else
                <option value="{{ $subscriber->id }}">{{ $subscriber->full_name }}</option>
            @endisset
        @endforeach
    </select>
    <small id="subscribersHelpId" class="form-text text-muted">Выбирать и убирать нескольких получателей можно с помощью зажатой кнопки <kbd>Ctrl</kbd></small>
</div>