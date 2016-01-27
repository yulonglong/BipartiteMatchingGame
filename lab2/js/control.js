
var filename = ["raccoon1.png", "raccoon2.png", "raccoon3.png", "raccoon4.png",
"raccoon5.png", "raccoon6.png", "raccoon7.png", "raccoon8.png", "raccoon9.png",
"raccoon10.png", "raccoon11.png", "raccoon12.png"];

$("#main").hide()

function shuffle(o){
    for(var j, z, i = o.length; i; j = Math.floor(Math.random() * i), z = o[--i], o[i] = o[j], o[j] = z);
    return o;
}

function generateWorksheet() {
	var n = $('#numberOfImages').val();
	if ((n < 2) || (n > 12)) {
		$('#msg').html('Please enter a number between 2 and 12 !');
		$('#msg').css('color','red');
		return;
	}

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
		$('#ulLeft').append('<li><img class="cartoon" src="img/' + leftFilename[i] + '"/></li>');
		$('#ulRight').append('<li><img class="cartoon" src="img/' + rightFilename[i] + '"/></li>');
	}

	$('#generate').hide();
	$('#main').show()

}