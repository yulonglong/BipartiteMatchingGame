function activateWorkbookOne() {
	document.getElementById("section1").style.visibility = "visible";
	document.getElementById("section1").style.display = "";
	document.getElementById("section2").style.visibility = "hidden";
	document.getElementById("section2").style.display = "none";
}

function activateWorkbookTwo() {
    document.getElementById("section1").style.visibility = "hidden";
    document.getElementById("section1").style.display = "none";
    document.getElementById("section2").style.visibility = "visible";
	document.getElementById("section2").style.display = "";
}

activateWorkbookOne();