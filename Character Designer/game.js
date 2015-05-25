$(document).ready(function(){
	var playerDetails = JSON.parse(localStorage['player']);

	$('#player-name').text(playerDetails['name']);
	$('#sprite').html(playerDetails['sprite']);
});