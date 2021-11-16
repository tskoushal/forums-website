<?php
 $showError="false";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // include '_handlesignup.php';
    include 'dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupCPassword'];

    $existsql ="SELECT * FROM `users` where user_email = '$user_email'";
    $result = mysqli_query($conn,$existsql);
    $num_rows = mysqli_num_rows($result);
 
    if($num_rows>0){
       echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
       <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
       <div>
        Email already exists.
       </div>
     </div>'; 
    }
    else{
        if($pass==$cpass){
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql ="INSERT INTO `users` (`user_email`, `user_pass`, `timestrap`)VALUES ('$user_email', '$hash', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            // echo $result;
            if($result){
                $showAlert = true;  
         
             //   header("Location: /forums/index.php");
               // header('Location: /forums/index.php?signupsuccess=true');
             echo 'signup Successfully';
            } 
        }
        else{
            $showError = "Password do not match";
        }
    }
    // header("Location: /forums/index.php?signupsuccess=false&error=$showError"); 
  //     header("Location: /forums/index.php?signupsuccess=false&error=$showError");

}

?>