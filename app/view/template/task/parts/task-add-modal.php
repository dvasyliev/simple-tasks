<div class="modal fade" id="taskAddModal" tabindex="-1" role="dialog" aria-labelledby="taskAddModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="taskAddModalLabel">Добавление новой задачи</h4>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#task-content" id="task-content-tab" data-toggle="tab">Задача</a></li>
                    <li><a href="#task-preview-content" id="task-preview-content-tab" data-toggle="tab">Предварительный просмотр</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="task-content">
                        <form class="form-horizontal"
                              id="task-add-form"
                              action="tasks/add"
                              method="POST">
                            <?php include __DIR__ . '/task-common-form-fields.php' ?>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default" id="task-button-add">Добавить</button>
                                    <button type="submit" class="btn btn-default" data-dismiss="modal" aria-label="Close">Отмена</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane" id="task-preview-content">
                        <?php include __DIR__ . '/task-detail-preview.php' ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>