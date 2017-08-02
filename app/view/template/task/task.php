<?php include DIR_TEMPLATE . '/common/header.php' ?>

<div class="container">
    <div class="jumbotron">
        <h1>Простой задачник!</h1>
        <p class="lead">Добавляйте с легкостью задачи, которые нужно выполнить и устанавливайте им статусы выполнения.
            Также есть возможность прекрепить изображанени к задачи.</p>
        <p><a class="btn btn-lg btn-success"
               id="task-button-open-add-modal"
               href="#"
               role="button"
               data-toggle="modal"
               data-target="#taskAddModal">Добавить задачу</a>
        </p>
    </div>

    <div class="page-header">
        <h1>Список задач <small>(добавляйте задачи без регистрации)</small></h1>
    </div>

    <div class="task-sort">
        <div class="task-sort__item">Сортировать по:</div>
        <div class="task-sort__item">
            <div class="btn-group">
                <?php foreach( $sort_params as $key => $sort_param ): ?>
                    <button type="button" 
                            class="btn <?= $sort_param[ "active"] ? "btn-primary" : "btn-default" ?>" 
                            data-sort="<?= $key ?>">
                        <?= $sort_param[ "name" ] ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="task-sort__item">
            <div class="btn-group">
                <?php foreach( $order_params as $key => $order_param ): ?>
                    <button type="button"
                            class="btn <?= $order_param[ "active"] ? "btn-primary" : "btn-default" ?>"
                            data-order="<?= $key ?>">
                        <span class="<?= $order_param[ "icon" ] ?>"></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/parts/task-list.php'; ?>

    <?= $pagination ?>
</div>

<?php include __DIR__ . '/parts/task-add-modal.php' ?>
<?php include __DIR__ . '/parts/task-update-modal.php' ?>

<?php include DIR_TEMPLATE . '/common/footer.php' ?>