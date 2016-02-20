var filenameRaccoon = ["raccoon1", "raccoon2", "raccoon3", "raccoon4", "raccoon5", "raccoon6", "raccoon7", "raccoon8", "raccoon9", "raccoon10", "raccoon11", "raccoon12"];
var filename = ["toast1", "toast2", "toast3", "toast4", "toast5", "toast6", "toast7", "toast8", "toast9", "toast10", "toast11", "toast12"];
var leftFilename = [];
var rightFilename = [];

var numberOfImagesLeft = 0;
var numberOfImagesRight = 0;
var leftSelected = false;
var rightSelected = false;
var selectedFilename = "";
var selectedIndex = -1;
var lineArray = [[false,false]];
var weightArray = [[0,0]];
var selectedEdgeArray = [[false,false]];
var correctEdgeArray = [[false,false]];
var totalScore = 0;
var totalPair = 0;
var graphJson = "";
var solvedGraphArray = [];

initializeArray();
generateWorksheet();

function initializeArray() {
	lineArray = new Array(10);
	weightArray = new Array(10);
	selectedEdgeArray = new Array(10);
	correctEdgeArray = new Array(10);
	for (var i = 0; i < 10; i++) {
		lineArray[i] = new Array(10);
		weightArray[i] = new Array(10);
		selectedEdgeArray[i] = new Array(10);
		correctEdgeArray[i] = new Array(10);
		for (var j = 0; j < 10; j++) {
			lineArray[i][j] = false;
			weightArray[i][j] = 0;
			selectedEdgeArray[i][j] = false;
			correctEdgeArray[i][j] = false;
		}
	}
}

function initialize() {
	leftSelected = false;
	rightSelected = false;
	selectedFilename = "";
	selectedIndex = -1;

	leftFilename = [];
	rightFilename = [];

	numberOfImagesLeft = 0;
	numberOfImagesRight = 0;
	leftSelected = false;
	rightSelected = false;
	selectedFilename = "";
	selectedIndex = -1;
	lineArray = [[false,false]];
	weightArray = [[0,0]];
	selectedEdgeArray = [[false,false]];
	correctEdgeArray = [[false,false]];
	totalScore = 0;
	totalPair = 0;
	graphJson = "";
	solvedGraphArray = [];

	initializeArray();
}

function generateGraphAJAX(left, right) {
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
			graphJson = xmlhttp.responseText;
			var jsArray = JSON.parse(graphJson);

			var arrayLength = jsArray["E"].length;
			for (var i = 0; i < arrayLength; i++) {
				var leftIndex = jsArray["E"][i][0];
				var rightIndex = jsArray["E"][i][1];
				var weight = jsArray["E"][i][2];
				lineArray[leftIndex][rightIndex] = true;
				weightArray[leftIndex][rightIndex] = weight;
				// alert(jsArray["E"][i][0] + " " + jsArray["E"][i][1] + " " + jsArray["E"][i][2]);
			}
			drawLine(lineArray, weightArray, selectedEdgeArray, correctEdgeArray, numberOfImagesLeft, numberOfImagesRight);
			// $('.msg').html(graphJson);
		}
	};
	xmlhttp.open("GET","matching.php?cmd=generate&N="+left+"&M="+right,true);
	xmlhttp.send();
}

function solveGraphAJAX() {
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
			var solvedGraphJson = xmlhttp.responseText;
			// $('.msg').html(solvedGraphJson);
			solvedGraphArray = JSON.parse(solvedGraphJson);
			solveGraph();
		}
	};
	// xmlhttp.open("GET","http://cs3226.comp.nus.edu.sg/matching.php?cmd=solve&graph="+graphJson,true);
	xmlhttp.open("GET","matching.php?cmd=solve&graph="+graphJson,true);
	xmlhttp.send();
}

function solveGraph() {
	var correctPair = parseInt(solvedGraphArray["num_match"]);
	var correctScore = parseInt(solvedGraphArray["match_score"]);

	var arrayLength = solvedGraphArray["match"].length;
	for (var i = 0; i < arrayLength; i++) {
		var leftIndex = solvedGraphArray["match"][i][0];
		var rightIndex = solvedGraphArray["match"][i][1];
		correctEdgeArray[leftIndex][rightIndex] = true;
	}

	drawLine(lineArray, weightArray, selectedEdgeArray, correctEdgeArray, numberOfImagesLeft, numberOfImagesRight);

	if (correctPair > totalPair) {
		$('.msg').append("<br/><b style='color: red;'>More raccoons ("+correctPair+") could eat in the optimal answer.</b>");
	}
	else if ((correctPair == totalPair) && (correctScore > totalScore)) {
		$('.msg').append("<br/><b style='color: red;'>More points ("+correctScore+") can be obtained in the optimal answer.</b>");
	}
	else {
		$('.msg').append("<br/><b style='color: green;'>Congratulations! Your answer is optimal.</b>");
	}

	for(var i=0;i<numberOfImagesLeft;i++){
		var currId = "left"+leftFilename[i];
		$('#'+currId).removeClass("cartoon unselected");
		$('#'+currId).addClass("cartoonNoHover");
		$('#'+currId).attr('onClick','');
	}
	for(var i=0;i<numberOfImagesRight;i++){
		var currId = "right"+rightFilename[i];
		$('#'+currId).removeClass("cartoon unselected");
		$('#'+currId).addClass("cartoonNoHover");
		$('#'+currId).attr('onClick','');
	}
}

function generateWorksheet() {
	$('.msg').html("");
	
	var nLeft = $('#numberOfImagesLeft').val();
	if (nLeft == null) nLeft = 4;
	if ((nLeft < 2) || (nLeft > 10)) {
		$('.msg').html("<p style='color: red;'>Please enter a number between 2 and 10 !</p>");
		return;
	}

	var nRight = $('#numberOfImagesRight').val();
	if (nRight == null) nRight = 4;
	if ((nRight < 2) || (nRight > 10)) {
		$('.msg').html("<p style='color: red;'>Please enter a number between 2 and 10 !</p>");
		return;
	}
	
	initialize();

	correctImages = 0;
	numberOfImagesLeft = parseInt(nLeft);
	numberOfImagesRight = parseInt(nRight);

	$('#ulLeft').empty();
	$('#ulRight').empty();

	leftFilename = [];
	rightFilename = [];
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
	$('.mainMsg').html('Feed as many raccoons as possible and get the highest score.');

	generateGraphAJAX(numberOfImagesLeft, numberOfImagesRight);

	// Decide on the size of canvas based on the image size
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");

	var oneImgId = oneImgIdRight;
	if (numberOfImagesLeft > numberOfImagesRight) oneImgId = oneImgIdRight;
	var imgRacoon = document.getElementById(oneImgId);

	var multiplier = window.innerWidth/360.0;
	// if (window.innerWidth <= 480) multiplier = 1.3333333;
	if (multiplier > 4) multiplier = 3;
	if (multiplier < 1.5) multiplier = 1.5;
	c.width  = imgRacoon.clientWidth*multiplier;
	c.height = imgRacoon.clientWidth*Math.max(numberOfImagesLeft,numberOfImagesRight);
	
	ctx.clearRect(0, 0, c.width, c.height);
	// end canvas size setting

	drawLine(lineArray, weightArray, selectedEdgeArray, correctEdgeArray, numberOfImagesLeft, numberOfImagesRight);

	startTime = new Date().getTime();
}



function onClickLeft(imageName, index) {
	if (leftSelected) {
		// $('#left'+selectedFilename).removeClass('leftSelected');
		$('.mainMsg').html('Invalid choice, please select a toast from the right column.');
		return;
	}
	if (!rightSelected) {
		leftSelected = true;
		selectedFilename = imageName;
		$('.mainMsg').html('Select a toast from the right column.');
		$('#left'+selectedFilename).addClass('leftSelected');
		$('#left'+selectedFilename).removeClass('unselected');
		selectedIndex = index;
		return;
	}

	// If there is an edge
	if (lineArray[index][selectedIndex]) {
		selectedEdgeArray[index][selectedIndex] = true;
		totalScore += weightArray[index][selectedIndex];
		totalPair++;

		drawLine(lineArray, weightArray, selectedEdgeArray, correctEdgeArray, numberOfImagesLeft, numberOfImagesRight);

		$('.mainMsg').html("<p><b>Edge selected.</b></p>");
		$('.msg').html(totalPair + " raccoon(s) have eaten. Current score : " + totalScore);
		$('#left'+imageName).addClass('leftSelected correctSelected');
		$('#left'+imageName).removeClass('unselected');
		$('#right'+selectedFilename).addClass('correctSelected');

		$('#left'+imageName).attr('onClick','');
		$('#right'+selectedFilename).attr('onClick','');
	}
	else {
		$('.mainMsg').html("<p><b style='color: red;'>Invalid match, no edge found.</b></p>");
		$('#right'+selectedFilename).removeClass('rightSelected');
		$('#right'+selectedFilename).addClass('unselected');
	}

	leftSelected = false;
	rightSelected = false;
	selectedFilename = "";
	selectedIndex = -1;
}

function onClickRight(imageName, index) {
	if (rightSelected) {
		// $('#right'+selectedFilename).removeClass('rightSelected');
		$('.mainMsg').html('Invalid choice, please select a raccoon from the left column.');
		return;
	}
	if (!leftSelected) {
		rightSelected = true;
		selectedFilename = imageName;
		$('.mainMsg').html('Select a raccoon from the left column.');
		$('#right'+selectedFilename).addClass('rightSelected');
		$('#right'+selectedFilename).removeClass('unselected');
		selectedIndex = index;
		return;
	}

	// If there is an edge
	if (lineArray[selectedIndex][index]) {
		selectedEdgeArray[selectedIndex][index] = true;
		totalScore += weightArray[selectedIndex][index];
		totalPair++;

		drawLine(lineArray, weightArray, selectedEdgeArray, correctEdgeArray, numberOfImagesLeft, numberOfImagesRight);

		$('.mainMsg').html("<p><b>Edge selected.</b></p>");
		$('.msg').html(totalPair + " raccoon(s) have eaten. Current score : " + totalScore);
		$('#right'+imageName).addClass('rightSelected correctSelected');
		$('#right'+imageName).removeClass('unselected');
		$('#left'+selectedFilename).addClass('correctSelected');

		$('#right'+imageName).attr('onClick','');
		$('#left'+selectedFilename).attr('onClick','');
	}
	else {
		$('.mainMsg').html("<p><b style='color: red;'>Invalid match, no edge found.</b></p>");
		$('#left'+selectedFilename).removeClass('leftSelected');
		$('#left'+selectedFilename).addClass('unselected');
	}

	leftSelected = false;
	rightSelected = false;
	selectedFilename = "";
	selectedIndex = -1;
}
