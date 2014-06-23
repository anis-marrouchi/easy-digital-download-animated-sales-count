<?php
/**
 * Plugin Name: Twittstrap Count up
 * Plugin URI: http://twittstrap.com
 * Description: Counting up.
 * Version: 1.0
 * Author: Tarek Akrout and Anis Marrouchi
 * Author URI: http://twittstrap.com
 * License:  GPL2
 */
 function get_edd_sales_count()
 {
	 global $wpdb;
	$sales = array();
$meta_key = '_edd_download_sales';//set this to your custom field meta key
$sales = $wpdb->get_col($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s", $meta_key));
return  array_sum( $sales );

 }
 function display_counter()
 {
	?>
    <div class="counter-section"><span class="count_up" id="countUp">0</span></div>
	<script async type="text/javascript">

    // set countUp options
    var options = {
        useEasing : true, // toggle easing
        useGrouping : true, // 1,000,000 vs 1000000
        separator : ',', // character to use as a separator
        decimal : '.', // character to use as a decimal
    }
    var useOnComplete = false;
    var useEasing = true;
    var useGrouping = true;
    
    // create instance
    jQuery(document).ready(function () {
        // fire animation
        //var element = document.querySelector('#countUp');
        var demo = new countUp("countUp", 0, <?php  echo get_edd_sales_count() ?>, 0, 4, options);
        demo.start();
	});
		</script>
        <?php
	wp_enqueue_style( 'twittstrap-countup-css', plugin_dir_url( __FILE__ )."css/countup.css" );
	wp_enqueue_script( 'twittstrap-countup-js', plugin_dir_url( __FILE__ ). "js/countUp.js", array(), '1.0.0', true );
		
 }
 function display_odometer()
 {
	 ?>
     <h1 class="counter-section"><span id="odometer" class="odometer" style="font-size:38px;line-height:40px"></span></h1>
     <script async type="text/javascript">
	 var el = document.querySelector('.odometer');
jQuery(document).ready(function () {
odometer = new Odometer({
  el: el,
  value: 0,

  // Any option (other than auto and selector) can be passed in here
    format: '(dd,ddd)', // Change how digit groups are formatted, and how many digits are shown after the decimal point
  duration: 1000, // Change how long the javascript expects the CSS animation to take
  theme: 'train-station', // Specify the theme (if you have more than one theme css file on the page)
  //animation: 'count' // Count is a simpler animation method which just increments the value,
                     // use it when you're looking for something more subtle.
});
setTimeout(function(){
    el.innerHTML = <?php  echo get_edd_sales_count() ?>;
}, 1000);
								 });
	 </script>
     <?php
	 wp_enqueue_style( 'twittstrap-odometer-css', plugin_dir_url( __FILE__ )."css/themes/odometer-theme-train-station.css" );
	wp_enqueue_script( 'twittstrap-odemeter-js', plugin_dir_url( __FILE__ ). "js/odometer.js", array(), '1.0.0', true );
 }
//add_action( 'admin_notices', 'display_odometer' );
add_shortcode('twittstrap_display_counter', 'display_counter');
add_shortcode('twittstrap_display_odometer', 'display_odometer');