$(document).ready(function(){
//	$('#timerdemo').stopwatch().stopwatch('start');

	var counter = 0, // to keep track of current slide
	$items = document.querySelectorAll('#QuestionWrap #question'), // a collection of all of the slides, caching for performance
	numItems = $items.length; // total number of slides


	// this function is what cycles the slides, showing the next or previous slide and hiding all the others
	var showCurrent = function(){

			var itemToShow = Math.abs(counter%numItems);

			[].forEach.call( $items, function(el){
					el.classList.add('hide');
			});
				$items[itemToShow].classList.remove('hide');
			$items[itemToShow].classList.add('show');

	};


setInterval(function () {
	$("#reset").click();

			counter++;
			if(counter==5)
			{
				submit();
			}
			else {
				showCurrent();
			}

	}, 20000);


var nextButtons =	document.querySelectorAll('.nextq');
for (var i = 0; i < nextButtons.length; i++) {
nextButtons[i].addEventListener('click', function() {
	$("#reset").click();
		counter++;
		if(counter==5)
		{
			submit();
		}
		else {
			showCurrent();

		}
	}, false);
}



var stop = document.getElementById("stop");
stop.addEventListener('click', function() {
			submit();
	}, false);



	function submit(){
 		var category = document.getElementById("category").value;
 	     $.ajax({
 						type: "POST",
 						url: "ajax.php",
 						data:  $('form').serialize(),
 						success: function(msg) {
 						  $("#QuestionWrap,#countdown,#pause,#resume,#stop,#reset").addClass("hide1");
							$('#result').addClass("show");
 						  $('#result').show();
 						  $('#result').append(msg);
 						}
 	     });

 	}






});
