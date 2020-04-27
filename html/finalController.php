<?php
require 'finalModel.php';
require 'finalView.php';


class finalController {
    private $model;
    private $view;
    private $nav = 'login';
    private $action = '';

    public function __construct() {
        $this->model = new finalModel();
        $this->view = new finalView();
        if(isset($_GET['nav'])) {
            $this->nav = $_GET['nav'];
        }
        if(isset($_POST['action'])) {
            $this->action = $_POST['action'];
        }
    }
    
    public function __destruct() {
        $this->model = null;
        $this->view = null;
    }
    
    public function run() {
        switch($this->action) {
            case 'login':
                $this->handleLogin();
                break;
            case 'submitList':
                $this->model->submitList();
                $this->nav = 'home';
                break;
            case 'search':
                $this->nav = 'search';
                break;
            default:
                break;
        }
        $data = $this->model->preparePageContent($this->nav);
        if($this->action === 'search') $this->nav = 'home';
        print $this->view->getHtml($this->nav, $data);
        
    }
    
    private function handleLogin() {
        $this->model->processLogin();
        if($_SESSION['logStatus'] === 'true') {
            header('Location: http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com?nav=home');
        }
        else {
            header('Location: http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com?nav=login'); 
        }
    }
    
}
?>