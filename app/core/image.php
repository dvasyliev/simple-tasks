<?php

class Image
{
    private $type;
    private $width;
    private $height;
    private $image;

    public function __construct( $args )
    {
        $types = array( "image/jpeg", "image/png", "image/gif" );

        if( in_array( $args[ "type" ], $types ) ):
            $image_size = getimagesize( $args[ "tmp_name" ] );
            $this->type = $args[ "type" ];
            $this->width = $image_size[ 0 ];
            $this->height = $image_size[ 1 ];

            $this->save( $args[ "tmp_name" ], $args[ "name" ] );
        else:
            trigger_error( 'Error: Undefined file type of image ' . $args[ "name" ] . '!' );
        endif;

    }

    private function save( $path, $name )
    {
        try {
            $final_path = DIR_IMAGE . "/" . $name;
            $this->image = move_uploaded_file( $path, $final_path ) ? DIR_IMAGE_NAME . "/" . $name : false;
        } catch ( Exception $exception ) {
            throw new Exception( 'Error: Could not to save uploaded image ' . $name . ' into image folder!' );
            exit();
        }
    }

    public function crop( $width, $height )
    {
        if( $width < 0 && $height < 0 ):
            return $this->image;
        endif;

        $image_type = explode( "/", $this->type )[ 1 ];
        $image_create_func = "imagecreatefrom" . $image_type;
        $image_descriptor = $image_create_func( DIR_ROOT . "/" . $this->image );

        $cropped = array(
            "width" => 0,
            "height" => 0,
            "x" => 0,
            "y" => 0,
        );

        if( $width / $height > $this->width / $this->height ):
            $cropped[ "width" ] = floor( $this->width );
            $cropped[ "height" ] = floor( $this->width * $height / $width );
            $cropped[ "y" ] = floor( ( $this->height - $cropped[ "height" ] ) / 2 );
        else:
            $cropped[ "width" ] = floor( $this->height * $width / $height );
            $cropped[ "height" ] = floor( $this->height );
            $cropped[ "x" ] = floor( ( $this->width - $cropped[ "width" ] ) / 2 );
        endif;

        $final_image_descriptor = imagecreatetruecolor( $width, $height );
        imagecopyresampled(
            $final_image_descriptor, $image_descriptor, 0, 0,
            $cropped[ "x" ], $cropped[ "y" ],
            $width, $height, $cropped[ "width" ], $cropped[ "height" ]
        );

        $image_function = "image" . $image_type;
        $image_name = str_replace( "." . $image_type, "", $this->image );
        $final_image_path = $image_name . "_" . $width . "x" . $height . "." . $image_type;

        try {
            $image_function( $final_image_descriptor, $final_image_path );
        } catch ( Exception $exception ) {
            throw new Exception( 'Error: Could not to crop image ' . $this->image . '!' );
            exit();
        }

        return $final_image_path;
    }

    public function getImage( $width = false, $height = false )
    {
        return $width && $height ? $this->crop( $width, $height ) : $this->image;
    }
}