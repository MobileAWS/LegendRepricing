<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package GeneratePress
 */
?>

	</div><!-- #content -->
</div><!-- #page -->
<footer>
	<div class="container">
		<div class="btn-backTotop"> <a href="#home" title="Back To Top" class="scroll"><i class="fa fa-chevron-up"></i>top</a> </div>
		<div class="row box-footer">
			<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 box-aboutUs">
				<h6>legend repricing</h6>
				<p>The Best Repricing software on the market from a firm that listens to its customers. Capture market share and profits now you can have both volume and profits.</p>
			</div>
			<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
				<h5>Quick links</h5>
				<ul class="list-footermenu">
					<li><a href="#" title="About Us">About us</a></li>
					<li><a href="#" title="Product Help">Product Help</a></li>
					<li><a href="#" title="Contact Us">Contact Us</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<p>copyright &copy; Legend Repricing <?php echo date('Y'); ?></p>
		</div>
	</div>
	</div>
</footer>
<?php /*?><?php do_action('generate_before_footer'); ?>
<div <?php generate_footer_class(); ?>>
	<?php 
	do_action('generate_before_footer_content');
	
	// Get how many widgets to show
	$widgets = generate_get_footer_widgets();
	
	if ( !empty( $widgets ) && 0 !== $widgets ) : 
	
		// Set up the widget width
		$widget_width = '';
		if ( $widgets == 1 ) $widget_width = '100';
		if ( $widgets == 2 ) $widget_width = '50';
		if ( $widgets == 3 ) $widget_width = '33';
		if ( $widgets == 4 ) $widget_width = '25';
		if ( $widgets == 5 ) $widget_width = '20';
		?>
		<div id="footer-widgets" class="site footer-widgets">
			<div class="inside-footer-widgets grid-container grid-parent">
				<?php if ( $widgets >= 1 ) : ?>
					<div class="footer-widget-1 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_1_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_1_tablet_width', '50' ); ?>">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-1')): ?>
							<aside class="widget inner-padding widget_text">
								<h4 class="widget-title"><?php _e('Footer Widget 1','generate');?></h4>			
								<div class="textwidget">
									<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 1.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
									<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
								</div>
							</aside>
						<?php endif; ?>
					</div>
				<?php endif;
				
				if ( $widgets >= 2 ) : ?>
				<div class="footer-widget-2 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_2_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_2_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-2')): ?>
						<aside class="widget inner-padding widget_text">
							<h4 class="widget-title"><?php _e('Footer Widget 2','generate');?></h4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 2.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif;
				
				if ( $widgets >= 3 ) : ?>
				<div class="footer-widget-3 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_3_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_3_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-3')): ?>
						<aside class="widget inner-padding widget_text">
							<h4 class="widget-title"><?php _e('Footer Widget 3','generate');?></h4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 3.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif;
				
				if ( $widgets >= 4 ) : ?>
				<div class="footer-widget-4 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_4_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_4_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-4')): ?>
						<aside class="widget inner-padding widget_text">
							<h4 class="widget-title"><?php _e('Footer Widget 4','generate');?></h4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 4.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif;
				
				if ( $widgets >= 5 ) : ?>
				<div class="footer-widget-5 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_5_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_5_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-5')): ?>
						<aside class="widget inner-padding widget_text">
							<h4 class="widget-title"><?php _e('Footer Widget 5','generate');?></h4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 5.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	<?php
	endif;
	do_action('generate_after_footer_widgets');
	?>
	<footer class="site-info" itemtype="http://schema.org/WPFooter" itemscope="itemscope">
		<div class="inside-site-info grid-container grid-parent">
			<?php do_action( 'generate_credits' ); ?>
		</div>
	</footer><!-- .site-info -->
	<?php do_action( 'generate_after_footer_content' ); ?>
</div><!-- .site-footer --><?php */?>

<?php wp_footer(); ?>
<script type="text/javascript" language="javascript">
		jQuery(window).ready(function(){
		jQuery(".scroll").click(function(event) {
			jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top }, 500);
		});
	});
</script>
</body>
</html>