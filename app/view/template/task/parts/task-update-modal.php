<div class="modal fade" id="taskUpdateModal" tabindex="-1" role="dialog" aria-labelledby="taskUpdateModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="taskUpdateModalLabel">Редактирование задачи №<span></span></h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal"
                      id="task-update-form"
                      action="tasks/update"
                      method="POST"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id_task" value="">

                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Статус</label>
                        <div class="col-sm-10">
                            <select class="form-control"
                                    id="status"
                                    name="id_task_status">
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?= $status["id_task_status"] ?>">
                                        <?= $status["status"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <?php include __DIR__ . '/task-common-form-fields.php' ?>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" id="task-button-save">Сохранить</button>
                            <button type="submit" class="btn btn-default" data-dismiss="modal" aria-label="Close">Отмена</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>