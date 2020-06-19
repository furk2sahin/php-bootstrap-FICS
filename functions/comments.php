<?php 
	$get_id = $_GET['post_id'];
	$get_com = "select * from comments where post_ID='$get_id' ORDER by 1 DESC";
	$run_com = mysqli_query($con,$get_com);
	while($row=mysqli_fetch_array($run_com)){
		$com = $row['comment'];
		$com_userid = $row['user_id'];
		$com_name = $row['comment_author']; 
		$date = $row['date']; 
		echo "
		<div class='row'>
        <div class='col-md-6 col-md-offset-3'>
            <div class='panel panel-info'>
                <div class='panel-body'>
                	<div>
					<h4><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$com_userid'><strong>$com_name</a> $date </strong><i>tarihinde yorum yaptı.</i> </h4>
					<p class='text-primary' style='margin-left:5px;font-size:20px;'>$com</p>
					</div> 
                </div>
            </div>
        </div>
        </div>
		";
	}
	
?>