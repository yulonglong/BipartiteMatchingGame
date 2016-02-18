// static
function drawStraightLine(l,r, weight) {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");

	var numberOfImages = Math.max(numberOfImagesLeft,numberOfImagesRight);

	var leftX = 0;
	var leftY = (c.height/numberOfImages/2) + (l*c.height/numberOfImages);
	var rightX = c.width;
	var rightY = (c.height/numberOfImages/2) + (r*c.height/numberOfImages);
	
	ctx.beginPath();
	ctx.moveTo(leftX,leftY);
	ctx.lineTo(rightX,rightY);
	ctx.stroke();
}

// static 
function drawBezierCurve(l,r, weight) {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");

	var numberOfImages = Math.max(numberOfImagesLeft,numberOfImagesRight);

	var leftX = 0;
	var leftY = (c.height/numberOfImages/2) + (l*c.height/numberOfImages);
	var rightX = c.width;
	var rightY = (c.height/numberOfImages/2) + (r*c.height/numberOfImages);
	
	ctx.beginPath();
	ctx.moveTo(leftX,leftY);
	ctx.bezierCurveTo(leftX+c.width/2,leftY,rightX-c.width/2,rightY,rightX,rightY);
	ctx.stroke();
}

// static
function drawLine(lineArr, weightArr, nLeft, nRight) {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	ctx.clearRect(0, 0, c.width, c.height);

	for(var i=0;i<nLeft;i++) {
		for(var j=0;j<nRight;j++) {
			if (lineArr[i][j]) {
				if (Math.abs(i-j) <= 1) {
					drawStraightLine(i, j, weightArr[i][j]);
				}
				else {
					drawBezierCurve(i, j, weightArr[i][j]);
				}
			}
		}
	}
}

// static
function shuffle(o){
	for(var j, z, i = o.length; i; j = Math.floor(Math.random() * i), z = o[--i], o[i] = o[j], o[j] = z);
	return o;
}

// static 
function isValidShuffle(leftFilename, rightFilename, n) {
	for(var i=0;i<n;i++){
		if (leftFilename[i] == rightFilename[i]) return false;
	}
	return true;
}
