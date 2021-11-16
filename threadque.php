<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Welcome to iDiscuss </title>
</head>

<body>
    <?php include 'part/header.php';?>
    <?php include 'part/dbconnect.php';?>

    <?php 
      $idi = $_GET['threadid'];
      $sql = "SELECT * FROM `thread` WHERE thread_id = $idi ";

      $result = mysqli_query($conn,$sql);
      while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
       }
    ?>

    <?php 
        $showAlert= false;       
       $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
       $comment = $_POST['comment'];

       $comment = str_replace("<", "&lt;", "'$comment");
       $comment = str_replace(">", "&gt;", "'$comment");
       
       $sno = $_POST['sno'];
            $sql ="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`)
                   VALUES ('$comment', '$idi','$sno', current_timestamp())";
               $result = mysqli_query($conn,$sql);
            $showAlert= true;
               if($showAlert){
                   echo'
                   <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>Successfully </strong> Your comment has been added.
                     <button type="button" class="btn-close dark"  data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
               }   
        };    
      ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h3 class="display-4"> <?php echo $title;?> </h3>
            <p class="lead">
                <?php echo $desc;?>
            </p>
            <hr class="my-4">
            <!-- <p>This is contain python language.</p> -->
            <p class="lead">
            No Spam / Advertising / Self-promote in the forums . Do not post copyright-infringing material .  Do not post “offensive” posts, links or images. ...
            Do not cross post questions. </p>
            <p>Posted by : <b> <?php echo $posted_by ?> </b> </p>
        </div>
        <br>
        <hr>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo '<div class="container " id="ques">
            <H4>Post your comment</H4>
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Text.."></textarea>
            <input type="hidden" name="sno"  value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success my-2">Post comment</button>    
        </form>';
    }
    else{
      echo'  <div class="container"> 
                     <h1>Post Comment</h1>
                    <p class="lead">You are not logged in. Please login for post comments</p>
             </div>';
    }
    ?>

        <div class="container my-4">
            <H3>Discussions</H3>
        </div>
        <?php  
                 $idi = $_GET['threadid'];
                    $sql = "SELECT * FROM `comments` WHERE thread_id=$idi";
                    $result = mysqli_query($conn,$sql);
                    $noResult = true ;
                    while($row = mysqli_fetch_assoc($result)){
                        $noResult = false ;
                        $tid = $row['comment_id'];
                        $content = $row['comment_content'];
                        $comment_time = $row['comment_time'];
                        $thread_user_id = $row['comment_by'];
                        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                        $result2 = mysqli_query($conn,$sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        echo '<div class="media mp-6">
                        <img class="mr-3" width="50px" src="/forums/img/user.jpg" alt="Generic placeholder image">
                        <div class="media-body">
                        <p class="font-weight-bold my-1">'. $row2['user_email'] .'  at '. $comment_time .'</p>
                        ' . $content . ' <hr>
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
    </div>
    <?php include 'part/footer.php'; ?>

    <!-- <?php 
              //  $idi = $_GET['ide'];
              //  $sql = "SELECT * FROM `thread` WHERE thread_cat_id=$idi";
               // $result = mysqli_query($conn,$sql);
              //  while($row = mysqli_fetch_assoc($result)){
                       // $tid = $row['thread_id'];
                       // $title = $row['thread_title'];
                       // $tdesc = $row['thread_desc'];
           // echo '<div class="media mp-6">
               // <img class="mr-3" width="50px" src="/forums/img/user.jpg" alt="Generic placeholder image">
             //   <div class="media-body">
             // <h5 class="mt-0"> <a href="threadque.php?threadid='. $tid .'"> ' . $title . ' </a> </h5>
             // ' . $tdesc . ' 
             //  </div>
             // </div>';
             //   }
             ?> -->
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