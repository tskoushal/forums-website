<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    #ques {
        min-height: "433px";
    }
    </style>
    <title>Welcome to iDiscuss </title>
</head>

<body>
    <?php include 'part/header.php';?>
    <?php include 'part/dbconnect.php';?>

    <?php 
      $idi = $_GET['ide'];
      $sql = "SELECT * FROM `idiscuss` WHERE id = $idi";
      $result = mysqli_query($conn,$sql);
      while($row = mysqli_fetch_assoc($result)){
          $fname = $row['name'];
          $fdesc = $row['description'];
        }
      ?>
    <?php 
        $showAlert= false;       
       $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];

            $th_title = str_replace("<", "&lt;", "'$th_title'");
            $th_title = str_replace(">", "&gt;", "'$th_title'");

            $th_desc  = str_replace("<", "&lt;", "'$th_desc'");
            $th_desc  = str_replace(">", "&gt;", "'$th_desc'");

            $sno = $_POST['sno'];
            $sql ="INSERT INTO `thread` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `datetime`) 
            VALUES ('$th_title', '$th_desc', '$idi', '$sno', current_timestamp())";
               $result = mysqli_query($conn,$sql);
            $showAlert= true;
               if($showAlert){
                   echo'
                   <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>Successfully Submitted !</strong> Your thread has been submitted. 
                     <button type="button" class="btn-close dark"  data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
               }   

        };
      
      ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h3 class="display-4">Welcome to <?php echo $fname;?></h3>
            <p class="lead"><?php echo $fdesc;?></p>
            <hr class="my-4">
            <!-- <p>This is contain python language.</p> -->
            <p class="lead">
               <p>No Spam / Advertising / Self-promote in the forums. Do not post copyright-infringing material.links or images.
                                    Do not cross post questions.Do not PM users asking for help. ...</p>
            </p>
        </div>
        <br>
        <hr>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container " >
            <H3>Start Discussion</H3>
            <form action='.$_SERVER['REQUEST_URI'].' method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Problem</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                placeholder="Text..">
            <small id="emailHelp" class="form-text text-muted">Ask in short if it possible..</small>
        </div>
        <input type="hidden" name="sno"  value="'.$_SESSION["sno"].'">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Ellaborate a concern</label>
            <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="Text.."></textarea>
        </div>
        <button type="submit" class="btn btn-success my-2">Submit</button>
        </form>
    </div>
    <br>
    <hr>';
    }
    
    else{
      echo'<div class="container">
            <p class="lead">You are not logged in. Please login</p>
        </div>';
    }

    ?>

    <div class="container" id="ques">
        <h1>Browse Question</h1>
    </div>
    <?php 
                $idi = $_GET['ide'];
                $sql = "SELECT * FROM `thread` WHERE thread_cat_id=$idi";
                $result = mysqli_query($conn,$sql);
                $noResult = true ;
                while($row = mysqli_fetch_assoc($result)){
                    $noResult = false ;
                    $tid = $row['thread_id'];
                    $title = $row['thread_title'];
                    $tdesc = $row['thread_desc'];
                    $thread_time = $row['datetime'];
                    $thread_user_id = $row['thread_user_id'];
                    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                    $result2 = mysqli_query($conn,$sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                  
         echo '<div class="media mp-6">
                    <img class="mr-3" width="50px" src="/forums/img/user.jpg" alt="Generic placeholder image">
                <div class="media-body mb-3">
                <p class="fw-bold">'. $row2['user_email'] .'  at '. $thread_time .'</p>
                <h5 class="mt-0"> <a href="threadque.php?threadid='. $tid .'"class="link-dark  text-decoration-none"> ' . $title . ' </a> </h5>
                         ' . $tdesc . ' 
                         <hr>  
                </div>
            </div>';
                }
                // echo var_dump($noResult);
                if($noResult){
                    echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                      <h1 class="display-4">Ask Question</h1>
                      <p class="lead"><b>Be a first person to ask question</b></p>
                    </div>
                  </div>';
                }
            ?>
            </div>
    <?php include 'part/footer.php'; ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>


</html>