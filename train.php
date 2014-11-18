<?php require_once("initialize.php"); ?>
<?php block_blacklisted_ips(); 
    if(!isset($_GET['no'])){
        redirect_to('index.php');
    } else{
        $sn = train_for_no($_GET['no']);
        if(!$sn){
            redirect_to('index.php');
        } else{
            $train = mysql_fetch_array($sn);
        }
    }
?>
<?php require_once('functions/header.php');?>

<section style="min-height: 200px;" id="content" class="right-sidebar clearfix">
		
			<!-- INTRO -->
			<header class="page-heading clearfix">
				<div class="container">
				
					<!-- PAGE TITLE -->
					<div id="page-title">
						<h1 class="page-title"><?php echo $train['name'];?> Train</h1>
					</div>
					<!-- / PAGE TITLE -->
					
				</div>
                            
			</header>
			<!-- / INTRO -->
			
			<div class="container">
		
				<!-- PAGE DESCRIPTION -->
				<div class="page-description">
					<h1>Pricing Tables</h1>
					<hr>
					<p>pick a plan that best fits your needs</p>
				</div>
				<!-- / PAGE DESCRIPTION -->
                                <h5>Default Box</h5>
					
					<div class="one-half">
						<div class="framed-box clearfix">
							<div class="framed-box-content">
								<h1>This is a headline</h1>
								<p>Lorem ipsum dolor sit amet, dionysiadis eum istam definisti quis nudus iuvenem quasi certum ait cumque persetur sic. Dulcius populo alterius quaestionis studio percipiendum venisset.</p>
								<a href="#" class="button medium"><span>Button</span></a>
							</div>
						</div>
					</div>
			</div>
		
		</section>
		<!-- / CONTENT -->
<?php require_once('functions/footer.php');?>