<?php
namespace MyApp\Controllers;
use Phalcon\Mvc\View;
use MyApp\Model\L3;

class RootController extends ControllerBase
{
    public function indexAction() {
    	$this->view -> setLayout('admin');
    }
    public function addAction() {
    	$this->view -> setLayout('admin');
    	$this -> view -> l3 = L3::find();


    }

    public function saveAction() {
    	if($this->request->isPost()){
    		$content = $this -> request -> getPost('content');
    		$l3 = new L3();
            $l3 -> content = $this -> request -> getPost('content');
            if ($l3->save()) {
            	echo json_encode(array('success' => 1));	
            } else {
            	echo json_encode(array('success' => 0));	
            }
			exit;

    	}
    }
    public function imageAction() {
    if(!empty($_FILES)){
        
        $targetDir = "hinh-anh/";
        $fileName = $_FILES['file']['name'];
        $targetFile = $targetDir.$fileName;
        if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFile)){
            //insert file information into db table
            //$conn->query("INSERT INTO files (file_name, uploaded) VALUES('".$fileName."','".date("Y-m-d H:i:s")."')");
            echo json_encode(array('success' => 1));

        }
        
    }
    }
}

