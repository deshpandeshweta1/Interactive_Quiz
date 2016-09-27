<!DOCTYPE html>
<html>
<head>
<title>COEN 276 Quiz</title>
<meta charset='utf-8'>
<link rel='stylesheet' href='../css/index.css'/>
<script src="../js/jquery-1.9.1.min.js"></script>
<script> function myFunction()
{
var category = document.getElementById("lblCatid").value;
window.location = 'quiz.php?category_id='+category;
}
</script>
</head>
<body>

  <img src="../img/quizImg.jpg" class="imgquiz">
  <!--Code to open file and check the saved date in file is same as todays date then do not choose random category and follow the same category as written in file-->
  	<?php
  	date_default_timezone_set('America/Los_Angeles');
  	$myfile = fopen("../txt/todaysCategory.txt", "r") or die("Unable to open file!");
  	$fileData = fread($myfile,filesize("../txt/todaysCategory.txt"));
  	fclose($myfile);
  	list($date,$category_id,$category_name) = explode(",",$fileData);
  	$todaysDate= date('m/d/Y');
  ?>
  <!-- Todays date is same as file date then do nothing and use the file category -->
  	<?php
  	if($todaysDate==$date)
  	{
  		?>
  		<!--Todays date is same as file date then do nothing and use the file category -->
  			<?php
  	}
  	else
  	{
  		?>
  		<!--generate random category and update that in file -->
  			<?php
  		$conn = mysqli_connect('localhost', 'root' ,'',"quizDB");
  		if($conn->connect_error){
  			die("Connection failed!" .$conn->connect_error);
  		}
  		else{

  		   $sql = "select * from categories ORDER BY RAND() LIMIT 1";
  		   $response = $conn->query($sql);
  		   $result=$response->fetch_assoc();
  		   $category_id = $result['id'];
  		   $category_name = $result['category_name'];

  			$myfile = fopen("../txt/todaysCategory.txt", "w") or die("Unable to open file!");
  			$line= $todaysDate.",".$category_id.",".$category_name;
  			fwrite($myfile, $line);
  			fclose($myfile);
  		}
  	}
  ?>
<!--display todays category based on file so that its same throughout that day or show random generated if date is changed.-->
<div class="startPage">
<input id="lblCatid" type="hidden" value="<?=$category_id?>"/>
<label id='lblToday'>Today's Category is: </label>
<label id='lblCategory'><?= $category_name ?></label>
<!--Start the quiz by clicking the button-->
<button class="startq" onclick="myFunction()">Start Quiz!!</button>

</br>
</br>
<label class="lblnote">Note: The quiz contains 5 question and you will have 20 sec to answer.</label>
</div>

</body>
</html>
