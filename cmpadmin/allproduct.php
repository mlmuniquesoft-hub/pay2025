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
												<p style="color: red;font-size:16px;"><?php echo isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; ?></p> 	  	
												<p style="color: green;font-size:16px;"><?php echo isset($_SESSION['msg1']) ? $_SESSION['msg1'] : ''; ?></p> 	  	
														<div class="box-body table-responsive">
                   <table  id="example1" class="table  table-bordered ">
    <thead>
	
    <tr>
        <th>Picture</th>
		<th>Name</th>
		<th>Stock</th>
		<th>P.Price</th>
		<th>S.Price</th>
		<th>Offer</th>
	
		<th>D.Price</th>
		<th>S.Cost</th>
		<th>total S.Cost</th>
		<th>Profit</th>
       
		<th>Status</th>
        <th>Delete</th>
    </tr>
    </thead>
	    <tbody>
	       <?php 
		   $tsCost=0;
		   $prft=0;
			  $query=$mysqli->query("SELECT * FROM product ORDER BY serial DESC");
			  while($product=mysqli_fetch_object($query)){ 
		   ?>

    <tr>
        <td><img  class="img-thumbnail" width="50px" src="../nzproducts/<?php echo $product->img1; ?>" alt=""></td>
		<td><?php echo $product->name; ?></td>
		

				
	
		
		<td class="center" width="">
				<form action="product_update.php" method="POST">
				<input type="number" style="display: none;" name="serial" value="<?php echo $product->serial; ?>"/>
				<input type="number"  width="" name="stock"  class="form-control" value="<?php echo $product->stock; ?>" /> 
				<input style="display:none;" name="stockval" type="submit" />
				</form>	
        </td class="center" width="">
		<td>
				<form action="price_update.php" method="POST">
				<input type="number" style="display: none;" name="serial" value="<?php echo $product->serial; ?>"/>
				<input type="number"  width="" name="price"  class="form-control" value="<?php echo $product->price; ?>" /> 
				<input type="number" style="display: none;" width="" name="Sprice"  class="form-control" value="<?php echo $product->sale_price; ?>" /> 
				<input type="number" style="display: none;" width="" name="cost"  class="form-control" value="<?php echo $product->cost; ?>" /> 
				<input style="display:none;" name="priceval" type="submit" />
				</form>	
		
		</td>
		<td>
				<form action="salesprice_update.php" method="POST">
				<input type="number" style="display: none;" name="serial" value="<?php echo $product->serial; ?>"/>
				<input type="number"  width="" name="Sprice"  class="form-control" value="<?php echo $product->sale_price; ?>" /> 
				<input type="number" style="display: none;" width="" name="price"  class="form-control" value="<?php echo $product->price; ?>" /> 
				<input type="number" style="display: none;" width="" name="cost"  class="form-control" value="<?php echo $product->cost; ?>" /> 
				<input style="display:none;" name="Spriceval" type="submit" />
				</form>	
		
		</td>
		
		<td class="center"  width="">
		<?php //if($product->offer==1){echo $product->offer_value."%";} ?>
		
		<form action="pro_of_up_act.php" method="POST">
		<select class="form-control"   width="" name="offer" >
		<option value="1" <?php if($product->offer==1){echo "selected";} ?> >Yes</option>
		<option value="0" <?php if($product->offer==0){echo "selected";} ?> >No</option>
		</select>
				<input type="number" hidden name="prods" value="<?php echo $product->serial; ?>"/>
				<input type="number"  width="10%" name="offv"  class="form-control" value="<?php echo $product->offer_value; ?>" /> 
				<input hidden name="offerval" type="submit" />
			</form>
        </td>				
		<td><?php echo $product->discount_price.$bdt; ?></td>
       <td class="center" width="">
				<form action="cost_update.php" method="POST">
				<input type="number" style="display: none;" name="serial" value="<?php echo $product->serial; ?>"/>
				<input type="number"  width="" name="cost"  class="form-control" value="<?php echo $product->cost; ?>" /> 
				<input style="display:none;" name="costval" type="submit" />
				</form>	
		</td>
       <td><?php echo $product->cost*$product->stock.$bdt; $tsCost=$tsCost+($product->cost*$product->stock);?></td>
		<td><?php echo $profit=$product->profit*$product->stock.$bdt; $prft=$prft+$profit; ?></td>
		<td class="center">
		<a href="product_chk.php?active=<?php echo $product->chk; ?>&prodser=<?php echo $product->serial; ?>"><?php if($product->chk==1){echo"<span class='label-success label label-default'>Active</span>";}else{echo"<span class='label-danger label label-default'>Inactive</span>";} ?></a>
            
        </td>
		<td class="center" width="">
			<a class="label label-warning" href="product_del.php?id=<?php echo $product->serial; ?>">Delete</a>
        </td>
    </tr>
  
					<?php } ?>
					
<tfoot>	
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><b>Total- <?php echo $tsCost.$bdt;?></b></td>
<td><b>Total- <?php echo $prft.$bdt;?></b></td>
<td></td>
<td></td>
</tr>
</tfoot>                </tbody>
                    </table>
                </div>
												
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
