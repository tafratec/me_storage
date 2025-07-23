<?php

require_once 'Tf_mask.php';

$msk = new Tf_mask();
$num2 = array();
$num2 = $_POST['num1'];

//$num =$_POST['num1'];
/*
for ($x = 0; $x <= 8; $x++)
{
    $num[x]=    
}
*/
$passed = $msk->pass($num2);

if($passed)
{

	switch ($_POST['calling_method']) 
	{    
		case 'store_dent_file':
			echo uploadDentFile();
			break;
		case 'store_file':
			echo uploadFile();
			break;
		case 'rf_file':
			echo uploadRfFile();
			break;			
		case 'flup_file':
			echo uploadFollowupFile();
			break;			
		case 'file_remove':
			echo deleteFile();
			break;
		case 'file_remove2':
			echo deleteFile2();
			break;				
		case 'bring_file':
            return downloadFile();
            break; 	
	}	
}
else
{
    die;
}

function uploadDentFile()
{

$status = 0; $msg = "";

$path1 = $_POST['path'];
$user_id = $_POST['user_id'];
$sub_folder = $_POST['subFolder'];
$owner_name = $_POST['owner'];


if(isset($_FILES['file']['name'])){
    // file name
    $filename = $_FILES['file']['name'];
    $location1 = 'tf_dentists/'.$user_id; //'tf_workorder/'.$woid;

    
    //Create Path
    if (!is_dir($location1))
    {
        mkdir($location1, 0755, true);  
    }
    
    $location1 = $location1.'/'.$sub_folder;
    
    if (!is_dir($location1))
    {
        mkdir($location1, 0755, true);  
    }
    
    //$location1 = $location1.'/'.$owner_name;
    
    if (!is_dir($location1))
    {
        mkdir($location1, 0755, true);  
    }
    
    $location = $location1.'/'.$filename; 
    
   
    // file extension
    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);

    // Valid extensions
    //("jpg", "jpeg", "png","svg","tif","tiff","stl","mp4","pdf"
    //$valid_ext = array("pdf","jpg","png","jpeg","svg","tif","tiff","stl","mp4","txt","m3d","ply");
    $valid_ext = array("jpg","png","jpeg","svg","tif","tiff");

   
    
    if(in_array($file_extension,$valid_ext)){
        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
             $status = 1;
             $msg = "Upload successfully";
        } 
    }else{
        $status = 0;
        $msg = "Invalid file extension";
    }
}

$response = array(
    'status' => $status,
    'msg' => $msg,
    'num1' => $_POST['num1']
);
echo json_encode($response);
die;

}

function uploadFile()
{

$status = 0; $msg = "";

$path1 = $_POST['path'];
$wo_id = $_POST['woid'];
$phase_ID = $_POST['phaseId'];
$owner_name = $_POST['owner'];


if(isset($_FILES['file']['name'])){
    // file name
    $filename = $_FILES['file']['name'];
    $location1 = 'tf_workorder/'.$wo_id; //'tf_workorder/'.$woid;

    
    //Create Path
    if (!is_dir($location1))
    {
        mkdir($location1, 0755, true);  
    }
    
    $location1 = $location1.'/'.$phase_ID;
    
    if (!is_dir($location1))
    {
        mkdir($location1, 0755, true);  
    }
    
    $location1 = $location1.'/'.$owner_name;
    
    if (!is_dir($location1))
    {
        mkdir($location1, 0755, true);  
    }
    
    $location = $location1.'/'.$filename; 
    
   
    // file extension
    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);

    // Valid extensions
    //("jpg", "jpeg", "png","svg","tif","tiff","stl","mp4","pdf"
    $valid_ext = array("pdf","jpg","png","jpeg","svg","tif","tiff","stl","mp4","txt","m3d","ply");

   
    
    if(in_array($file_extension,$valid_ext)){
        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
             $status = 1;
             $msg = "Upload successfully";
        } 
    }else{
        $status = 0;
        $msg = "Invalid file extension";
    }
}

$response = array(
    'status' => $status,
    'msg' => $msg,
    'num1' => $_POST['num1']
);
echo json_encode($response);
die;

}

function deleteFile()
{
	$status = 0; $msg = "";
	$path1 = $_POST['path'];
	$filename = $_POST['file'];
	$path1 = ltrim($path1,"/");
	
	$filename = $path1.$filename;
	if(file_exists($filename))
    {
        $status  = unlink($filename) ? $msg='The file '.$filename.' has been deleted' : $msg='Error deleting '.$filename;
        
    }
    else
    {
        $msg = 'The file '.$filename.' doesnot exist';
    }

	
	$status = 1;
	$response = array(
    'status' =>$status,
    'msg' => $filename,//$msg,
    'num1' => $_POST['num1']
    );
	echo json_encode($response);
    die;
	
}

function downloadFile()
{
    $status = 0; $msg = "";
	$path1 = $_POST['path'];
	$filename = $_POST['file'];
	$path1 = ltrim($path1,"/");
	$file = $path1.$filename;
	
	if (file_exists($file)) 
	{
        
        header('Content-Description: File Transfer');
        header('Content-Type: image/jpg');
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        
        
        $crossFile = readfile($file);
        
        //return 1;
        return $crossFile;
    }
	
	
	

    $response = array(
    'status' =>$status,
    'msg' => $filename,//$msg,
    'num1' => $_POST['num1']
    );
	die;
}

function deleteFile2()
{
	$status = 0; $msg = "Just Started";
	$path1 = $_POST['path'];
	$filename = $_POST['file'];

	//$path1 = ltrim($path1,"/");
	
	//$filename = substr($path1,strpos($path1,'/'));
	//$filename=ltrim($path1,"https://tf.mylinealigner.com/");
	//$filename=$path1;
	if(file_exists($filename))
    {
        //$status  = unlink($filename) ? $msg='The file '.$filename.' has been deleted' : $msg='Error deleting '.$filename;
        //$msg = 'Before Delete';
        $status=unlink($filename);
    }

	//$status = 1;
    //$msg=$filename;
	$response = array(
    'status' =>$status,
    'msg' => $msg,
    'num1' => $_POST['num1']
    );

	echo json_encode($response);
    die;
}

function uploadRfFile()
{
    //writeLog("Just Entered the function uploadRfFile!");
	$status = 0; $msg = "";

	$path1 = $_POST['path'];
	$wo_id = $_POST['woid'];
	$phase_ID = $_POST['phaseId'];
	$owner_name = $_POST['owner'];
	
    //writeLog("Path1=".$path1);
    //writeLog("Workorder=".$wo_id);
    //writeLog("Phaseid=".$phase_ID);
    //writeLog("Owner=".$owner_name);	


	if(isset($_FILES['file']['name']))
	{
		// file name
		$filename = $_FILES['file']['name'];
		$location1 = 'tf_refinment/'.$wo_id;
		//writeLog("first location1=".$location1);

		
		//Create Path
		if (!is_dir($location1))
		{
			mkdir($location1, 0755, true);  
		}
		
		$location1 = $location1.'/'.$phase_ID;
		
		if (!is_dir($location1))
		{
			mkdir($location1, 0755, true);  
		}
		
		$location1 = $location1.'/'.$owner_name;
		
		if (!is_dir($location1))
		{
			mkdir($location1, 0755, true);  
		}
		
		$location = $location1.'/'.$filename; 
		
		//writeLog("Location=".$location);
	   
		// file extension
		$file_extension = pathinfo($location, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension);

		// Valid extensions
		//("jpg", "jpeg", "png","svg","tif","tiff","stl","mp4","pdf"
		$valid_ext = array("pdf","jpg","png","jpeg","svg","tif","tiff","stl","mp4","txt","m3d","ply");

	   
		
		if(in_array($file_extension,$valid_ext)){
			// Upload file
			if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
				 $status = 1;
				 $msg = "Upload successfully";
			} 
		}else{
			$status = 0;
			$msg = "Invalid file extension";
		}
	}


	$response = array(
		'status' => $status,
		'msg' => $msg,
		'num1' => $_POST['num1']
	);
	echo json_encode($response);
	die;

}

function uploadFollowupFile()
{
    //writeLog("Just Entered the function uploadRfFile!");
	$status = 0; $msg = "";

	$path1 = $_POST['path'];
	$wo_id = $_POST['woid'];
	$phase_ID = $_POST['phaseId'];
	$owner_name = $_POST['owner'];
	
    //writeLog("Path1=".$path1);
    //writeLog("Workorder=".$wo_id);
    //writeLog("Phaseid=".$phase_ID);
    //writeLog("Owner=".$owner_name);	


	if(isset($_FILES['file']['name']))
	{
		// file name
		$filename = $_FILES['file']['name'];
		$location1 = 'tf_followup/'.$wo_id;
		//writeLog("first location1=".$location1);

		
		//Create Path
		if (!is_dir($location1))
		{
			mkdir($location1, 0755, true);  
		}
		
		$location1 = $location1.'/'.$phase_ID;
		
		if (!is_dir($location1))
		{
			mkdir($location1, 0755, true);  
		}
		
		$location1 = $location1.'/'.$owner_name;
		
		if (!is_dir($location1))
		{
			mkdir($location1, 0755, true);  
		}
		
		$location = $location1.'/'.$filename; 
		
		//writeLog("Location=".$location);
	   
		// file extension
		$file_extension = pathinfo($location, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension);

		// Valid extensions
		//("jpg", "jpeg", "png","svg","tif","tiff","stl","mp4","pdf"
		$valid_ext = array("pdf","jpg","png","jpeg","svg","tif","tiff","stl","mp4","txt","m3d","ply");

	   
		
		if(in_array($file_extension,$valid_ext)){
			// Upload file
			if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
				 $status = 1;
				 $msg = "Upload successfully";
			} 
		}else{
			$status = 0;
			$msg = "Invalid file extension";
		}
	}


	$response = array(
		'status' => $status,
		'msg' => $msg,
		'num1' => $_POST['num1']
	);
	echo json_encode($response);
	die;

}

function writeLog($message)
{
	//$msg=date("Y-m-d H:i:s").",".$label.",".$message;
	$msg=date("Y-m-d H:i:s")." ** ".$message."\n";
	error_log($msg, 3, LOG);	
}
