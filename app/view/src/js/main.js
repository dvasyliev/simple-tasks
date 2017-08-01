$(document).ready(function () {
    var $taskAddForm = $('#task-add-form'),
        $taskUpdateForm = $('#task-update-form');

    // Открытие модального окна для редактирования задачи
    $('body').on('click', '.task-detail__button-edit', function () {
        var $task = $(this).parents('.task-detail'),
            taskId = $task.data('task-id'),
            taskStatusId = $task.data('task-status-id'),
            taskLogin = $.trim($task.find('.task-detail__login').text()),
            taskEmail = $.trim($task.find('.task-detail__email').text()),
            taskText = $.trim($task.find('.task-detail__text').text());

        // Вставка данных про задачу в форму редактирования
        $('#taskUpdateModalLabel span').text(taskId);
        $taskUpdateForm.find('input[name="id_task"]').val(taskId);
        $taskUpdateForm.find('select[name="id_task_status"] option[value="' + taskStatusId + '"]')
            .attr('selected', 'selected');
        $taskUpdateForm.find('input[name="login"]').val(taskLogin);
        $taskUpdateForm.find('input[name="email"]').val(taskEmail);
        $taskUpdateForm.find('textarea[name="text"]').text(taskText);
    });

    // Ajax запрос на добавление задачи
    $taskAddForm.on('submit', function (event) {
        event.preventDefault();

        var data = $(this).serialize(),
            action = $(this).attr('action');

        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function () {
                window.location.href = "http://simple-tasks/tasks";
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    // Ajax запрос на редактирование задачи
    $taskUpdateForm.on('submit', function (event) {
        event.preventDefault();

        var data = $(this).serialize(),
            action = $(this).attr('action'),
            taskId = $(this).data('task-id');

        $.ajax({
            url: action,
            type: 'POST',
            data: 'id_task=' + taskId + '&' + data,
            success: function () {
                window.location.href = "http://simple-tasks/tasks";
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    // Ajax запрос на удаление задачи
    $('body').on('click', '.task-detail__button-delete', function () {
        var $task = $(this).parents('.task-detail'),
            taskId = $task.data('task-id');

        $.ajax({
            url: 'tasks/delete',
            type: 'POST',
            data: 'id_task=' + taskId,
            success: function (json) {
                $task.remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
});