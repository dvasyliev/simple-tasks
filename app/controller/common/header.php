<?php

class ControllerCommonHeader extends Controller
{
    public function index()
    {
        $data = array();

        $self = $this;
        $loader = new Loader( $self->registry );

        return $loader->view( 'common/header', $data );
    }
}