<div class="task-list">
    <?php foreach ($tasks as $task): ?>
        <div class="panel panel-default task-list__item task-detail"
             data-task-id="<?= $task[ "id_task" ] ?>"
             data-task-status-id="<?= $task[ "id_task_status" ] ?>">
            <div class="panel-heading task-detail__panel-heading">
                <h4>Задача №<?= $task["id_task"] ?>
                    <span class="label label-<?= $status_classes[$task["id_task_status"]] ?> task-detail__status">
                        <?= $task["status"] ?>
                    </span>

                    <?php if( $is_admin ): ?>
                        <button class="task-detail__button-delete">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>

                        <button class="task-detail__button-edit"
                                data-toggle="modal"
                                data-target="#taskUpdateModal">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                    <?php endif; ?>
                </h4>
            </div>

            <div class="panel-body task-detail__body">
                <div class="task-detail__image-block">
                    <div class="task-detail__image" style="background-image: url('<?= $task["image"] ?>')"></div>
                </div>

                <div class="task-detail__content-block">
                    <ul class="list-group task-detail__list">
                        <li class="list-group-item task-detail__list-item">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <b>Имя: </b><span class="task-detail__login"><?= $task["login"] ?></span>
                        </li>

                        <li class="list-group-item task-detail__list-item">
                            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                            <b>E-mail: </b><span class="task-detail__email"><?= $task["email"] ?></span>
                        </li>

                        <li class="list-group-item task-detail__list-item">
                            <span class="task-detail__text"><?= $task["text"] ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>