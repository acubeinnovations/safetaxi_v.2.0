<?php 

if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class Mysession
{
    public function __construct()
    {
        ob_start();
        session_start();
		ob_end_clean();
    }

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function regenerateId( $delOld = false )
    {
        session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }
	public function destroy()
    {
       session_destroy();
    }
}
