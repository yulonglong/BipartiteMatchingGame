function getHighscoreByIdAJAX(currGraphId) {
	var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var highscoreJson = xmlhttp.responseText;
			// $('.msg').html(highscoreJson);
			highscoreArray = JSON.parse(highscoreJson);
			getHighscorePostProcess(highscoreArray, currGraphId);
		}
	};
	// Less than zero means this function is called from the navbar
	if (currGraphId < 0) currGraphId = $('#highscoreGraphId').val();
	if (currGraphId == "") currGraphId = 1;
	if ((currGraphId < 1) || (currGraphId > 9)) {
		$('#tblDescription').html("<p style='color: red;'>Please enter a graph ID between 1 and 9!</p>");
		return;
	}

	xmlhttp.open("GET","matching.php?cmd=highscore&graph_id="+currGraphId,true);
	xmlhttp.send();
}

function getHighscorePostProcess(highscoreArray, currGraphId) {
	$('#tblDescription').html("Top 10 of all time for Graph ID = "+currGraphId);
	$('#tblBody').html("");
	var maxIndex = Math.min(highscoreArray.length, 10);
	for(var i=0;i<maxIndex;i++) {
		$('#tblBody').append("<tr>"+"<td class=\"text-center hidden-xs\">"+(i+1)+"</td>"+
			"<td class=\"text-center\">"+highscoreArray[i]["name"]+"</td>"+
			"<td class=\"text-center\">"+highscoreArray[i]["num_match"]+"</td>"+
			"<td class=\"text-center\">"+highscoreArray[i]["match_score"]+"</td>"+
			"<td class=\"text-center\">"+highscoreArray[i]["duration"]+"</td>"+
			"<td class=\"text-center hidden-xs\">"+highscoreArray[i]["date"]+"</td>"+
			"</tr>")
	}
}
