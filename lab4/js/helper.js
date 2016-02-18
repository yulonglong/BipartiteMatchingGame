function setContextRed() {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	ctx.lineWidth = 4;
	ctx.strokeStyle = '#ff0000';
}

function setContextDefault() {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	ctx.lineWidth = 1;
	ctx.strokeStyle = '#220000';
}

// static
function drawStraightLine(l,r, weight) {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");

	var numberOfImages = Math.max(numberOfImagesLeft,numberOfImagesRight);
	var imageHeight = c.height/numberOfImages;

	var leftX = 0;
	var leftY = (imageHeight/2) + (l*imageHeight);
	var rightX = c.width;
	var rightY = (imageHeight/2) + (r*imageHeight);
	
	ctx.beginPath();
	ctx.moveTo(leftX,leftY);
	ctx.lineTo(rightX,rightY);
	ctx.stroke();


	// Calculate where to draw the weights
	var c = leftY;
	var m = (rightY-leftY)/(rightX-leftX);
	var x = (leftX+rightX)/3;
	var y = m*x+c;

	ctx.font="20px Roboto";
	if (window.innerWidth <= 480) ctx.font="15px Roboto";
	ctx.fillText("s" + weight,x,y);
}

// static 
function drawBezierCurve(l,r, weight) {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");

	var numberOfImages = Math.max(numberOfImagesLeft,numberOfImagesRight);
	var imageHeight = c.height/numberOfImages;

	var leftX = 0;
	var leftY = (imageHeight/2) + (l*imageHeight);
	var rightX = c.width;
	var rightY = (imageHeight/2) + (r*imageHeight);

	var bezierOffset = imageHeight/2;
	if (l>r) bezierOffset = -1*(imageHeight/2);
	
	ctx.beginPath();
	ctx.moveTo(leftX,leftY);
	ctx.bezierCurveTo(leftX+c.width/2,leftY+bezierOffset,rightX-c.width/2,rightY-bezierOffset,rightX,rightY);
	ctx.stroke();

	// Calculate where to draw the weights
	var c = leftY;
	var m = (rightY-leftY)/(rightX-leftX);
	var x = (leftX+rightX)*2/3;
	var y = m*x+c;
	var yOffset = (l-r)*0.11*imageHeight;

	ctx.font="20px Roboto";
	if (window.innerWidth <= 480) ctx.font="15px Roboto";
	ctx.fillText("b" + weight,x,y-yOffset);
}

// static
function drawLine(lineArr, weightArr, selectedEdgeArr, nLeft, nRight) {
	var c=document.getElementById("cvs");
	var ctx=c.getContext("2d");
	ctx.clearRect(0, 0, c.width, c.height);

	setContextDefault();

	for(var i=0;i<nLeft;i++) {
		for(var j=0;j<nRight;j++) {
			if (lineArr[i][j]) {
				if (selectedEdgeArr[i][j]) setContextRed();
				if (Math.abs(i-j) <= 1) {
					drawStraightLine(i, j, weightArr[i][j]);
				}
				else {
					drawBezierCurve(i, j, weightArr[i][j]);
				}
				setContextDefault();
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