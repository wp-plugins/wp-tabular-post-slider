<?php
ob_start();
/*
Plugin Name: WP Tabular Post Slider
Plugin URI: http://hopeadjustor.com/wp-tabular-post-slider
Description: this plugin is used to show your post by category as slider in tabular format.  to use this plugin use shortcode as [TPSBC]
Version: 1.0
Author: Mritunjay Datt Tiwari
Author URI: http://hopeadjustor.com
License: GPL2
*/
?>
<?php
	
	add_action('admin_menu', 'test_plugin_setup_menu'); 
	function test_plugin_setup_menu(){
			add_menu_page( 'TPSBC Settings', 'TPSBC Settings', 'manage_options', 'tpsbc-plugin', 'tpsbc_init' );
			//call register settings function
			add_action( 'admin_init', 'register_tpsbc_settings' );
	}	function tpsbc_scripts_method() {		
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-core', array('jquery'));
		wp_enqueue_script( 'jquery-ui-tabs', array('jquery', 'jquery-ui-core'));

		wp_dequeue_script( 'tpsbc-slider1' );
		wp_enqueue_script('tpsbc-slider1', plugins_url( '/inc/jquery.jcarousel.min.js' , __FILE__ ),array('jquery'),'0.1',true);
		wp_enqueue_script('tpsbc-slider1');
		
		wp_dequeue_script( 'tpsbc-settings' );
		wp_register_script( 'tpsbc-settings', plugins_url( '/inc/settings.js' , __FILE__ ),array('jquery' ),'0.1',true);
		wp_enqueue_script( 'tpsbc-settings' );
	}

	add_action( 'wp_enqueue_scripts', 'tpsbc_scripts_method' );
	// Register style sheet.
	add_action( 'wp_enqueue_scripts', 'register_tpsbc_styles' );
	/**
	* Register style sheet.
	*/
	function register_tpsbc_styles() {

		wp_register_style( 'tpsbc-stylesheet', plugins_url( '/css/jquery-ui.css', __FILE__ ) );
		wp_enqueue_style( 'tpsbc-stylesheet' );
		
		wp_register_style( 'tpsbc-stylesheet1', plugins_url( '/css/style.css', __FILE__ ) );
		wp_enqueue_style( 'tpsbc-stylesheet1' );

	}	
	function register_tpsbc_settings() {
		//register our settings
		register_setting( 'tpsbc-settings-group', 'plugin_options' );
		register_setting( 'tpsbc-settings-group', 'next_nav_text' );
		register_setting( 'tpsbc-settings-group', 'prev_nav_text' );
		register_setting( 'tpsbc-settings-group', 'slider_speed' );
		register_setting( 'tpsbc-settings-group', 'auto_slide' );		register_setting( 'tpsbc-settings-group', 'title_length' );		register_setting( 'tpsbc-settings-group', 'content_length' );		register_setting( 'tpsbc-settings-group', 'custom_css' );
		register_setting( 'tpsbc-settings-group', 'slider_animation' );
	} 	function admin_styles(){?>	<style>	.wrap.tpsbc pre {		margin: 0;		position: absolute;		right: 10px;		text-transform: capitalize;		top: 40px;	}	</style><?php	}	add_action('admin_init', 'admin_styles');
	function tpsbc_init() {
	?>
	<div class="wrap tpsbc">
	<h2>TPSBC Settings</h2>	<pre>if you like this plugin please <a href="http://hopeadjustor.com/" target="_blank">Donate Here</a></pre>
	<form method="post" action="options.php">
    <?php settings_fields( 'tpsbc-settings-group' ); ?>
    <?php do_settings_sections( 'tpsbc-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
			<th scope="row">Select Categories to Show</th>
			<td>
			<?php
				$options = get_option('plugin_options');				if(isset($options)){					$options = get_option('plugin_options');				}				else{					$options ='';				}
			?>
			<?php 				$cat_args = array(					'type'                     => get_post_types( '', 'names' ),					'child_of'                 => 0,					'parent'                   => '',					'orderby'                  => 'name',					'order'                    => 'ASC',					'hide_empty'               => 0,					'hierarchical'             => 1,					'exclude'                  => '',					'include'                  => '',					'number'                   => '',					'taxonomy'                 => 'category',					'pad_counts'               => false 				); 
				$cat_list = get_categories($cat_args );
				echo '<select name="plugin_options[clusters][]" multiple="multiple">
					<option value=""'.(($options['clusters'] == '')? ' selected="Selected"':'').'>Show All</option>';
					foreach($cat_list as $cat_item) {												foreach($options['clusters'] as $key=>$value){						echo $value;
						if ($cat_item->term_id == $value )
						$selected = 'selected="selected"';						echo $selected;						}
						echo '<option value="'.esc_attr($cat_item->term_id).'"'.$selected.'>'.$cat_item->name.'</option>';
					}
				echo '</select>';
			?>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">Next Navigation Text</th>
			<td><input type="text" name="next_nav_text" value="<?php echo esc_attr( get_option('next_nav_text') ); ?>" class="regular-text" /></td>
        </tr>
        <tr valign="top">
			<th scope="row">Next Navigation Text</th>
			<td><input type="text" name="prev_nav_text" value="<?php echo esc_attr( get_option('prev_nav_text') ); ?>" class="regular-text" /></td>
        </tr>
	
		<tr valign="top">
			<th scope="row">Slider Speed</th>
			<td><input type="text" name="slider_speed" value="<?php echo esc_attr( get_option('slider_speed') ); ?>" class="regular-text" /><em>write numbers in millisecond</em></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Animation</th>
			<td><input type="text" name="slider_animation" value="<?php echo esc_attr( get_option('slider_animation') ); ?>" class="regular-text" /><em>use milliseconds as integer </em></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Auto Slide</th>
			<td><input type="text" name="auto_slide" value="<?php echo esc_attr( get_option('auto_slide') ); ?>" class="regular-text" /><em>write here true or false</em></td>
        </tr>				<tr valign="top">			<th scope="row">Title Length</th>			<td><input type="text" name="title_length" value="<?php echo esc_attr( get_option('title_length') ); ?>" class="regular-text" /><em>number of words</em></td>        </tr>				<tr valign="top">			<th scope="row">Content Length</th>			<td><input type="text" name="content_length" value="<?php echo esc_attr( get_option('content_length') ); ?>" class="regular-text" /><em>number of words</em></td>        </tr>				<tr valign="top">			<th scope="row">Custom CSS</th>			<td> <textarea rows="4" cols="50" name="custom_css" class="regular-text"><?php echo esc_attr( get_option('custom_css') ); ?></textarea> <em>write your own css here</em></td>        </tr>
    </table>
    <?php submit_button(); ?>
	</form>
	</div>
<?php }

	function tpsbc_display(){		$next_text=get_option('next_nav_text');		$prev_text=get_option('prev_nav_text');		$slider_speed=get_option('slider_speed');		$auto_slide=get_option('auto_slide');
		$slide_animation=get_option('slider_animation');		$title_length=get_option('title_length');		$content_length=get_option('content_length');		if(!empty($title_length)){			$title_length=get_option('title_length');		}		else{			$title_length=10;		}		if(!empty($content_length)){			$next_text=get_option('content_length');		}		else{			$content_length=40;		}
		if(!empty($next_text)){
			$next_text=get_option('next_nav_text');
		}
		else{
			$next_text="Next";
		}
		if(!empty($prev_text)){
			$prev_text=get_option('prev_nav_text');
		}
		else{
			$prev_text="Prev";
		}
		if(!empty($slider_speed)){
			$slider_speed=get_option('slider_speed');
		}
		else{
			$slider_speed=8000;
		}
		if(!empty($slide_animation)){
			$slide_animation=get_option('slider_animation');
		}
		else{
			$slide_animation='slow';
		}
		
		if(!empty($auto_slide)){
			$auto_slide=get_option('auto_slide');
		}
		else{
			$auto_slide="true";
		}
		$cat_message='';
		//checking for data filter
		if ( isset($_GET['review_cat']) && (trim($_GET['review_cat']) != '') ){
			$cat_id = trim($_GET['review_cat']);
		} else {
			$cat_id = '';
		}
		$cat_list = get_categories( $cat_args );
	?>
	<div class="tab-wrapper" id="tpsbc-tabs">
	<?php $options = get_option('plugin_options'); ?>
	<form name="filterdata" id="filter-frm" method="get" action="<?php get_permalink(); ?>">
		<ul class="tabbernav">
			<?php 
			foreach($options as $key=>$value){
				foreach($value as $key1=>$value1) { ?>
				<li class="<?php echo sanitize_title_with_dashes( get_the_category_by_ID($value1), $unused, $context = 'display' );?>-<?php echo esc_attr($value1) ;?>"><a href="#<?php echo sanitize_title_with_dashes( get_the_category_by_ID($value1), $unused, $context = 'display' );?>-<?php echo esc_attr($value1) ;?>" title="<?php echo sanitize_title_with_dashes( get_the_category_by_ID($value1), $unused, $context = 'display' );?>" ><?php echo get_the_category_by_ID($value1);?></a></li>
			<?php } } ?>
		</ul>
		<?php 
			foreach($options as $key=>$value){
			foreach($value as $key1=>$value1) { 
		?>
		<div class="tabbertab" id="<?php echo sanitize_title_with_dashes( get_the_category_by_ID($value1), $unused, $context = 'display' );?>-<?php echo esc_attr($value1);?>">
				<?php
				$tab_id=sanitize_title_with_dashes( get_the_category_by_ID($value1), $unused, $context = 'display' ).'-'.$value1.'-review-slider';
					echo $cat_item->term_id ;
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$tpsbc_args = array(
					'post_type' => get_post_types( '', 'names' ),
					'cat' => $value1,
					//'paged' => $paged,
					'orderby' => 'date',
					'posts_per_page' => -1,
					'order'     => 'DESC'
					);					
					$title=get_the_title();
					$tpsbc_query = new WP_Query($tpsbc_args);
					echo '<div class="slider-wrapper">
					<div class="slider-controls">
					<a href="#" class="control-prev">'.$prev_text.'</a>
					<a href="#" class="control-next">'.$next_text.'</a>
					</div>
					';
					echo '<div class="slider-div" id="'.$tab_id.'">
					<ul>';
					while ($tpsbc_query->have_posts()) : $tpsbc_query->the_post();
					echo '<li><div class="review-slide">';					echo '<h3 class="slider-title">'.wp_trim_words(get_the_title(), $title_length, '...' ).'</h3>';
					echo '<p>'.wp_trim_words(get_the_content(), $content_length, '<a href="'. get_permalink() .'"> ...Read More</a>' ).'</p>';
					echo '</div></li>
					';
					endwhile;
					echo '</ul>					
					<!-- Pagination -->
					<div class="jcarousel-pagination">
					<!-- Pagination items will be generated in here -->
					</div>
					</div></div>';
					/*
					$big = 999999999; // need an unlikely integer
					echo '<div id="pagination">';
					echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $tpsbc_query->max_num_pages,
					'show_all' => 0
					) );
					echo '</div>';
					*/
					// Reset Post Data
					?>
					<script>
						jQuery(function() {
							var jcarousell = jQuery("#<?php echo $tab_id; ?>");
							jcarousell.on('jcarousel:reload jcarousel:create', function () {
								var width = jcarousell.innerWidth();
								jcarousell.jcarousel('items').css('width', width + 'px');
							})
							.jcarousel({
								wrap: 'circular',
								animation: <?php echo $slide_animation; ?>
							})
							.jcarouselAutoscroll({
								interval: <?php echo $slider_speed; ?>,
								target: '+=1',
								autostart: <?php echo $auto_slide; ?>
							});
						});
					</script>
					<?php
					wp_reset_postdata();
				?>
				</div><!-- close tab-->
			<?php } } ?>
		</form>
	</div>
<?php
	}	function write_custom_css()	{		?>		<style>			<?php echo get_option('custom_css'); ?>		</style>		<?php	}	add_action('wp_head', 'write_custom_css');
	add_shortcode('TPSBC','tpsbc_display');
?>	