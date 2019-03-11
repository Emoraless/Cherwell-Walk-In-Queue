var serviceLump = new Array();

var shorty;
var titleTemp;
var reviewbody;
var tempHTMLHolder;
var canSubmit;
var ownership;

/*

@Authors: Eric Morales, Eric Rhodes
@Owner: Services Studio

This it the javascript api used as data and flow control of this ticketing app.
It delegates which view of the page is to be shown at what time,
while passing and retriving data to/from the proper back end file via ajax and jquery calls.

*/

function walk-in()
{
	var currentTime = new Date();
	var closingTime = new Date();
	closingTime.setHours(17,31,0);
	var openingTime = new Date();
	openingTime.setHours(7,59,0);
	if(currentTime > openingTime && currentTime < closingTime) {
			setInterval(function() {
			//Displays the table of categories, back button, and title of the page.
			$.get('Sources/html/title.html', function (data)
			{
				titleTemp = data;
			});

			// code for IE7+, Firefox, Chrome, Opera, Safari
			if (window.XMLHttpRequest)
			{
				xmlhttp=new XMLHttpRequest();
			}
			// code for IE6, IE5
			else
			{
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			//Event handler
			xmlhttp.onreadystatechange=function()
			{
				//Event handler
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					var obj = JSON.parse(xmlhttp.responseText);

					var a = document.getElementById('content');
					a.innerHTML = titleTemp;
					//Displays the buttons of the pages
					if(obj != "")
					{
						for(i = 0; i < obj.length; i=i+7)
						{
							var full_name = obj[i + 4];
							var name = full_name.split(" ");
							var date = obj[i + 2];
							var time_date = date.split(" ");
							var time = time_date[1].split(":");
							var description = obj[i + 5]
							//var link = "URL";
							a.innerHTML += "<div class='paddingDiv'>"+
															"<div id='walkin-content'>"+
															"<h1 style='float: left; text-align: left; width: 34%;'>"+name[1]+"</h1>"+
															"<h2 style='float: left; text-align: center; width: 5%;'>Arrived:</h2>"+
															"<h1 style='float: left; text-align: center; width: 28%;'>"+time[0]+":"+time[1]+ " "+time_date[2]+"</h1>"+
															"<h1 style='float: left; text-align: right; width: 34%; padding-right: 5px'>"+description+"</h1></div></div>";
						}
					}
				}
			}

			//Opens up the file to retrieve the categories from the server
			xmlhttp.open("GET",'/walk-in.php',true);
			xmlhttp.send();
		}, 5000);
	}
}
