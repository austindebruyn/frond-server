<head>
	<script type='text/javascript'>
		$(document).ready(function() {
			$('#activate-form').submit(function() {
				$.post(
					'/activate',
					{
						pagename: $('#pagename').val(),
						dirname: $('#dirname').val()
					},
					function (result) {
						if (!result)
							$('#result').html('ERROR!');
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
		<input type='text' id='pagename' name='pagename'>
		<label for='dirname'>Directory: /</label>
		<input type='text' id='dirname' name='dirname'>
		<input id='submit' type='submit'>
	</form>

	<div id='result'>

	</div>
</p>