<?php

ob_start();
require __DIR__.'/../../../../../../../vendor/autoload.php';
$app = require __DIR__.'/../../../../../../../bootstrap/app.php';
$request = Illuminate\Http\Request::capture();
$request->setMethod('GET');
$app->make('Illuminate\Contracts\Http\Kernel')->handle($request);
$isAuthorized = Auth::check();

if($isAuthorized){
    if(session_id() == '') {
        session_start();
    }
    $_SESSION['KCFINDER'] = array();
    $_SESSION['KCFINDER']['disabled'] = false;

}else{
    if(isset($_SESSION['KCFINDER'])){
        unset($_SESSION['KCFINDER']);
    }
}
ob_end_clean();