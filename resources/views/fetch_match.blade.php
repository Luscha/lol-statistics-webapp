<!DOCTYPE html>
<html>
    <head>
	
        <title>LOLStatistics</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
			integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
			crossorigin="anonymous">
			
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
		
		<script>
			var _timer = undefined;
			$(function(){
				_timer = setInterval(function () {
					$.post("/ajax/fetch_match_call", {"_token": "{{ csrf_token() }}"}, function (_json) {
						if (_json.status == "content")
						{
							$(".content").append('<span class="label label-success">Fetched and saved '+_json.mNum+' games for player \''+_json.pName+'\' ('+_json.pProcessed+'/'+_json.pTotal+').</span><br>');
						}
						else if (_json.status == "wait")
						{
							$(".content").append('<span class="label label-danger">RATE LIMIT EXCEEDED.</span><br>');
						}
						else if (_json.status == "finish")
						{
							clearInterval(_timer);
							$(".content").append("EVERYTHING DONE!<br>");
						}
						else
						{
							$(".content").append("UNKNOWN ANSWER :" + data + ".<br>");
						}
					})
					.fail(function() {
						clearInterval(_timer);
						$(".content").append("XHR REQUEST FAILED.<br>");
					});
				}, 3000);
			});
		</script>
    </head>
	
    <body>
		
		<div class="jumbotron">
			<h1>ADC Main are worst than other players</h1>
			
		</div>

        <div class="container">
            <div class="content">
				<h2>Fetching Matches<h1>
            </div>
        </div>
    </body>
</html>
