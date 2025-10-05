<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';		
	}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $Adminnb; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/checkbox3.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="lib/css/select2.min.css">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
</head>

<body class="flat-blue">
    <div class="app-container expanded">
        <div class="row content-container">
		<?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
					<?php require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Products
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body" style="background-color: azure;">
										<div class="row">
											<div class="col-lg-12">
												<p style="color: red;font-size:16px;"><?php echo $_SESSION['msg']; ?></p> 	  	
												<p style="color: green;font-size:16px;"><?php echo $_SESSION['msg1']; ?></p> 	  	
<form class="form-horizontal" action="product_act.php" method="POST" enctype="multipart/form-data" style="margin-top:20px;">
 <table class="table table-bordered table-responsive">
 
			<div class="form-group">
				<h5 style="margin: 0; color: red; text-align: center;"><?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];}?></h5>
				<h5 style="margin: 0; color: green; text-align: center;"><?php if(isset($_SESSION['msgs'])){echo $_SESSION['msgs'];}?></h5>
			</div> 
    
		
 
	
   	
	
	<tr>
       <td> <label for="exampleInputmodel" style="margin-left:15px;">Name</label><font color="red">*</font></td>
		<td>
			<input type="text" class="form-control" name="Name" id="exampleInputEmail1" placeholder="Product/Service Name">
	   </td>
    </tr>
	
	<tr>
       <td> <label for="exampleInputmodel" style="margin-left:15px;">Model No</label></td>
		<td>
			<input type="text" class="form-control" name="model" id="exampleInputEmail1" placeholder="Model No">
	   </td>
    </tr>
	

	<tr>
      <td>
		<label for="exampleInputEmail1" style="margin-left:15px;">Image 1: 500x500</label><font color="red">*</font></td>
       <td>
	   <input class="control-label" type="file" name="img1" id="exampleInputfile" placeholder="file" >
	   
		<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="margin-top:6px">
			   Add More Images
		</button>
			<div class="collapse" id="collapseExample">
			  <div class="well">
				
						  <div class="form-group">
						   <div class="col-sm-2">
							<label for="exampleInputEmail1" style="margin-left:15px;">Image 2: 500x500</label>
							 </div>
							  <div class="col-sm-10">
							<input type="file" class="control-label" name="img2" id="exampleInputfile" placeholder="file">
						   </div>
						  </div>
						 
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample" style="margin-top:15px;">
					    Add More Images
						</button>
				
			  </div>
			</div>
			
			<div class="collapse" id="collapseExample2">
			  <div class="well">
					<div class="form-group">
					 <div class="col-sm-2">
					<label for="exampleInputEmail1" style="margin-left:15px;">Image 3: 500x500</label>
					 </div>
							  <div class="col-sm-10">
					<input type="file" class="control-label" name="img3" id="exampleInputfile" placeholder="file" >
					 </div>
					</div>
					<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample" style="margin-top:6px;">
					    Add More Images
					</button>
				
			  </div>
			</div>
			<div class="collapse" id="collapseExample3">
			  <div class="well">
				
					
						  <div class="form-group">
						   <div class="col-sm-2">
							<label for="exampleInputEmail1" style="margin-left:15px;">Image 4: 500x500</label>
							 </div>
							  <div class="col-sm-10">
							<input type="file" class="control-label" name="img4" id="exampleInputfile" placeholder="file">
						   </div>
						  </div>
						 <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
					   Hide
					</button>
				
			  </div>
			</div>
	   </td>
    </tr>
	
	<tr>
      <td> <label for="exampleInputBrand" style="margin-left:15px;">Short Description</label><font color="red">*</font></td>
       <td>
	   <textarea type="text" class="form-control" placeholder="Text here" rows="3" name="info" ></textarea>
	   </td>
    </tr>
    
	<tr> 
		<td> <label for="exampleInputPrice" style="margin-left:15px;">Purchase Price</label> <font color="red">*</font></td>
		<td><input type="number" class="form-control" name="oPrice" id="exampleInputPrice" placeholder="Price(Purchase)"></td>
	</tr>
	
	<tr>
		<td><label for="exampleInputPrice"style="margin-left:15px;">Sale Price</label><font color="red">*</font></td>	
		<td><input type="number" class="form-control" name="sPrice" id="exampleInputPrice" placeholder="Price(sales)"></td>	
	</tr>
	<tr>
		<td><label for="exampleInputPrice"style="margin-left:15px;">Service Cost</label><font color="red">*</font></td>	
		<td><input type="number" class="form-control" name="sCost" id="exampleInputPrice" placeholder="Cost(Service)"></td>	
	</tr>
	

	<tr>
		<td><label for="exampleInputAvailability"style="margin-left:15px;">Stock</label><font color="red">*</font></td>
		<td> <input type="number" class="form-control" name="stock" id="exampleInputAvailability" placeholder="Stock"></td>
	</tr>
	    <tr>
      <td> <label for="exampleInputBrand" style="margin-left:15px;">Offer</label></td>
      <td> 
	  <label class="radio-inline">
				 <input type="radio" name="offer" value="1"> Yes</label>
					<label class="radio-inline">
				 <input type="radio" name="offer" checked value="0" /> NO </label>
	  <input type="text" class="form-control" name="offerV" placeholder="Enter offer %">
			</td>
    </tr>
	<tr>
		<td>  <label for="exampleInputCondition"style="margin-left:15px;">Placement</label></td>
		<td> <select class="form-control" name="place">
			<option selected value="3">Best Seller</option>
		<option value="1">Featured </option>
		<option value="2">Latest </option>
	
		<option value="4">Spacial</option>
		
		</select> </td>
	</tr>
	
    </table>
                              
	 <div class="row">
			<div class="col-md-8">
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-info" style="margin-bottom:10px">
					Submit
				</button>
			</div>
		</div>   
</form>
												<!-- /.form -->
											</div>
											<!-- /.col-lg-12 (nested) -->
										</div>
										<!-- /.row -->
									</div>
									<!-- /.panel-body -->
								</div>
								<!-- /.panel -->
                            </div>
                        </div>
                    </div>
					
					
			<?php 
			require_once('footer.php');
			unset($_SESSION['msg']);
			unset($_SESSION['msg1']);
			
			?>
        <div>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
            <script>
				$(document).ready(function(){
					$(".uupp").on("keyup", function(){
						var vals=$(this).val();
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"package"}
							});
						}
						
					});
					$(".upgg").on("click", function(e){
						//e.preventDefault();
						//e.stopPropagation();
						var vals=$(this).attr("data-vals");
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						if(vals=="Delete"){
							$(".del"+srl).hide();
						}
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"package"}
							});
						}
					});
					$(".ssdd").on("change", function(){
						var vals=$(this).val();
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"package"}
							});
						}
					})
				});
			
			</script>
            <script type="text/javascript" src="lib/js/Chart.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.matchHeight-min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="lib/js/dataTables.bootstrap.min.js"></script>
            <script type="text/javascript" src="lib/js/select2.full.min.js"></script>
            <script type="text/javascript" src="lib/js/ace/ace.js"></script>
            <script type="text/javascript" src="lib/js/ace/mode-html.js"></script>
            <script type="text/javascript" src="lib/js/ace/theme-github.js"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>
            <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
