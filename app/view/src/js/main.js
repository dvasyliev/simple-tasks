$(document).ready(function () {
    var $taskSortBlock = $('.task-sort'),
        $taskAddForm = $('#task-add-form'),
        $taskPreviewBlock = $('#task-preview-content'),
        $taskUpdateForm = $('#task-update-form');

    $taskUpdateForm.find('input[name="image"]').prop('disabled', true).parents('.form-group').hide();

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

        var action = $(this).attr('action'),
            formData = new FormData(this);

        formData.append('login', $(this).find('input[name="login"]')[0].value);
        formData.append('email', $(this).find('input[name="email"]')[0].value);
        formData.append('image', $(this).find('input[name="image"]')[0].files[0]);
        formData.append('text', $(this).find('textarea[name="text"]')[0].value);

        $.ajax({
            url: action,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                window.location.href = window.location.origin + '/tasks';
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('#task-preview-content-tab').on('click', function () {
        var data = $taskAddForm.serializeArray();

        data.forEach(function (item) {
            $taskPreviewBlock.find('.task-detail__' + item.name).html(item.value)
        });
    });

    // Ajax запрос на редактирование задачи
    $taskUpdateForm.on('submit', function (event) {
        event.preventDefault();

        var taskId = $(this).data('task-id'),
            action = $(this).attr('action'),
            data = $(this).serialize();

        $.ajax({
            url: action,
            type: 'POST',
            data: 'id_task=' + taskId + '&' + data,
            success: function () {
                window.location.href = window.location.origin + '/tasks';
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
            success: function () {
                window.location.href = window.location.origin + '/tasks';
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    // Сортировка по параметрам
    $taskSortBlock.on('click', 'button', function () {
        $(this).siblings('.btn-primary').toggleClass('btn-default btn-primary');
        $(this).toggleClass('btn-default btn-primary');

        var params = {
                'sort': $taskSortBlock.find('.btn-primary[data-sort]').data('sort'),
                'order': $taskSortBlock.find('.btn-primary[data-order]').data('order'),
            },
            searchString = getSearchString(params);

        window.location.href = searchString;
    });

    // Функция заменяет старые поисковые параметры на новые
    // которые ей переданы и возвращает новую поисковую строку
    function getSearchString( args ) {
        var searchString = window.location.search,
            paramsArray = searchString ? searchString.slice(1).split('&') : [];

        if(paramsArray.length) {
            paramsArray.forEach(function (param) {
                var paramKeyValue = param.split('=');
                if (args[paramKeyValue[0]] === undefined) {
                    args[paramKeyValue[0]] = paramKeyValue[1];
                }
            });
        }

        return '?' + $.param(args);
    }
});