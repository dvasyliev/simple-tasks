<?php
class ControllerTaskTask extends Controller
{
    private $error = array();

    public function index()
    {
        // Загрузка модели для задач
        $this->load->model( "task/task" );

        // Формирование переменных для постраничной навигации
        $total = $this->model_task_task->getTaskTotal();
        $page = isset( $this->request->get[ "page" ] ) ? $this->request->get[ "page" ] : 1;
        $limit = 3;

        // Формирование фильтров для страницы
        $filters = array(
            'start' => ( $page - 1 ) * $limit,
            'limit' => $limit
        );

        // Получение задач
        $tasks = $this->model_task_task->getTasks( $filters );
        foreach( $tasks as $key => $task ):
            $task = array(
                "id_task"           => $task[ "id_task" ],
                "id_task_status"    => $task[ "id_task_status" ],
                "status"            => $task[ "status" ],
                "login"             => $task[ "login" ],
                "email"             => $task[ "email" ],
                "text"              => $task[ "text" ],
                "image"             => $task[ "image" ],
            );

            $data[ "tasks" ][] = $task;
        endforeach;

        // Полчение статусов задач
        $statuses = $this->model_task_task->getStatuses();
        foreach( $statuses as $status ):
            $data[ "statuses" ][] = array(
                "id_task_status"    => $status[ "id_task_status" ],
                "status"            => $status[ "status" ],
                "label"             => $status[ "label" ],
            );
        endforeach;

        // Формировнаие CSS классов для статусов задач
        $data[ "status_classes" ] = array(
            1 => 'default',
            2 => 'primary',
            3 => 'warning',
            4 => 'success',
        );

        // Формирование постраничной навигации
        $pagination = new Pagination(
            'task-pagination',
            BASE_URI . "tasks" . $this->request->get[ "path" ] . "?page={page}",
            $total,
            $page,
            $limit
        );
        $data[ "pagination" ] = $pagination->render();

        $data[ "error" ][ "login" ] = $this->error[ "login" ] ? $this->error[ "login" ] : "";
        $data[ "error" ][ "email" ] = $this->error[ "email" ] ? $this->error[ "email" ] : "";
        $data[ "error" ][ "text" ] = $this->error[ "text" ] ? $this->error[ "text" ] : "";

        $this->load->view( "task/task", $data );
    }

    public function add()
    {
        if( $this->request->server[ "REQUEST_METHOD" ] === "POST" && $this->validate() ):
            $this->model_task_task->addTask( $this->request->post );
        endif;
    }

    public function update()
    {
        if( $this->request->server[ "REQUEST_METHOD" ] === "POST" && $this->validate() ):
            $this->model_task_task->updateTask( $this->request->post );
        endif;
    }

    public function delete()
    {
        if( $this->request->server[ "REQUEST_METHOD" ] === "POST" ):
            $this->model_task_task->deleteTask( $this->request->post[ "id_task" ] );
        endif;
    }

    public function validate()
    {
        $login = $this->request->post[ "login" ];
        $email = $this->request->post[ "email" ];
        $text = $this->request->post[ "text" ];

        if( strlen( trim( $login ) ) < 3 || strlen( trim( $login ) ) > 32 ):
            $this->error[ "login" ] = "Логин пользователя должен быть от 3 до 32 символов";
        endif;

        if( strlen( trim( $email ) ) > 96 || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email ) ):
            $this->error[ "email" ] = "Не корректный email пользователя";
        endif;

        if( strlen( trim( $text ) ) < 1 || strlen( trim( $text ) ) > 256 ):
            $this->error[ "text" ] = "Текст должен быть не более 256 символов";
        endif;

        return !$this->error;
    }
}
