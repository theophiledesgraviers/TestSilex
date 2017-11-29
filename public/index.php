<?php

require_once '../vendor/autoload.php';

/*
 * L'objet application represente le site. C'est l'objet principal de Silex par lequel
 * nous passerons pratiquement tout le temps pour deployer de nouvelles fonctionnalités.
 */



$app = new\Silex\Application();//Un appel a ce fichier et au construct a l'interieur.
    
require_once '../config/db.php';

/*
 * La methode get de l'objet Application permet de dire a Silex d'executer un code specifique si
 * une iru est atteinte par la methode http GET. Ce code est inclus dans une fonction 
 * ou n'importe quel autre callable
 */

$app->get('/home', function(\Silex\Application $app){//on declare une nouvelle route...
    
    return $app['twig']->render('home.html.twig');
})->bind('home');

//on crée une deuxieme route associée a l'uri /listusers
$app->get('/listusers', function(\Silex\Application $app){
   /*
    * Je recupere une liste d'utilisateurs grace à mon modele UserDAO
    */ 
   $users = $app['user.dao']->findMany();
   /*
    * Ma liste d'utilisateurs est transmise a mon template au moyen d'un tableau associatif
    */
    return $app['twig']->render('listusers.html.twig',[
        'users' => $users
     ]); 
})->bind('listusers');


$app->get('/profil/{id}', function($id, \Silex\Application $app){
    $user = $app['users.dao']->find($id);
    
    return $app['twig']->render('profile.html.twig',[
        'user' => $user
]);
})->bind('profile');
    
/*
 * La classe Application implemente une interface special propre a PHP, 
 * appelée ARRaAccess. Cette interface permet d'utiliser notre objet comme si 
 * il s'agissait d'un tableau. L'objet conserve malgre tout ses caracteristiques 
 * d'objet (methodes, champ...)
 * 
 */

/*
 * On passe par une fonction au lieu de d'instancier directement notre objet afin 
 * de n'instancier notre service qu'une seule fois et seulement si necessaire
 * Cette syntaxe permet d'economiser de la memoire.
 */
    
$app['user.dao'] = function($app){//Silex permet d'injecter directement la variable dans sa propre fonction.
    return new DAO\UserDAO($app['pdo']);
    
};

$app['pdo'] = function(){
    $options = $app['pdo.options'];
    return new \PDO("{$options['sgbdr']}://host={$options['host']};dbname={$options['dbname']};charset={$options['charset']}", 
    $options['username'], 
    $options['password'], 
            array(
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ));
};

/*
 * Les services peuvent etre enregistrés via des Service Providers qui sont des classes
 * dont l'unique but est de declarer des services.  
 */

$app->register(new Silex\Provider\TwigServiceProvider(), array(
   'twig.path' => __DIR__.'/../src/Views', 
    'twig.options' =>array(
        'debug' => true
        )
));

//Pour lancer l'application il ne faut pas oublier d'appeler la methode  run de app
$app->run();