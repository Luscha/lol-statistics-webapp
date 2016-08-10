<!DOCTYPE html>
<html>
    <head>
        <title>LOLStatistics</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
			integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
			crossorigin="anonymous">
    </head>
	
    <body>
		
		<div class="jumbotron">
			<h1>ADC Main are worst than other players</h1>
		</div>

        <div class="container">
            <div class="content">
				<a href="{{ url('/fetch_challengers') }}" class="btn btn-primary"></i>Fetch Challengers</a>
				<a href="{{ url('/fetch_masters') }}" class="btn btn-primary"></i>Fetch Masters</a>
				<a href="{{ url('/fetch_match') }}" class="btn btn-primary"></i>Fetch Match Informations</a>
            </div>
        </div>
    </body>
</html>
