var numberOfImagesLeft = 0;
var numberOfImagesRight = 0;
var correctImages = 0;
var startTime;
var numberOfClicks = 0;
var numberOfWrongs = 0;
var maxNumberOfWrongs = 0;

var filenameRaccoon = ["raccoon1", "raccoon2", "raccoon3", "raccoon4", "raccoon5", "raccoon6", "raccoon7", "raccoon8", "raccoon9", "raccoon10", "raccoon11", "raccoon12"];
var filename = ["toast1", "toast2", "toast3", "toast4", "toast5", "toast6", "toast7", "toast8", "toast9", "toast10", "toast11", "toast12"];

var leftSelected = false;
var rightSelected = false;
var selectedFilename = "";
var selectedIndex = -1;
var lineArray = [[false,false]];
var weightArray = [[0,0]];

initializeArray();
generateWorksheet();

function initializeArray() {
	lineArray = new Array(10);
	weightArray = new Array(10);
	for (var i = 0; i < 10; i++) {
		lineArray[i] = new Array(10);
		weightArray[i] = new Array(10);
		for (var j = 0; j < 10; j++) {
			lineArray[i][j] = false;
			weightArray[i][j] = 0;
		}
	}
}

function generateWorksheet() {
	$('.msg').html("");
	
	var nLeft = $('#numberOfImagesLeft').val();
	if (nLeft == null) nLeft = 4;
	if ((nLeft < 2) || (nLeft > 10)) {
		$('.msg').html('<p>Please enter a number between 2 and 10 !</p>');
		$('.msg').css('color','red');
		return;
	}

	var nRight = $('#numberOfImagesRight').val();
	if (nRight == null) nRight = 4;
	if ((nRight < 2) || (nRight > 10)) {
		$('.msg').html('<p>Please enter a number between 2 and 10 !</p>');
		$('.msg').css('color','red');
		return;
	}

	correctImages = 0;
	numberOfImagesLeft = nLeft;
	numberOfImagesRight = nRight;

	$('#ulLeft').empty();
	$('#ulRight').empty();

	var leftFilename = [];
	var rightFilename = [];
	for(var i=0;i<numberOfImagesLeft;i++){
		leftFilename[i] = filenameRaccoon[i];
	}
	for(var i=0;i<numberOfImagesRight;i++){
		rightFilename[i] = filename[i];
	}

	shuffle(leftFilename);
	shuffle(rightFilename);

	var oneImgIdLeft, oneImgIdRight;

	for(var i=0;i<numberOfImagesLeft;i++){
		oneImgIdLeft = "left"+leftFilename[i];
		$('#ulLeft').append('<div><img class="cartoon unselected left" id="left'+ leftFilename[i] +'" src="img/' + leftFilename[i] + '.png"  onClick="onClickLeft(\''+ leftFilename[i] + '\','+i+')"/></div>');
	}
	if (numberOfImagesLeft < numberOfImagesRight) {
		for(var i=0;i<numberOfImagesRight-numberOfImagesLeft;i++){
			$('#ulLeft').append('<div><img class="cartoonNoHover" src="img/blank.png"/></div>');
		}
	}

	for(var i=0;i<numberOfImagesRight;i++){
		oneImgIdRight = "right"+rightFilename[i];
		$('#ulRight').append('<div><img class="cartoon unselected right" id="right'+ rightFilename[i] +'" src="img/' + rightFilename[i] + '.png"  onClick="onClickRight(\'' + rightFilename[i] + '\','+i+')"/></div>');
	}
	if (numberOfImagesLeft > numberOfImagesRight) {
		for(var i=0;i<numberOfImagesLeft-numberOfImagesRight;i++){
			$('#ulRight').append('<div><img class="cartoonNoHover" src="img/blank.png"/></div>');
		}
	}

	// $('#main').show();
	$('.mainMsg').html('Select an image to start.');

	initializeArray();
	for (var i = 0; i < numberOfImagesLeft; i++) {
		for (var j = 0; j < numberOfImagesRight; j++) { 
			lineArray[i][j] = true;
			weightArray[i][j] = i;
		}
	}

	// Decide on the size of canvas based on the image size
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");

	var oneImgId = oneImgIdRight;
	if (numberOfImagesLeft > numberOfImagesRight) oneImgId = oneImgIdRight;
	var imgRacoon = document.getElementById(oneImgId);

	var multiplier = window.innerWidth/360.0;
	// if (window.innerWidth <= 480) multiplier = 1.3333333;
	if (multiplier > 4) multiplier = 3;
	if (multiplier < 1) multiplier = 1.5;
	c.width  = imgRacoon.clientWidth*multiplier;
	c.height = imgRacoon.clientWidth*Math.max(numberOfImagesLeft,numberOfImagesRight);
	
	ctx.clearRect(0, 0, c.width, c.height);
	// end canvas size setting

	drawLine(lineArray, weightArray, numberOfImagesLeft, numberOfImagesRight);

	startTime = new Date().getTime();
}



function onClickLeft(imageName, index) {
	numberOfClicks++;
	if (leftSelected) {
		// $('#left'+selectedFilename).removeClass('leftSelected');
		$('.mainMsg').html('Invalid choice, please select an image from the right column.');
		return;
	}
	if (!rightSelected) {
		leftSelected = true;
		selectedFilename = imageName;
		$('.mainMsg').html('Select an image from the right column.');
		$('#left'+selectedFilename).addClass('leftSelected');
		$('#left'+selectedFilename).removeClass('unselected');
		selectedIndex = index;
		return;
	}

	// If correct
	if (imageName == selectedFilename) {
		$('.mainMsg').html("<p><b style='color: green;'>Correct match.</b></p>");
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
		$('.mainMsg').html("<p><b style='color: red;'>Wrong match.</b></p>");
		$('#right'+selectedFilename).removeClass('rightSelected');
		$('#right'+selectedFilename).addClass('unselected');
		// if (numberOfWrongs >= maxNumberOfWrongs) {
		// 	failedWorksheet();
		// }
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
		$('.mainMsg').html('Invalid choice, please select an image from the left column.');
		return;
	}
	if (!leftSelected) {
		rightSelected = true;
		selectedFilename = imageName;
		$('.mainMsg').html('Select an image from the left column.');
		$('#right'+selectedFilename).addClass('rightSelected');
		$('#right'+selectedFilename).removeClass('unselected');
		selectedIndex = index;
		return;
	}

	// If correct
	if (imageName == selectedFilename) {
		$('.mainMsg').html("<p><b style='color: green;'>Correct match.</b></p>");
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
		$('.mainMsg').html("<p><b style='color: red;'>Wrong match.</b></p>");
		$('#left'+selectedFilename).removeClass('leftSelected');
		$('#left'+selectedFilename).addClass('unselected');
		// if (numberOfWrongs >= maxNumberOfWrongs) {
		// 	failedWorksheet();
		// }
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
	$('.msg').html("<p><b style='color: green;'>Worksheet completed!</b></p>");
	// $('.msg').html("<p><b style='color: green;'>Worksheet completed!</b></p>"+
	// 	"<p>Time taken : "+minutes+ " minutes "+seconds+ " seconds</p>"+
	// 	"<p>Number of clicks " + numberOfClicks + " <i>(perfect = "+ numberOfImages*2 +")</i></p>"+
	// 	"<p>Select worksheet size and click 'Generate Worksheet'.</p>");
}

function failedWorksheet() {
	var endTime = new Date().getTime();
	var timeTaken = endTime - startTime;
	var seconds = Math.floor(timeTaken/1000);
	var minutes = Math.floor(seconds/60);
	var seconds = Math.floor(seconds%60);
	// $('#main').hide();
	$('#generate').show();
	$('.msg').html("<p><b style='color: red;'>Worksheet failed!</b></p>"+
		"<p>Time taken : "+minutes+ " minutes "+seconds+ " seconds</p>"+
		"<p>Number of wrong matches " + numberOfWrongs + "</p>"+
		"<p>Select worksheet size and click 'Generate Worksheet'.</p>");
}
