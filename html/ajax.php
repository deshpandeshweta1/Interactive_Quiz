<?php
//Shweta Deshpande
$right_answer=0;
$wrong_answer=0;
$category_id = $_POST["category"];
$questions = array();

parse_str(file_get_contents('php://input'),$output);
$keys = array_keys($output);
$ids="";

for($j=0,$i=0;$j<count($keys);$j++)
{
	if($keys[$j] == "category")
	{
	//	unset($keys[$j]);
	}
	else {
		$questions[$i] = $keys[$j];
		$i++;
	}
}

for($j=0;$j<count($questions);$j++)
	{
		if($j==(count($questions)-1))
		{
			$ids=$ids."$questions[$j]";
		}
		else {
			$ids=$ids."$questions[$j],";
		}

	}


//Get the question related data from database based on categoryID and QuestionID
$conn = mysqli_connect('localhost', 'root' ,'',"quizDB");
if($conn->connect_error){
	die("Connection failed!" .$conn->connect_error);
}
else{
   $sql = "select id,question_name,answer,question_type from questions where category_id=$category_id and id in ($ids) order by id";
   $response = $conn->query($sql);

   if($response->num_rows > 0){//sucess
	 $right_answer=0;
	 $wrong_answer=0;

//check whether enetered answer matches the database answer or not
	 while($result=$response->fetch_assoc()){
		 	$i=$result['id'];
        //yes then correct answer
	       if( $result['question_type']=="Multiple-choice"  && $result['answer']==$_POST["$i"]){

		       $right_answer++;
		   }
			 elseif ( $result['question_type']=="Text" && (strcasecmp($result['answer'], $_POST["$i"]) == 0) ) {
			 		$right_answer++;
			 }
			 //No then wrong answer or if not enetered anything then still its a wrong answer
			 else if($_POST["$i"]==5){
					$wrong_answer++;
		   }
		   else{
		       $wrong_answer++;
		   }
		   $i++;
	 }
   //Display the quiz score details
	 echo "<div id='answer'>";
   $total="5";
	 echo "  <span class='highlight'> Right Answer : ". $right_answer."</span><br><br>";
	 echo " <span class='highlight'> Wrong Answer : ". $wrong_answer."</span><br><br>";
	 echo " <span class='highlight'> Total Score : ". $right_answer."/".$total."</span><br>";
	 echo "</div>";
 }
 else{
 	echo "  <span class='highlight'>There is no result to show</span><br><br>";
 }
}

?>
