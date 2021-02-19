<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->withFacades();
//use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Capsule\Manager as DB;

//$sqlite = DB::connection('sqlite');
//
//$Capsule = new Capsule;
//$Capsule->addConnection($app->config->get('database'));
//$Capsule->setAsGlobal();  //this is important
//$Capsule->bootEloquent();

/*
esse framework armazena as migracoes numa tabela de nome migrations
vamos criar o esquema dessa tabela
conforme configuracao em config/database
*/

//migrations

?>