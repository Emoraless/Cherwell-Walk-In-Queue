<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
				<!--meta http-equiv="refresh" content="5; URL=website-URL"-->
        <title>Mobile App</title>
		<link href='./images.png' rel='shortcut icon'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel='stylesheet' type='text/css' href='./css/stylesheet.css' media='all' />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script type='text/javascript' src='./Sources/WebApi.js'>
			var userName = '@HttpContext.Current.User.Identity.Name';
		</script>
		<script type='text/javascript' src='./Sources/WebApi.js' defer='defer'>
		</script>
  </head>
  <body onload='el201()'>
		<!-- OU header -->
		<div id='header-content'>
			<!--div id='image-container' style="text-align:right;">
				<img src='./images/transparent-ouit-logo-white.png' id='ods-logo' alt='Quick-Ticket'/>
			</div-->
			<span id="sign-in"><h1>  Sign in: NeedHelp.com/EL </h1></span>
			<span id="day-of"><h1><span id="datetime"></span></h1></span>
		</div>
		<div id='content'></div>
		<div id='footer-content'>
			<div id='image-container' style="text-align:right;">
				<img src='./images/transparent-ouit-logo-white.png' id='ods-logo' alt='Quick-Ticket'/>
			</div>
		</div>
		<!-- End page content -->
		<script>
		function updateClock() {
			var dt = new Date();
			var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
			var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
			var hour;
			var time;
			if(dt.getHours() < 13) {
				time = "AM";
				hour = dt.getHours();
			}
			else {
				time = "PM";
					hour = dt.getHours() - 12;
			}
			var n = days[dt.getDay()] + " " + months[dt.getMonth()] + " " + ('0' + dt.getDate()).slice(-2)
							+", " + ('0' + hour).slice(-2) + ":" + ('0' + dt.getMinutes()).slice(-2) + " " + time + "  ";
			document.getElementById("datetime").innerHTML = n.toLocaleString();
			setTimeout(updateClock, 1000);
		}

		updateClock();

		</script>
    </body>
</html>
