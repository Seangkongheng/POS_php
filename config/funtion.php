<?php
    session_start();


//input field validation
require 'dbcon.php';
    function validate($inputDAta){
        global $conn;

        $validateDAta=mysqli_real_escape_string($conn,$inputDAta);

        return trim( $validateDAta);
    }
// redirec from 1 page to anohter page with the message(status)

function redirect($url,$status){
    $_SESSION['status']=$status;
    header('location:'.$url);
    exit(0);
}


/// display message or starus after any proccess.


function alertMessage(){
    if(isset($_SESSION['status'])){
        echo $_SESSION['status'];
     echo '   <div class="alert alert-warning alert-dismissible fade show" role="alert">
  '.$_SESSION['status'].'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
        unset($_SESSION['stutus']);
    }
}



//insert recorde using this funtion


function insert($tableName,$data){
    global $conn;
    $table=validate($tableName);

    $columns=array_keys($data);
    $values=array_values($data);

    $finalColumn = implode(',',$columns);

    $finalvalue="'".implode("','",$values)."'";

    $query ="INSERT IN TO $table ($finalColumn) VALUES ($finalvalue)";
    $resul=mysqli_query($conn,$query);
    return $resul;


}   


//updat recorde useing this funtion

function udpate($tableName,$id,$data){
    global $conn;

    $table = validate($tableName);
    $id=validate($id);

    $updateDataString="";

    foreach($data as $column=>$value){
        $updateDataString .=$column.'='."'$value'";
    }

    $finalUpdateData=substr(trim($updateDataString),0,-1);
    $query="UPDATE $table SET $finalUpdateData WHERE id='$id'" ;
    $resul=mysqli_query($conn,$query);
    return $resul;

}
// select all data use this function

function getAll($tableName,$status=null){
    global $conn;
    $table =validate($tableName);
    $status=validate($status);


    if($status=='status'){
        $query="SELECT * FROM $table WHERE status='0'";
    }
    else{
        $query="SELECT * FROM $table";
    }
    return mysqli_query($conn,$query);

}


function getByid($tableName ,$id){
    global $conn;
    $table =validate($tableName);
    $id=validate($id);

    $query ="SELECT * from $table where id ='$id' limit 1";
    $resul= mysqli_query($conn,$query);

    if($resul){
        if(mysqli_num_rows($resul)==1){
            $row= mysqli_fetch_array($resul,MYSQLI_ASSOC);

            $rowm=mysqli_fetch_assoc($resul);
            $response =[
                'status'=>404,
                'data'=>$row,
                'message'=>'record found'
    
            ];
            return $response;
        }else
        {
            $response =[
                'status'=>404,
                'message'=>'No data found'
    
            ];
            return $response;
        }
    }
    else{
        $response =[
            'status'=>500,
            'message'=>'something weng wrong'

        ];
        return $response;
    }

}

// delete data from data base by id using this funtion
function DeleteByid($tableName ,$id){
    global $conn;
    $table =validate($tableName);
    $id=validate($id);

    $query = "DELETE FROM $table id ='$id' limit 1";
    $result=mysqli_query($conn,$query);
}
?>