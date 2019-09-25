<?php


namespace App\Http\Composers;


use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;


/**
 * summary
 */
class MasterViewComposer
{
    public function compose(View $view)
    	{
      $controller = '';
      $action = '';
      
      $action = Route::getCurrentRoute()->getAction();

      $controller_action = class_basename($action["controller"]);

      list($controller, $action) = explode("@", $controller_action);
      
    	$view->with(compact('controller', 'action'));
    	}
}