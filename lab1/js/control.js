function activateWorksheetOne() {
	document.getElementById("section1").style.visibility = "visible";
	document.getElementById("section1").style.display = "";
	document.getElementById("section2").style.visibility = "hidden";
	document.getElementById("section2").style.display = "none";
	document.getElementById("section3").style.visibility = "hidden";
	document.getElementById("section3").style.display = "none";
}

function activateWorksheetTwo() {
	document.getElementById("section1").style.visibility = "hidden";
	document.getElementById("section1").style.display = "none";
	document.getElementById("section2").style.visibility = "visible";
	document.getElementById("section2").style.display = "";
	document.getElementById("section3").style.visibility = "hidden";
	document.getElementById("section3").style.display = "none";
}

function activateWorksheetThree() {
	document.getElementById("section1").style.visibility = "hidden";
	document.getElementById("section1").style.display = "none";
	document.getElementById("section2").style.visibility = "hidden";
	document.getElementById("section2").style.display = "none";
	document.getElementById("section3").style.visibility = "visible";
	document.getElementById("section3").style.display = "";
}

activateWorksheetOne();