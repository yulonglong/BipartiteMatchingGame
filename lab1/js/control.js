function activateWorksheetOne() {
	$("#section1").show();
	$("#section2").hide();
	$("#section3").hide();
}

function activateWorksheetTwo() {
	$("#section1").hide();
	$("#section2").show();
	$("#section3").hide();
}

function activateWorksheetThree() {
	$("#section1").hide();
	$("#section2").hide();
	$("#section3").show();
}

activateWorksheetOne();