<?php

class ModelTaskTask extends Model
{
    public function getTasks()
    {
        $query = $this->db->query( "SELECT *
                                    FROM task t
                                    LEFT JOIN task_status ts
                                      ON t.id_task_status = ts.id_task_status" );

        return $query->rows;
    }

    public function getTaskTotal()
    {
        $query = $this->db->query( "SELECT COUNT( DISTINCT id_task ) AS 'total' FROM task" );

        return $query->row[ "total" ];
    }

    public function getTask( $id_task )
    {
        $query = $this->db->query( "SELECT *
                                    FROM task t
                                    LEFT JOIN task_status ts
                                      ON t.id_task_status = ts.id_task_status
                                    WHERE t.id_task = '" . $id_task . "'");

        return $query->row;
    }

    public function getStatuses()
    {
        $query = $this->db->query( "SELECT *
                                    FROM task_status");

        return $query->rows;
    }

    public function addTask( $data = array(), $id_task_status = 1 )
    {
        $this->db->query( "INSERT INTO task
                           SET id_task_status = '" . (int)$id_task_status . "' ,
                               login = '" . $this->db->escape( $data[ "login" ] ) . "' ,
                               email = '" . $this->db->escape( $data[ "email" ] ) . "' ,
                               text = '" . $this->db->escape( $data[ "text" ] ) . "'");
    }

    public function updateTask( $data = array() )
    {
        $this->db->query( "UPDATE task
                           SET id_task_status = '" . (int)$data[ "id_task_status"] . "' ,
                               login = '" . $this->db->escape( $data[ "login" ] ) . "' ,
                               email = '" . $this->db->escape( $data[ "email" ] ) . "' ,
                               text = '" . $this->db->escape( $data[ "text" ] ) . "' 
                           WHERE id_task = '" . (int)$data["id_task" ] . "'" );
    }

    public function deleteTask( $id_task )
    {
        $this->db->query( "DELETE FROM task
                           WHERE id_task = '" . (int)$id_task . "'" );
    }
}
