<!DOCTYPE html>
<html style="" class=" js no-touch svg inlinesvg svgclippaths placeholder no-ie8compat" lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

	<!-- /* Title */ -->
	<title>SLRTP - Plan Your Journey</title>
	
	<!-- /* css */ -->
	<link rel="stylesheet" href="stylesheets/style.css"/>
	<link rel="stylesheet" href="stylesheets/responsive.css"/>
	<link rel="stylesheet" id="theme" href="stylesheets/theme1.css"/>
	<link rel="stylesheet" href="stylesheets/prettyPhoto.css"/>
	<link rel="stylesheet" href="stylesheets/css.css"/>
                <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
        <link rel="stylesheet" type="text/css" href="stylesheets/rps.css" />
        <link rel="stylesheet" type="text/css" href="stylesheets/timepicki.css"/>
    <script src="http://code.jquery.com/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!--        <script src="javascripts/jquery_003.js"></script>
	<script src="javascripts/jquery_004.js"></script>
	<script src="javascripts/tinynav.js"></script>
	<script src="javascripts/jquery.js"></script>
	<script src="javascripts/custom.js"></script>-->
    <script type="text/javascript">  
        $(document).ready(function() {
            $('table.detail').each(function() {
                var $table = $(this);
                $table.find('.parent').click(function() {
                    $(this).nextUntil('.parent').toggle(); // must use jQuery 1.4 for nextUntil() method
                    $(this).find(".arrow").toggleClass("down");
                });

                var $childRows = $table.find('tbody tr').not('.parent').hide();
                $table.find('button.hide').click(function() {
                    $childRows.hide();
                });
                $table.find('button.show').click(function() {
                    $childRows.show();
                });
            });
        });
    </script> 
        <script type="text/javascript">  
        $(document).ready(function() {
            $('table.detail2').each(function() {
                var $table = $(this);
                $table.find('.parent1').click(function() {
                    $(this).nextUntil('.parent1').toggle(); // must use jQuery 1.4 for nextUntil() method
                    $(this).find(".arrow").toggleClass("down");
                });

                var $childRows = $table.find('tbody tr').not('.parent1').hide();
                $table.find('button.hide').click(function() {
                    $childRows.hide();
                });
                $table.find('button.show').click(function() {
                    $childRows.show();
                });
            });
        });
    </script> 

</head>

<body class="pattern8" data-twttr-rendered="true">

	<!-- PAGE WRAP -->
	<div id="page-wrap" class="wide boxed">

		<!-- HEADER -->
		<header id="header">
			<div class="container clearfix">
			
				<!-- LOGO -->
				<div id="logo">
					<a href="index.html" title="Newa :"><img src="images/logo.png" alt="Newa :"></a>
				</div>
				<!-- / LOGO -->
				
				<!-- NAVIGATION -->
				<nav id="navigation" class="ddsmoothmenu">
					<ul class="l_tinynav1" id="main-menu">
						<li style="z-index: 100;"><a href="index.php"><span>Home</span><img src="" class="downarrowclass" style="border:0;"></a>
						</li>
                                                <?php if(accessble(1)){
                                                    echo "<li style=\"z-index: 99;\"><a href=\"staff.php\"\><span>Staff</span><img src=\"\" class=\"downarrowclass\" style=\"border:0;\"></a></li>";
                                                }
                                                ?>
                                                <li style="z-index: 98;"><a href="contact.php"><span>Contact</span><img src="" class="downarrowclass" style="border:0;"></a>
						</li>
                                                <?php if(!accessble(1)){
                                                    echo "<li style=\"z-index: 97;\"><a href=\"login.php\"\><span>Login</span><img src=\"\" class=\"downarrowclass\" style=\"border:0;\"></a></li>";
                                                }
                                                ?><?php if(accessble(1)){
                                                    echo "<li style=\"z-index: 97;\"><a href=\"logout.php\"\><span>Logout</span><img src=\"\" class=\"downarrowclass\" style=\"border:0;\"></a></li>";
                                                }
                                                ?>
						</ul>
                                </nav>
				<!-- / NAVIGATION -->
				
			</div>
		</header>