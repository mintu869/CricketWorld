<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <style>  
		table, th, td {  
		border: 1px solid black;  
		border-collapse: collapse;  
		padding: 6px;  
		}
		
		.team{
			display:none;
			color:grey;
		}
</style> 
<script>
	$(document).ready(function(){
		$('.teams').on('click',function(){
			 $(".team").fadeOut("slow");
			 $(this).next('.team:first').fadeIn("slow");
		});
	});
</script> 
</head>

    <body>
			@include('includes.header')
  
<div class="container">  
  <table class="table table-hover table-striped">
  <tbody>
  <thead>
    <tr>
		<th></th>
		<th>Logo</th>
		<th>Team Name</th>
		<th>Club</th>
		<th>Matches</th>
    </tr>
  </thead>
  
   @foreach($teams as $key => $value)
    <tr class="teams" title="Click here to view players">
	   <td>{{$key+1}}</td>
       <td><img src="{{ URL::to('/') }}/images/{{ $value->logo }}" height="100" /></td>
       <td valign ="center">{{ $value->name }}</td>
       <td valign ="center">{{ $value->club }}</td>
       <td valign ="center"><a href="{{url('/team-matches', [$value->id])}}">View matches</a></td>
    </tr>
    <tr class="team">
      <td colspan="4">
        <table class="table">
		<thead><th colspan="10">Team Players</th></thead>
          <thead>
			<th>Sr. No.</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Jersey Number</th>
            <th>Country</th>
			<th>Matches</th>
			<th>Total Runs</th>
			<th>Highest Score</th>
			<th>50`s</th>
			<th>100`s</th>
          </thead>
          <tbody>
		   @foreach($value->players as $index => $player)
            <tr>
				<td>{{$index+1}}</td>
				<td>{{$player->first_name}}</td>
				<td>{{$player->last_name}}</td>				
				<td>{{$player->jersey_number}}</td>			
				<td>{{$player->country}}</td>
				<td>{{$player->history['matches']}}</td>
				<td>{{$player->history['runs']}}</td>
				<td>{{$player->history['highest_score']}}</td>
				<td>{{$player->history['fifties']}}</td>
				<td>{{$player->history['hundreds']}}</td>
            </tr>
           @endforeach
          </tbody>
        </table>
      </td>
    </tr>
	@endforeach
  </tbody>
</table>
</div>
  </body>
</html>
