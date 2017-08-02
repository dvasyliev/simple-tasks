<?php

class Pagination
{
    private $css_class;
    private $total;
    private $page;
    private $limit;
    private $num_links;
    private $num_pages;
    private $url;
    private $text_first = '&laquo;';
    private $text_last = '&raquo;';
    private $text_prev = '<';
    private $text_next = '>';

    public function __construct( $css_class, $url = "", $total = 0, $page = 1, $limit = 5, $num_links = 5 )
    {
        $this->css_class = $css_class;
        $this->total = $total;
        $this->page = $page < 1 ? 1 : $page;
        $this->limit = $limit;
        $this->num_links = $num_links;
        $this->num_pages = ceil( $this->total / $this->limit );
        $this->url = str_replace( "%7Bpage%7D", "{page}", $url );
    }

    public function render()
    {
        if( $this->num_pages <= 1 ):
            return '';
        endif;

        $output = '<div class="' . $this->css_class . '">';
        $output .= '<ul class="pagination ' . $this->css_class . '__list ">';

        if( $this->page > 1 ):
            $output .= '<li><a href="' . str_replace( "{page}", 1, $this->url ) . '">' . $this->text_first . '</a></li>';
            $output .= '<li><a href="' . str_replace( "{page}", $this->page - 1, $this->url ) . '">' . $this->text_prev . '</a></li>';
        endif;

        if( $this->num_pages > 1 ):
            if( $this->num_pages <= $this->num_links ):
                $start = 1;
                $end = $this->num_pages;
            else:
                $start = $this->page - floor( $this->num_links / 2 );
                $end = $this->page + floor( $this->num_links / 2 );

                if( $start < 1 ):
                    $start = 1;
                    $end += abs( $start ) + 1;
                endif;

                if( $end > $this->num_pages ):
                    $start -= ( $end - $this->num_pages );
                    $end = $this->num_pages;
                endif;
            endif;

            for( $i = $start; $i <= $end; $i++ ):
                $output .= $this->page == $i
                    ? '<li class="active"><a href="#">' . $i . '<span class="sr-only">(current)</span></a></li>'
                    : '<li><a href="' . str_replace( "{page}", $i, $this->url ) . '">' . $i . '</a></li>';
            endfor;
        endif;

        if( $this->page < $this->num_pages ):
            $output .= '<li><a href="' . str_replace( "{page}", $this->page + 1, $this->url ) . '">' . $this->text_next . '</a></li>';
            $output .= '<li><a href="' . str_replace( "{page}", $this->num_pages, $this->url ) . '">' . $this->text_last . '</a></li>';
        endif;

        $output .= '</ul>';
        $output .= '</div>';

        return $output;
    }
}