
<!DOCTYPE html>
	<!-- Shweta Deshpande-->
<html>
<head>
<title>COEN 276 Quiz</title>
<meta charset='utf-8'>
<link rel='stylesheet' href='../css/style.css'/>

</head>

<body>
<img src="../img/quizImg.jpg" class="imgquiz">

<?php
//getting category id from index page
if(isset($_GET['category_id'])){

$conn = mysqli_connect('localhost', 'root' ,'',"quizDB");
if($conn->connect_error){
	die("Connection failed!" .$conn->connect_error);
}
else{
	//depending on category id query the database to fectch the random 5 questions
   $category_id = $_GET['category_id'];
   $sql = "select * from questions where category_id=$category_id ORDER BY RAND() LIMIT 5";
   $response = $conn->query($sql);
	 ?>

<div id="QuestionWrap">
<form method='post' id='quiz_form'>

<?php $i=1;  while($result=$response->fetch_assoc()){
if($i==1){?>
	<div id="question" class="show">
<?php
}
else {?>

	<div id="question" class="hide">
<?php
}

?>
<h2 id="question_<?php echo $i?>"><?php echo $i."."." ".$result['question_name'];?></h2>
<?php
//Display question depending on the question type
//Display multiple choice question
if($result['question_type']=="Multiple-choice")
{

?>
			<div class='align'>
			<input type="radio" value="1" id='radio1_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>' >
			<label id='ans1_<?php echo $result['id'];?>'><?php echo $result['answer1'];?></label>
			<br/>
			<input type="radio" value="2" id='radio2_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>' >
			<label id='ans2_<?php echo $result['id'];?>'><?php echo $result['answer2'];?></label>
			<br/>
			<input type="radio" value="3" id='radio3_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>' >
			<label id='ans3_<?php echo $result['id'];?>'><?php echo $result['answer3'];?></label>
			<br/>
			<input type="radio" value="4" id='radio4_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'>
			<label id='ans4_<?php echo $result['id'];?>'><?php echo $result['answer4'];?></label>
			<input type="radio" checked='checked' value="5" style='display:none' id='radio4_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'>
			<input type="radio" checked='checked' value="<?=$category_id?>" style='display:none' id='category' name='category'>
			</div>
<?php
}
//Display question in which input from user will be enetered in textbox
else {
?>
	<div class='align'>
	<br>
	<input type="text" name='<?php echo $result['id'];?>' value="" class="txtinput" >
</div>
<?php
}
?>
<br/>
<br/>
<!--Next question will display after clicking this button-->
<input type="button" id='next<?php echo  $i?>' value='Click Next!!' name='question' class='nextq' />
</div>

<?php $i=$i+1; }}}?>


</form>
<br>
<br>
<!--Display timer-->
<div id="timer">
<label id="countdown" class="timerdemo">00:00</label>
<br>
<button id="pause" class="pauseq">Pause</button>
<button id="resume" class="continueq">Continue</button>
<button id="reset" hidden="hidden">Reset</button>
<button id="stop" class="stopq">Stop</button>
</div>
</div>
</div>
<!--Display result when quiz is over-->
<div id='result'>
<br/>
</div>

<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/stopwatch.js"></script>
<script src="../js/quiz.js"></script>
</body>
</html>
