  <?php 
 include("framework/core/Views.php");
 include("framework/core/Model.php");

  class BaseController
    {
        protected $data;
        protected $view;
        private $model;

        protected function loadView(string $view) {
            $this->view = new Views();
            $this->view->render($view);
        }
        protected function loadModel(string $modelName) {
            $pahtFile="application/models/".$modelName.".php";
        if(file_exists($pahtFile)){
            include($pahtFile);
            return  new $modelName;     
        }else{
             die('Cannot create new "'.$modelName.'" class - includes not found or class unavailable.');
        }
        }
    }