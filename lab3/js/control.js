var numberOfImages = 0;
var correctImages = 0;
var startTime;
var numberOfClicks = 0;
var numberOfWrongs = 0;
var maxNumberOfWrongs = 0;
var filename = ["raccoon1", "raccoon2", "raccoon3", "raccoon4",
"raccoon5", "raccoon6", "raccoon7", "raccoon8", "raccoon9",
"raccoon10", "raccoon11", "raccoon12"];

$("#main").hide()

function shuffle(o){
    for(var j, z, i = o.length; i; j = Math.floor(Math.random() * i), z = o[--i], o[i] = o[j], o[j] = z);
    return o;
}

function drawStraightLine(l,r) {
	var leftX = 0;
	var leftY = 100 + (l*200);
	var rightX = 300;
	var rightY = 100 + (r*200);
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	ctx.beginPath();
	ctx.moveTo(leftX,leftY);
	ctx.lineTo(rightX,rightY);
	ctx.stroke();
}

function drawBezierCurve(l,r) {
	var leftX = 0;
	var leftY = 100 + (l*200);
	var rightX = 300;
	var rightY = 100 + (r*200);
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	ctx.beginPath();
	ctx.moveTo(leftX,leftY);
	ctx.bezierCurveTo(leftX+150,leftY,rightX-150,rightY,rightX,rightY);
	ctx.stroke();
}

function drawLine(matches) {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	ctx.clearRect(0, 0, c.width, c.height);

	for(var i=0;i<numberOfImages;i++) {
		if (matches[i] == -1) continue;
		
		if (Math.abs(i-matches[i]) <= 1) {
			drawStraightLine(i,matches[i]);
		}
		else {
			drawBezierCurve(i,matches[i]);
		}
	}
}

function generateWorksheet() {
	var n = $('#numberOfImages').val();
	if ((n < 2) || (n > 12)) {
		$('#msg').html('<p>Please enter a number between 2 and 12 !</p>');
		$('#msg').css('color','red');
		return;
	}

	correctImages = 0;
	numberOfImages = n;
	numberOfClicks = 0;
	numberOfWrongs = 0;
	maxNumberOfWrongs = n;

	$('#ulLeft').empty();
	$('#ulRight').empty();

	var leftFilename = [];
	var rightFilename = [];
	for(var i=0;i<n;i++){
		leftFilename[i] = filename[i];
		rightFilename[i] = filename[i];
	}

	shuffle(leftFilename);
	shuffle(rightFilename);

	for(var i=0;i<n;i++){
		$('#ulLeft').append('<li><img class="cartoon" id="left'+ leftFilename[i] +'" src="img/' + leftFilename[i] + '.png"  onClick="onClickLeft(\''+ leftFilename[i] + '\','+i+')"/></li>');
		$('#ulRight').append('<li><img class="cartoon" id="right'+ rightFilename[i] +'" src="img/' + rightFilename[i] + '.png"  onClick="onClickRight(\'' + rightFilename[i] + '\','+i+')"/></li>');
	}

	$('#generate').hide();
	$('#main').show();
	$('#mainMsg').html('Select an image to start.');

	for (var i = 0; i < numberOfImages; i++) match[i] = -1;

	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	var height = 200 * n;
	c.height = height;
	c.width = 300;
	ctx.clearRect(0, 0, c.width, c.height);

	startTime = new Date().getTime();
}

var leftSelected = false;
var rightSelected = false;
var selectedFilename = "";
var selectedIndex = -1;
var match = [];

function onClickLeft(imageName, index) {
	numberOfClicks++;
	if (leftSelected) {
		// $('#left'+selectedFilename).removeClass('leftSelected');
		$('#mainMsg').html('Invalid choice, please select an image from the right column.');
		return;
	}
	if (!rightSelected) {
		leftSelected = true;
		selectedFilename = imageName;
		$('#mainMsg').html('Select an image from the right column.');
		$('#left'+selectedFilename).addClass('leftSelected');
		selectedIndex = index;
		return;
	}

	// If correct
	if (imageName == selectedFilename) {
		$('#mainMsg').html('Correct match.');
		$('#left'+imageName).addClass('leftSelected correctSelected');
		$('#right'+selectedFilename).addClass('correctSelected');

		$('#left'+imageName).attr('onClick','');
		$('#right'+selectedFilename).attr('onClick','');

		match[index] = selectedIndex;
		drawLine(match);

		correctImages += 1;
		if (correctImages == numberOfImages) {
			finishedWorksheet();
		}
	}
	else {
		numberOfWrongs++;
		$('#mainMsg').html('Wrong match.');
		$('#right'+selectedFilename).removeClass('rightSelected');
		if (numberOfWrongs >= maxNumberOfWrongs) {
			failedWorksheet();
		}
	}

	leftSelected = "";
	rightSelected = false;
	selectedFilename = "";
	leftSelectedIndex = -1;
	rightSelectedIndex = -1;
}

function onClickRight(imageName, index) {
	numberOfClicks++;
	if (rightSelected) {
		// $('#right'+selectedFilename).removeClass('rightSelected');
		$('#mainMsg').html('Invalid choice, please select an image from the left column.');
		return;
	}
	if (!leftSelected) {
		rightSelected = true;
		selectedFilename = imageName;
		$('#mainMsg').html('Select an image from the left column.');
		$('#right'+selectedFilename).addClass('rightSelected');
		selectedIndex = index;
		return;
	}

	// If correct
	if (imageName == selectedFilename) {
		$('#mainMsg').html('Correct match.');
		$('#right'+imageName).addClass('rightSelected correctSelected');
		$('#left'+selectedFilename).addClass('correctSelected');

		$('#right'+imageName).attr('onClick','');
		$('#left'+selectedFilename).attr('onClick','');

		match[selectedIndex] = index;
		drawLine(match);

		correctImages += 1;
		if (correctImages == numberOfImages) {
			finishedWorksheet();
		}
	}
	else {
		numberOfWrongs++;
		$('#mainMsg').html('Wrong match.');
		$('#left'+selectedFilename).removeClass('leftSelected');
		
		if (numberOfWrongs >= maxNumberOfWrongs) {
			failedWorksheet();
		}
	}

	leftSelected = false;
	rightSelected = false;
	selectedFilename = "";
	leftSelectedIndex = -1;
	rightSelectedIndex = -1;
}

function finishedWorksheet() {
	var endTime = new Date().getTime();
	var timeTaken = endTime - startTime;
	var seconds = Math.floor(timeTaken/1000);
	var minutes = Math.floor(seconds/60);
	var seconds = Math.floor(seconds%60);
	// $('#main').hide();
	$('#generate').show();
	$('#msg').html("<p><b style='color: green;'>Worksheet completed!</b></p>"+
		"<p>Time taken : "+minutes+ " minutes "+seconds+ " seconds</p>"+
		"<p>Number of clicks " + numberOfClicks + " <i>(perfect = "+ numberOfImages*2 +")</i></p>"+
		"<p>Select worksheet size and click 'Generate Worksheet'.</p>");
}

function failedWorksheet() {
	var endTime = new Date().getTime();
	var timeTaken = endTime - startTime;
	var seconds = Math.floor(timeTaken/1000);
	var minutes = Math.floor(seconds/60);
	var seconds = Math.floor(seconds%60);
	// $('#main').hide();
	$('#generate').show();
	$('#msg').html("<p><b style='color: red;'>Worksheet failed!</b></p>"+
		"<p>Time taken : "+minutes+ " minutes "+seconds+ " seconds</p>"+
		"<p>Number of wrong matches " + numberOfWrongs + "</p>"+
		"<p>Select worksheet size and click 'Generate Worksheet'.</p>");
}
