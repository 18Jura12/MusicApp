<?php

if( !isset( $_SESSION ) ) session_start();

require_once __DIR__ . '/app/database/db.class.php';

if( !isset( $_GET['rt'] ) && !isset( $_SESSION['korisnik'] ) ) { //nije nitko ulogiran

    $controller = 'users';
    $action = 'login';

} else if( isset( $_POST['username'] ) && $_POST['username'] != '' ) { //šalju se podaci za logiranje
    $controller = 'users';
    $action = 'verifyLogin';
} else if( isset( $_POST['buttonCreate'] ) ) {  // registracija
    $controller = 'users';
    $action = 'verifyRegister';
}
else if( !isset( $_GET['rt'] ) ) {
    $controller = 'channels';
    $action = 'index';
}

else
{
    $parts = explode( '/', $_GET['rt'] );

    if( isset( $parts[0] ) && preg_match( '/^[A-Za-z0-9]+$/', $parts[0] ) )
        $controller = $parts[0];
    else 
        $controller = 'channels';

    if( isset( $parts[1] ) && preg_match( '/^[A-Za-z0-9]+$/', $parts[1] ) )
        $action = $parts[1];
    else 
        $action = 'index';
}

$controllerName = $controller . 'Controller';

if( !file_exists( __DIR__ . '/controller/' . $controllerName . '.php' ) )
    error_404();

require_once __DIR__ . '/controller/' . $controllerName . '.php';

if( !class_exists( $controllerName ) )
    error_404();

$con = new $controllerName();

if( !method_exists( $con, $action ) )
    error_404();

$con->$action();

exit(0);


// ------------------------------------
function error_404()
{
    require_once __DIR__ . '/controller/_404Controller.php';
    $con = new _404Controller();
    $con->index();
    exit(0);
}

function debug() {
    echo '<pre>$_POST = ';
    print_r( $_POST);

    echo '<pre>$_GET = ';
    print_r( $_GET);

    echo '<br>$_SESSION = ';
    print_r( $_SESSION);
    echo '</pre>';
}

?>