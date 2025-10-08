$(document).ready(function(){
	dfg=function(mm){
		var req=$.ajax({
			method:"GET",
			url:mm,
			data:{user:"TestUser"}
		});
		req.done(function(msg){
			console.log(msg);
			var outpu=JSON.parse(msg);
			for(result in outpu){
				console.log(outpu[result]);
				console.log(result);
				// Special handling for CurrentRank (no $ prefix needed)
				if(result === 'CurrentRank') {
					$("#"+result).text(outpu[result]);
				} else {
					$("#"+result).text(outpu[result]);
				}
			}
			//dfg();
		});
	}
	
	dfg("income_return.php");
});
