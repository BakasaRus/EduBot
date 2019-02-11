<div class="form-group">
    <label for="nameId">Название</label>
    <input type="text" class="form-control" name="name" id="nameId" aria-describedby="nameHelpId" value="{{ old('name') ?? $test->name ?? "" }}">
    <small id="nameHelpId" class="form-text text-muted">Название теста должно быть уникальным</small>
</div>
<div class="form-group">
    <label for="descriptionId">Описание</label>
    <textarea class="form-control" name="description" id="descriptionId" aria-describedby="descriptionHelpId" rows="3">{{ old('description') ?? $test->description ?? "" }}</textarea>
    <small id="descriptionHelpId" class="form-text text-muted">Описание должно пояснять смысл теста, так как оно будет отображаться в боте вместе с названием</small>
</div>
<div class="form-group">
    <label for="timeLimitId">Время на тест</label>
    <input type="number" min="1"
           class="form-control" name="time_limit" id="timeLimitId" aria-describedby="limitHelpId" value="{{ old('time_limit') ?? $test->time_limit ?? "" }}">
    <small id="limitHelpId" class="form-text text-muted">Время на тест задаётся целым числом минут. Минимальное время - одна минута.</small>
</div>
<div class="form-group">
    <label for="maxAttemptsId">Количество попыток</label>
    <input type="number" min="1" class="form-control" name="max_attempts"
           id="maxAttemptsId" aria-describedby="attemptsHelpId"
           value="{{ old('max_attempts') ?? $test->max_attempts ?? "" }}">
    <small id="attemptsHelpId" class="form-text text-muted">Минимальное количество попыток на тест - 1</small>
</div>