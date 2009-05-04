<?php
/* SVN FILE: $Id: routes.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
  Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
  Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
  Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
  Router::connect('/calendar/:year/:month', 
          array(  'controller' => 'calendar', 
                  'action' => 'index',
                  'year' => date("Y"),
                  'month' => date("n")), 
          array(  'year'=>'[0-9]+', 
                  'month'=>'[0-9]+')
              );
  Router::connect('/calendar/table/:type/:year/:month/', 
              array(  'controller' => 'calendar', 'action' => 'table'), 
              array(  'year' => '[0-9]+', 'month' => '[0-9]+'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
?>