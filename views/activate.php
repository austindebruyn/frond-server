<head>
	<script type='text/javascript'>
		$(document).ready(function() {
			$('#activate-form').submit(function() {
				$('#submit').animate({opacity: 0}, 200);
				$('#result-container').animate({height: 0}, 200);
				$.post(
					'/activate',
					{
						pagename: $('#pagename').val(),
						dirname: $('#dirname').val()
					},
					function (result) {
						$('#result-container').animate({height: '64px'}, 200);
						if (!result) {
							$('#result').html('ERROR!');
							$('#submit').animate({opacity: 1}, 200);
						}
						else {
							var full_url = $(location).attr('host')+'/'+result;
							$('#result').html("<a href='/"+result+"'>"+full_url+"</a>");
						}

					}
				);
				return false;
			});
		});
	</script>
</head>

<h1>Activate Directory</h1>
<p>

	<form id='activate-form' action='activate/noscript' method='POST'>
		<label for='pagename'>Page Name: </label>
		<input type='text' id='pagename' name='pagename'><br>
		<label for='dirname'>Directory: /</label>
		<input type='text' id='dirname' name='dirname'><br>
		<input id='submit' type='submit'>
	</form>

	<div id='result-container'>
		<div id='result'>

		</div>
	</div>
</p>