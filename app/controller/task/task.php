<?php
class ControllerTaskTask extends Controller
{
    private $error = array();

    public function index()
    {
        $data[ "is_logged" ] = $this->user->isLogged();
        $data[ "is_admin" ] = $this->user->isAdmin();
        $data[ "login" ] = $this->user->getLogin();

        // Загрузка модели для задач
        $this->load->model( "task/task" );

        // Формирование переменных для постраничной навигации
        $total = $this->model_task_task->getTaskTotal();
        $sort = isset( $this->request->get[ "sort" ] ) ? $this->request->get[ "sort" ] : "id_task";
        $order = isset( $this->request->get[ "order" ] ) ? $this->request->get[ "order" ] : "ASC";
        $page = isset( $this->request->get[ "page" ] ) ? $this->request->get[ "page" ] : 1;
        $limit = isset( $this->request->get[ "limit" ] ) ? $this->request->get[ "limit" ] : 3;

        // Формирование фильтров для страницы
        $filters = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ( $page - 1 ) * $limit,
            'limit' => $limit
        );

        // Формирование параметров сортировки
        $data[ "sort_params" ] = array(
            "id_task" => array(
                "table_prefix" => "t",
                "name" => "Номер задачи",
                "active" => "id_task" === $sort,
            ),
            "id_task_status" => array(
                "table_prefix" => "t",
                "name" => "Статус задачи",
                "active" => "id_task_status" === $sort,
            ),
            "login" => array(
                "table_prefix" => "t",
                "name" => "Логин",
                "active" => "login" === $sort,
            ),
            "email" => array(
                "table_prefix" => "t",
                "name" => "Email",
                "active" => "email" === $sort,
            ),
        );

        $data[ "order_params" ] = array(
            "ASC" => array(
                "icon" => "glyphicon glyphicon-sort-by-attributes",
                "active" => "ASC" === $order,
            ),
            "DESC" => array(
                "icon" => "glyphicon glyphicon-sort-by-attributes-alt",
                "active" => "DESC" === $order,
            ),
        );

        // Получение задач
        $tasks = $this->model_task_task->getTasks( $filters, $data[ "sort_params" ] );
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
        $params = array_merge( $this->request->get, array( "page" => "{page}" ) );
        $pagination = new Pagination(
            'task-pagination',
            $this->url->link( "tasks", $params ),
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
            if( $this->request->files && is_uploaded_file( $this->request->files[ "image" ][ "tmp_name" ] ) ):
                $image = new Image( $this->request->files[ "image" ] );
                $task_image = $image->getImage( 320, 240 );

                $task_fields = array_merge(
                    array( "image" => $task_image ),
                    $this->request->post
                );

                $this->model_task_task->addTask( $task_fields );
            endif;

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
