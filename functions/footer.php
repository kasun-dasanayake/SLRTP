
<!-- FOOTER -->
    <footer id="footer">
            <div class="container clearfix">

                    <!-- TEXT WIDGET -->
                    <div class="one-fourth">
                            <section class="widget text-widget clearfix">
                                    <h3 class="widget-title">About Us</h3>
                                    <p>Newa is a clean, creative and responsive HTML site template with tons of features offering the best way to bring your</p><a href="#" class="goto">Read more</a>
                            </section>
                    </div>
                    <!-- / TEXT WIDGET -->

                    <!-- FLICKR WIDGET -->
                    <div class="one-fourth">
                            <section class="widget flickr-widget clearfix">
                                    <h3 class="widget-title">Flickr Stream</h3>
                                    <ul class="flickr-wrap"></ul>
                            </section>
                    </div>
                    <!-- / FLICKR WIDGET -->

                    <!-- TWITTER WIDGET -->
                    <div class="one-fourth">
                            <section class="widget twitter-widget clearfix">
                                    <h3 class="widget-title">Latest Tweets</h3>
                                    <div class="twitter-wrap"></div>
                                    <a href="https://twitter.com/envato" class="twitter-follow-button" data-show-count="false">Follow @envato</a>
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="../../platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </section>
                    </div>
                    <!-- / TWITTER WIDGET -->

                    <!-- CONTACT INFO WIDGET -->
                    <div class="one-fourth last">
                            <section class="widget contact-info-widget clearfix">
                                    <h3 class="widget-title">Contact Info</h3>
                                    <p class="contact-icon-address">
                                            <span></span>
                                            PO Box 12345, Street Name
                                            <br>
                                            City, Country 12345
                                    </p>
                                    <p class="contact-icon-phone">
                                            <span></span>
                                            +00 (0) 123 456 789
                                    </p>
                                    <p class="contact-icon-fax">
                                            <span></span>
                                            +00 (0) 123 456 789
                                    </p>
                                    <p class="contact-icon-mail">
                                            <span></span>
                                            <a href="mailto:email@domain.com">email@domain.com</a>
                                    </p>
                            </section>
                    </div>
                    <!-- / CONTACT INFO WIDGET -->

            </div>
    </footer>
    <!-- / FOOTER -->

    <footer id="footer-bottom" class="clearfix">
			<div class="container">
			
				<!-- COPYRIGHT -->
				<p class="copyright">&copy; 2014 <a href="#">SLRTP</a>. All rights reserved.</p>
				<!-- / COPYRIGHT -->
				
				<!-- FOOTER NAVIGATION -->
				<nav class="footer-menu">
					<ul>
						<li><a href="#">Legal Notice</a></li>
						<li><a href="#">Terms</a></li>
						<li><a href="#">Privacy Policy</a></li>
					</ul>
				</nav>
				<!-- / FOOTER NAVIGATION -->

				<!-- FOOTER SOCIAL -->
				<ul class="social">
					<li><a href="#" class="facebook" title="Facebook">Facebook</a></li>
					<li><a href="#" class="twitter" title="Twitter">Twitter</a></li>
					<li><a href="#" class="googleplus" title="Google+">Google+</a></li>
					<li><a href="#" class="rss" title="RSS">RSS</a></li>
				</ul>
				<!-- / FOOTER SOCIAL -->
				
			</div>
		</footer>

<div style="display: block;" id="scroll-top">
			<a href="#top">Back to top</a>
		</div>
		<!-- / SCROLL TO TOP -->
		
	</div>
	<!-- /* Themes Panel */ -->
	<link rel="stylesheet" href="stylesheets/themes_panel.css">
	<script src="javasripts/jquery_011.js"></script>
	<script src="javasripts/themes_panel.js"></script>

</body>
<script src="javascripts/timepicki.js">
        </script>
        <script>
            $("input#a").timepicki();
        </script>
</html>
<?php 
global $connection;
if($connection){
    mysql_close($connection);
}

?>