var CountDown = (function ($) {
    // Length ms
    var TimeOut = 10000;
    // Interval ms
    var TimeGap = 1000;

    var CurrentTime = ( new Date() ).getTime();
    var EndTime = ( new Date() ).getTime() + TimeOut;

    var GuiTimer = $('#countdown');
    var GuiPause = $('#pause');
    var GuiResume = $('#resume');

    var Running = true;
	var timeoutId="";

    var UpdateTimer = function() {
        // Run till timeout
        if( CurrentTime + TimeGap < EndTime ) {
            timeoutId=setTimeout( UpdateTimer, TimeGap );
        }
        // Countdown if running
        if( Running ) {
            CurrentTime += TimeGap;
            if( CurrentTime >= EndTime ) {
                GuiTimer.css('color','black');
            }
        }
        // Update Gui
        var Time = new Date();
        Time.setTime( EndTime - CurrentTime );
        var Minutes = Time.getMinutes();
        var Seconds = Time.getSeconds();
        d = document.getElementById("countdown");
        if(Seconds>9)
		      {d.innerHTML = '0'+Minutes+':'+Seconds;}
          else {
            {d.innerHTML = '0'+Minutes+':0'+Seconds;}
          }
    };

    var Pause = function() {
        Running = false;
        GuiResume.show();
    };

    var Resume = function() {
        Running = true;
        GuiPause.show();
    };

    var Start = function( Timeout ) {
        TimeOut = Timeout;
        CurrentTime = ( new Date() ).getTime();
        EndTime = ( new Date() ).getTime() + TimeOut;
        UpdateTimer();
    };

	var Reset = function(){
	clearTimeout(timeoutId);
     CountDown.Start(20000);
  };
    return {
        Pause: Pause,
        Resume: Resume,
        Start: Start,
      	Reset: Reset
    };
})(jQuery);

jQuery('#pause').on('click',CountDown.Pause);
jQuery('#resume').on('click',CountDown.Resume);
jQuery('#reset').on('click',CountDown.Reset);

CountDown.Start(20000);
