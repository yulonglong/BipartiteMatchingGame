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

var standardRacoon = ["racoon1.png", "racoon2.png", "racoon3.png", "racoon4.png"];
var shadowRacoon = ["racoon3shadow.png", "racoon4shadow.png", "racoon5shadow.png", "racoon6shadow.png"];
var numberedRacoon = ["racoon2.png", "tworacoon3.png", "threeracoon4.png", "fourracoon5.png"];
var number = ["one.png", "two.png", "three.png", "four.png"];

activateWorksheetOne();