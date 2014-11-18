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

                                            <div class="call-to-action clearfix">
                                                    <div class="three-fourth">
                                                            <h1>Add Delayed or Canceled train <span class="colored">Message</span></h1>
                                                            <p>If you want to see even more recent work, check out our <a href="#"><span class="colored">Portfolio</span></a> page.</p>
                                                    </div>
                                                    <div class="one-fourth last">
                                                        <a href="special_msg.php" class="button large black full"><span>Add Message</span></a>
                                                    </div>
                                            </div>

                                    </div>
                            </section>
                            
                            <!-- SECTION WRAP -->
			<section class="section-wrap">
				<div class="container">
				
					<h3 class="section-title"><span>Update Data</span></h3>
					
					<!-- SERVICES -->
					<div class="services-wrap">
						<!-- ICON BOX CONTAINER -->
						<div class="ib-container clearfix">
						
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>T</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Update Train</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="update_train.php" class="button medium"><span>Update</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>S</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Update Station</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="update_station.php" class="button medium"><span>Update</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>P</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Update Stop</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="update_stop.php" class="button medium"><span>Update</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth last">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>U</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Update User</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="update_user.php" class="button medium"><span>Update</span></a>
									</div>
								</div>
							</div>
							
						</div>
						<!-- / ICON BOX CONTAINER -->
					</div>
					<!-- / SERVICES -->

				</div>
			</section>
                            
                        <!-- SECTION WRAP -->
			<section class="section-wrap">
				<div class="container">
				
					<h3 class="section-title"><span>Add New Data</span></h3>
					
					<!-- SERVICES -->
					<div class="services-wrap">
						<!-- ICON BOX CONTAINER -->
						<div class="ib-container clearfix">
						
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>T</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Add Train</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="new_train.php" class="button medium"><span>Add</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>S</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Add Station</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="new_station.php" class="button medium"><span>Add</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>P</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Add Stop</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="new_stop.php" class="button medium"><span>Add</span></a>
									</div>
								</div>
							</div>
							
							<div class="one-fourth last">
								<div class="icon-box framed-box text-align-center">
									<div class="icon-font align-center">
										<span>U</span>
									</div>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Add User</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis consequuntur.</p>
										<a href="new_user.php" class="button medium"><span>Add</span></a>
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