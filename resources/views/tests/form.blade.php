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