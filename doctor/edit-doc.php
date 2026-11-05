<?php
// 1. Ensure NO spaces or lines exist before the <?php tag above.

// Import database
include("../connection.php");

if($_POST){
    $name=$_POST['name'];
    $oldemail=$_POST["oldemail"];
    $nic=$_POST['nic'];
    $spec=$_POST['spec'];
    $email=$_POST['email'];
    $tele=$_POST['Tele'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $id=$_POST['id00'];
    
    if ($password==$cpassword){
        $error='3';
        $result= $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");
        
        if($result->num_rows==1){
            $id2=$result->fetch_assoc()["docid"];
        }else{
            $id2=$id;
        }
        
        // REMOVED: echo $id2."jdfjdfdh"; <--- This was breaking your header
        
        if($id2!=$id){
            $error='1';
        }else{
            $sql1="update doctor set docemail='$email',docname='$name',docpassword='$password',docnic='$nic',doctel='$tele',specialties=$spec where docid=$id ;";
            $database->query($sql1);

            $sql2="update webuser set email='$email' where email='$oldemail' ;";
            $database->query($sql2);

            // REMOVED: echo $sql1; <--- This was breaking your header
            $error= '4';
        }
        
    }else{
        $error='2';
    }
}else{
    $error='3';
}

// Now this will work because there is ZERO output before this line
header("location: settings.php?action=edit&error=".$error."&id=".$id);
exit(); 

// 2. DO NOT put ?> at the end. 
// 3. DO NOT put </body> or </html> here.
