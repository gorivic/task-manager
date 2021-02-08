<form action="?modal=saveTask" method="post" id="taskForm">

    <input type="hidden" name="t_id" id="t_id" class="form-control" value="<?= @$pageData['task']['t_id'] ?>" />

    <div class="row">
        <div class="col-sm">
            <b>Исполнитель*</b> 
            <input type="text" name="t_username" id="t_username" class="form-control" value="<?= @$pageData['task']['t_username'] ?>" />
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-sm">
            <b>E-mail*</b> 
            <input type="text" name="t_email" id="t_email" class="form-control" value="<?= @$pageData['task']['t_email'] ?>" />
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-sm">
            <b>Задание*</b>
            <input type="text" name="t_text" id="t_text" class="form-control" value="<?= @$pageData['task']['t_text'] ?>" />
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-sm">
            
            <div class="form-check" <?= @$pageData['task']['t_id'] > 0 ? '' : 'hidden' ?>>
                <input class="form-check-input" type="checkbox" name="t_done" value="1" <?= @$pageData['task']['t_done'] ? 'checked' : '' ?> id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Выполнено
                </label>
            </div>
        </div>
    </div>

</form>