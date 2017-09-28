  <?php 
 include("framework/core/Views.php");
 include("framework/core/Model.php");
  use Views;
  class BaseController
    {
        protected $data;
        protected $view;
        private $model;

        protected function loadView(string $view) {
            $this->view = new Views();
            $this->view->render($view);
        }
        protected function loadModel(string $model) {
            $this->model = new Model();
            return $this->model->loadModel($model);
          
        }
    }