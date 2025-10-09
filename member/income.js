$(document).ready(function(){
	dfg=function(mm){
		var req=$.ajax({
			method:"GET",
			url:mm,
			data:{user:"TestUser"},
			dataType: "json",
			timeout: 10000
		});
		req.done(function(data){
			console.log("Success! Response:", data);
			if (data && typeof data === 'object') {
				for(var result in data){
					if (data.hasOwnProperty(result)) {
						console.log("Setting " + result + " = " + data[result]);
						$("#"+result).text(data[result]);
					}
				}
			} else {
				console.error("Invalid data format received:", data);
				setFallbackValues();
			}
		});
		req.fail(function(xhr, status, error) {
			console.error("AJAX Error:", status, error);
			console.error("Response:", xhr.responseText);
			setFallbackValues();
		});
	}
	
	function setFallbackValues() {
		console.log("Setting fallback values");
		$("#FinalAmount").text("0.00");
		$("#TotaoIn").text("0.00");
		$("#TotaoOut").text("0.00");
		$("#shopping").text("0.00");
		$("#PoolIncome").text("0.00");
		$("#PoolReferIncome").text("0.00");
		$("#DailyROIIncome").text("0.00");
		$("#ReferGenerationIncome").text("0.00");
		$("#GenerationROIIncome").text("0.00");
		$("#SpecialReferSales").text("0.00");
		$("#PremiumClubProfit").text("0.00");
		$("#VipClubProfit").text("0.00");
		$("#RankRewardIncentive").text("0.00");
		$("#TotalWithdraw").text("0.00");
		$("#CurrentRank").text("No Rank");
	}
	
	dfg("income_return.php");
});
