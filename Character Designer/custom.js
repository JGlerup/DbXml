$(document).ready(function() {

	var right = $('header').css('margin-right');
	var sex;
	var sprite;
	var player_name;
	var character;

	$('.start-button').css('right', right);

	$('#male').click(function() {
		$('#male_container').removeClass('hidden');
		$('#female_container').addClass('hidden');
		sex = 'male';
		sprite = 'sprite-male-1';
	});

	$('#female').click(function() {
		$('#female_container').removeClass('hidden');
		$('#male_container').addClass('hidden');
		sex = 'female';
		sprite = 'sprite-female-1';
	});

	$('.cloth_list > li').click(function() {
		$(this).parent().find('.current').removeClass('current');
		$(this).addClass('current');
		sprite = $(this).attr('data-sprite');
		character = $(this).find('img').attr('src');
	});

	$('.save').click(function() {
		$('#'+sex+'_container > img').attr('src', character);
	});

	$('.start-button').click(function() {
		player_name = $('#name').val();

		var playerDetails = { 'name': player_name, 'sex': sex, 'sprite': sprite};
		localStorage['player'] = JSON.stringify(playerDetails);

		window.location.href = "game.html";
	});
});