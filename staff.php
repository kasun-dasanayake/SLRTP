<?php require_once("initialize.php"); ?>
<?php before_every_protected_page(); ?>
<?php require_once('functions/header.php');?>
<?php if(isset($_SESSION['msg'])){
            $message = $_SESSION['msg'];
        } else{
            $message = "";
        }
    ?>

<section style="min-height: 200px;" id="content" class="right-sidebar clearfix">
		
			<!-- INTRO -->
			<header class="page-heading clearfix">
				<div class="container">
				
					<!-- PAGE TITLE -->
					<div id="page-title">
						<h1 class="page-title">Staff Area</h1>
					</div>
					<!-- / PAGE TITLE -->
					
				</div>
                            
			</header>
			<!-- / INTRO -->
			
			<div class="container">
                            
                            <div class="page-description">
                                <?php
                                        if($message != "") {
                                            $u = "<div class=\"success-box\" style=\"width: 700px;margin: auto;\"><div class=\"message-box\" style=\"padding: 5px;\">
                                                  <p>". h($message) ."</p></div></div>";
                                            echo $u;
                                            $_SESSION['msg']="";
                                      }
                                    ?>
                                </div>
                            
                            <section class="section-wrap">
                                    <div class="container">
                                        
                                            <h3 class="section-title"><span>Add New Message</span></h3>

                                            <div class="call-to-action clearfix" style="width: 40%; position: relative; float: left; margin-left: 15px;">
                                                    <div class="three-fourth"  style="width: 68%;">
                                                            <h1 style="margin-top: 10px;">Report Delay <span class="colored">Train</span></h1>
                                                             </div>
                                                    <div class="one-fourth last" style="width: 28%;">
                                                        <a href="special_msg.php" class="button large black full"><span>Report</span></a>
                                                    </div>
                                            </div>
                                            <div class="call-to-action clearfix" style="width: 40%; position: relative; float: left; margin-left: 75px;">
                                                    <div class="three-fourth" style="width: 68%;">
                                                            <h1 style="margin-top: 10px;">Report canceled <span class="colored">Train</span></h1>
                                                             </div>
                                                    <div class="one-fourth last" style="width: 28%;">
                                                        <a href="special_msg.php" class="button large black full"><span>Report</span></a>
                                                    </div>
                                            </div>

                                    </div>
                            </section>
                            
                            <!-- SECTION WRAP -->
			<section class="section-wrap" style="margin-top: 220px;">
				<div class="container">
				
					<h3 class="section-title"><span>Data Operating Area</span></h3>
					
					<!-- SERVICES -->
					<div class="services-wrap">
						<!-- ICON BOX CONTAINER -->
						<div class="ib-container clearfix">
						
							<div class="one-fourth">
                                                            <div class="icon-box framed-box text-align-center">
                                                                <div class="icon-box-content">
                                                                    <div class="icon-image">
                                                                        <img width="100px" height="100px" src="images/icons/train.png" alt="" style="padding: 0px 30px;"/>
                                                                    </div>
                                                                        <h3 class="icon-box-title">Trains</h3>
                                                                        <p>Trains count: <?php echo count(trains_list()); ?></p>
                                                                        <a href="new_train.php" class="button medium" style="width: 100px;"><span>Create</span></a><br/>
                                                                        <a href="read_train.php" class="button medium" style="width: 100px;"><span>Read</span></a><br/>
                                                                        <a href="update_train.php" class="button medium" style="width: 100px;"><span>Update</span></a><br/>
                                                                        <a href="delete_train.php" class="button medium" style="width: 100px;"><span>Delete</span></a>
                                                                </div>
                                                            </div>
							</div>
							
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-box-content">
                                                                            <div class="icon-image">
                                                                                <img width="100px" height="100px" src="images/icons/stations1.png" alt="" style="padding: 0px 30px;"/>
                                                                            </div>
										<h3 class="icon-box-title">Stations</h3>
										<p>Stations count: <?php echo count(stations_list()); ?></p>
										<a href="new_station.php" class="button medium" style="width: 100px;"><span>Create</span></a><br/>
										<a href="read_station.php" class="button medium" style="width: 100px;"><span>Read</span></a><br/>
										<a href="update_station.php" class="button medium" style="width: 100px;"><span>Update</span></a><br/>
                                                                                <a href="delete_station.php" class="button medium" style="width: 100px;"><span>Delete</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-box-content">
                                                                            <div class="icon-image">
                                                                                <img width="100px" height="100px" src="images/icons/stops.png" alt="" style="padding: 0px 30px;"/>
                                                                            </div>
										<h3 class="icon-box-title">Stops</h3>
										<p>Stops count: <?php echo count(stops_list()); ?></p>
										<a href="new_stop.php" class="button medium" style="width: 100px;"><span>Create</span></a><br/>
										<a href="read_stop.php" class="button medium" style="width: 100px;"><span>Read</span></a><br/>
										<a href="update_stop.php" class="button medium" style="width: 100px;"><span>Update</span></a><br/>
                                                                                <a href="delete_stop.php" class="button medium" style="width: 100px;"><span>Delete</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth last">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-box-content">
                                                                            <div class="icon-image">
                                                                                <img width="100px" height="100px" src="images/icons/tickets.png" alt="" style="padding: 0px 30px;"/>
                                                                            </div>
										<h3 class="icon-box-title">Ticket Prices</h3>
										<p>Users count: <?php echo count(users_list()); ?></p>
                                                                                <a href="new_ticketPrices.php" class="button medium" style="width: 100px;"><span>Create</span></a><br/>
										<a href="read_ticketPrices.php" class="button medium" style="width: 100px;"><span>Read</span></a><br/>
										<a href="update_sticketPrices.php" class="button medium" style="width: 100px;"><span>Update</span></a><br/>
                                                                                <a href="delete_ticketPrices.php" class="button medium" style="width: 100px;"><span>Delete</span></a>
									</div>
								</div>
							</div>
							
						</div>
						<!-- / ICON BOX CONTAINER -->
					</div>
					<!-- / SERVICES -->

				</div>
			</section>
				<!-- PAGE DESCRIPTION -->
				
			</div>
		
		</section>
<?php require_once('functions/footer.php');?>