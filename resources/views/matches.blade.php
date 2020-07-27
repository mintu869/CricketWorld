<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
		.error{
			color:red;
			display:none;
		}
		.result{
			display:none;
		}
</style> 
<script type="text/javascript">
	$(document).ready(function(){
		
		$("select.team").on('change',function(){
			var attrName = $(this).prop('name');
			var team_id = $(this).val();
			var itemsToIterate = (attrName=="team_1")?"team_2":"team_1";
			$('select#'+itemsToIterate+' option').each(function() {
				var $thisOption = $(this);
				$thisOption.attr('disabled',false);
				$thisOption.attr('selected',false);
				if($thisOption.val() == team_id) {
					$thisOption.attr("disabled", "disabled");
				}
			});
		});
		$('#setMatchResult').on('show.bs.modal', function(e) {

			//get data-id attribute of the clicked element
			var team_1_data = $(e.relatedTarget).data('team_1');
			var match_id = $(e.relatedTarget).data('match-id');
			team_1_data = team_1_data.split('-');
			var team_2_data = $(e.relatedTarget).data('team_2');
			team_2_data = team_2_data.split('-');
			var teamsOptions ="<option value=''>Select</option>"
			teamsOptions += "<option value=\""+team_1_data[0]+"\">"+team_1_data[1]+"</option>";
			teamsOptions += "<option value=\""+team_2_data[0]+"\">"+team_2_data[1]+"</option>";
			//populate the textbox
			$(e.currentTarget).find('select[name="winner_id"]').html(teamsOptions);
			$(e.currentTarget).find('input[type="hidden"][name="team_1_id"]').val(team_1_data[0]);
			$(e.currentTarget).find('input[type="hidden"][name="team_2_id"]').val(team_2_data[0]);
			$(e.currentTarget).find('input[type="hidden"][name="match_id"]').val(match_id);
		});
	});
	function saveMatchFixture(){
		var valid = validate("addMatch");
		if(valid==true){
			var winning_points = $('input[name="winning_points"]').val();			
			var points_to_both = $('input[name="points_to_both"]').val()
			if(winning_points <= points_to_both){
				$('input[type="number"][name="points_to_both"]').next("span.error").text("Points to both value must be lesser than winning points").show();
				return false;
			}
			var form_data = {
				_token:$('#addMatch').find('input[name="_token"]').val(),
				match_date:$('input[name="match_date"]').val(),
				venue_id:$('select[name="venue_id"]').val(),
				team_1:$('select[name="team_1"]').val(),
				team_2:$('select[name="team_2"]').val(),
				winning_points:$('input[name="winning_points"]').val(),
				points_to_both:$('input[name="points_to_both"]').val(),
			};
			$.ajax({  
				type:'POST',
				url:'/api/save-match-fixture',
				data:form_data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success:function(data) {
					if(data.status==1)
					{
						$("#msg").show();
						$("#msg").addClass("alert-success");
						$("#msg").text(data.msg);
						setTimeout(function(){ 							
							$("#msg").text("");				
							$("#msg").fadeOut("slow");
							window.location.href = "{{url()->current()}}"; 
						}, 2000);
						
					}
					else{
						$("#msg").show();
						$("#msg").addClass("alert-danger");
						$("#msg").text(data.msg);
						setTimeout(function(){ 
							$("#msg").removeClass("alert-danger");
							$("#msg").text("");				
							$("#msg").fadeOut("slow");
						}, 3000);
					}
				  
			   }
			});
		}
	}
	function validate(form,obj){
		obj = (typeof obj != 'undefined')?obj:"";
		var error = new Array();
		if(obj==""){
			
			$('span.error').text('');
			$('#'+form+' input:visible, #'+form+' select:visible').each(function(key, value) {
				var field_name = $(this).attr("name");
				field_name = field_name.split('_');
				field_name = field_name.join(' ');
				if($(this).val()==""){						
						error.push(field_name);
						$(this).next('span.error').text("The "+field_name+" field required").show();
				}else{
					if($(this).attr('type')=="number" && isNaN($(this).val())){
						$(this).next('span.error').text("The "+field_name+" field must be integer").show();
						error.push(field_name);
					}
				}
			});
			return (error.length==0)?true:false;
		}else{
			var field_name = $(obj).attr("name");
			field_name = field_name.split('_');
			field_name = field_name.join(' ');
			if($(obj).value!=""){
				$(obj).next('span.error').text("").hide();
			}
			
			if((obj).value!="" && $(obj).attr("name")=="points_to_both" && (parseInt($('input[name="winning_points"]').val()) <= parseInt($(obj).val()) )){
				
				$(obj).next('span.error').text("The "+field_name+" field must be lesser than winning points").show();
				error.push(field_name);
			}
			if((obj).value!="" && $(obj).attr("name")=="winning_points" && (parseInt($('input[name="points_to_both"]').val()) >= parseInt($(obj).val()) )){
				
				$(obj).next('span.error').text("The "+field_name+" field must be greater than points to both").show();
				error.push(field_name);
			}
			
		}
	}
	function getVenues (obj){		
		var dateValue = $(obj).val();
		$.ajax({  
		type:'POST',
        url:'/api/get-venues',
		data:{matchDate:dateValue},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success:function(data) {
			if(data.status==1)
			{
				$('select[name="venue_id"]').html(data.venuesOptions);
				$('select[name="team_1"]').html(data.teamsOptions);
				$('select[name="team_2"]').html(data.teamsOptions);
				
			}
			else{
				$("#msg").show();
				$("#msg").addClass("alert-danger");
				$("#msg").text(data.msg);
				setTimeout(function(){ 
					$("#msg").removeClass("alert-danger");
					$("#msg").text("");				
					$("#msg").fadeOut("slow");
				}, 3000);
			}
		  
	   }
	});
}
function saveMatchResult(){
	var valid = validate("setMatchResult");
	if(valid==true){
		var result = $('select[name="result"]').val();
		var team_1_runs = $('input[name="team_1_runs"]').val();
		var team_2_runs = $('input[name="team_2_runs"]').val();
		var winner_id = $('select[name="winner_id"]').val();
		var team_id_1 = $('input[type="hidden"][name="team_1_id"]').val();
		var team_id_2 = $('input[type="hidden"][name="team_2_id"]').val();
		var match_id = $('input[name="match_id"]').val();
		switch(result) {
		case 'Win and loss':
			if(team_1_runs==team_2_runs){
				$("#msgSetmatch").show();
				$("#msgSetmatch").addClass("alert-danger");
				$("#msgSetmatch").text("Team1 and Team 2 score should be different !");
				setTimeout(function(){ 									
					$("#msgSetmatch").fadeOut("slow");
				}, 3000);
				return false;
			}
			if(winner_id == team_id_1){
				if(team_1_runs<=team_2_runs){
					$("#msgSetmatch").show();
					$("#msgSetmatch").addClass("alert-danger");
					$("#msgSetmatch").text("Team 1 score must be greater than team 2 !");
					setTimeout(function(){ 									
						$("#msgSetmatch").fadeOut("slow");
					}, 3000);
					return false;
				}
			} else {
				if(team_2_runs <= team_1_runs){
					$("#msgSetmatch").show();
					$("#msgSetmatch").addClass("alert-danger");
					$("#msgSetmatch").text("Team 2 score must be greater than team 1 !");
					setTimeout(function(){ 									
						$("#msgSetmatch").fadeOut("slow");
					}, 3000);
					return false;
				}
			}
			break;
			case 'Tie':
			if(team_1_runs != team_2_runs){
				$("#msgSetmatch").show();
					$("#msgSetmatch").addClass("alert-danger");
					$("#msgSetmatch").text("Team 1 and team 2 score must be same !");
					setTimeout(function(){ 									
						$("#msgSetmatch").fadeOut("slow");
					}, 3000);
				return false;
			}
			break;			
			default:
			break;
		}
			var form_data = {
				_token:$('#setMatchResult').find('input[name="_token"]').val(),
				result:result,
				team_1_runs:team_1_runs,
				team_2_runs:team_2_runs,
				winner_id:winner_id,
				team_id_1:team_id_1,
				team_id_2:team_id_2,
				match_id:match_id,
			};
			$.ajax({  
				type:'POST',
				url:'/api/save-match-result',
				data:form_data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success:function(data) {
					if(data.status==1)
					{
						$("#msgSetmatch").show();
						$("#msgSetmatch").addClass("alert-success");
						$("#msgSetmatch").text(data.msg);
						setTimeout(function(){ 			
							$("#msg").fadeOut("slow");
							window.location.href = "{{url()->current()}}"; 
						}, 1000);
						
					}
					else{
						$("#msgSetmatch").show();
						$("#msgSetmatch").addClass("alert-danger");
						$("#msgSetmatch").text(data.msg);
						setTimeout(function(){ 			
							$("#msgSetmatch").fadeOut("slow");
						}, 3000);
					}
				  
			   }
			});
		
		
	}
}
function getResultFields(obj){
		var selectedStatus = $(obj).val();
		switch(selectedStatus){
			case 'Win and loss':
			$('.result').show();
			$('.winner').show();
			break;
			case 'Tie':
			$('.result').show();
			$('.winner').hide();
			break;
			default:			
			$('.result').hide();
			$('.winner').hide();
			break;
		}
	}
</script> 
</head>

    <body>
		@include('includes.header')
		 
<div class="container"> 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMatch" style="float:right;margin:5px;">Add Match</button> 
 <!-- Material form contact -->
<div class="modal fade" id="addMatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Match Fixture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div id="msg" class="alert" role="alert" style="display:none;">		 
		</div>
        <form id="addMatch" name="addMatch">
		{{ csrf_field() }}
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input type="date" class="form-control" onBlur="" min="{{date('Y-m-d')}}" id="match_date" name="match_date" onChange="validate('addMatch',this),getVenues(this);">
			<span class="error"></span>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Venue:</label>
            <select name="venue_id" onChange="validate('addMatch',this)" class="form-control"><option value="">Select</option></select>
			<span class="error"></span>
          </div>
		  <div class="form-group">
            <label for="message-text" class="col-form-label">Team 1:</label>
            <select name="team_1" id="team_1" onChange="validate('addMatch',this)" class="form-control team"><option value="">Select</option></select>
			<span class="error"></span>
          </div>
		   <div class="form-group">
            <label for="message-text" class="col-form-label">Team 2:</label>
            <select name="team_2" onChange="validate('addMatch',this)" id="team_2" class="form-control team"><option value="">Select</option></select>
			<span class="error"></span>
          </div>
		   <div class="form-group">
            <label for="message-text" class="col-form-label">Winning Points:</label>
				<input type="number" id="winning_points" name="winning_points" min="1"  onChange="validate('addMatch',this)" class="form-control"/>
			<span class="error"></span>
          </div>
		  <div class="form-group">
            <label for="message-text" class="col-form-label">Points to both on tie:</label>
				<input type="number" id="points_to_both" name="points_to_both" min="1"  onChange="validate('addMatch',this)" class="form-control"/>
			<span class="error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveMatchFixture()">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="setMatchResult" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Set Match Result</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div id="msgSetmatch" class="alert" role="alert" style="display:none;">		 
		</div>
        <form id="setMatchResult" name="setMatchResult">
		{{ csrf_field() }}
		<input type="hidden" name="team_1_id" value="">
		<input type="hidden" name="team_2_id" value="">
		<input type="hidden" name="match_id" value="">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Match Result:</label>
				<select name="result" class="form-control" onChange="validate('setMatchResult',this),getResultFields(this);">
					<option value="">Select Status</option>
						@foreach($results as $key => $result)
						@if($result!="Yet To Be Played" && $result != "Being Played")
							 <option value="{{@$key}}">
							{{$result}}
							</option>
						@endif
						@endforeach
				</select>
			<span class="error"></span>
          </div>
          <div class="form-group result winner">
            <label for="message-text" class="col-form-label">Winner:</label>
            <select name="winner_id" onChange="validate('setMatchResult',this)" class="form-control"><option value="">Select</option></select>
			<span class="error"></span>
          </div>
		    <div class="form-group result">
            <label for="message-text" class="col-form-label">Team 1 Runs:</label>
            <input type="number" name="team_1_runs" min="1" onChange="validate('setMatchResult',this)" class="form-control " />
			<span class="error"></span>
          </div>
		   <div class="form-group result">
            <label for="message-text" class="col-form-label">Team 2 Runs:</label>
            <input type="number" name="team_2_runs" min="2" onChange="validate('setMatchResult',this)" class="form-control " />
			<span class="error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveMatchResult()">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Material form contact -->
  <table class="table table-hover table-striped">
  <tbody>
  <thead>    
    <tr>
		<th></th>
		<th>Team 1</th>
		<th>Team 2</th>
		<th>Date</th>
		<th>Venue</th>
		<th>Result</th>
		<th>Winner</th>
		<th>Action</th>
    </tr>
  </thead>
@if (count($matches) > 0)
   @foreach($matches as $key => $value)
    <tr class="teams" title="Click here to view players">
	   <td>{{$key+1}}</td>
       <td>{{ $value['team1'] }}</td>
       <td valign ="center">{{ $value['team2'] }}</td>
       <td valign ="center">{{ $value['match_date'] }}</td>
       <td valign ="center">{{ $value['venue'] }}</td>
       <td valign ="center">{{ $value['result'] }}</td>
       <td valign ="center">{{ ($value['result']=="Win and loss")?$value['winner']:"" }}</td>
	    <td valign ="center">@if($value['result']=="Yet To Be Played" && $value['match_date']==date('Y-m-d'))<button type="button" data-match-id="{{$value['id']}}" data-team_1="{{ $value['team_id_1'].'-'.$value['team1'] }}" data-team_2="{{ $value['team_id_2'].'-'.$value['team2'] }}" class="btn btn-primary" data-toggle="modal" data-target="#setMatchResult" data-whatever="@mdo">Set Result</button>@endif</td>
    </tr>
    
	@endforeach
	@else
	<tr>
		<td align="center" colspan="7">
			No matches scheduled
		</td>
	</tr>
	@endif
  </tbody>
</table>
</div>
  </body>
</html>
