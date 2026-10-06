<?php
    get_header();
?>
<section id="main">

	<div class="main-container">
		<div class="row">
			<div class="twelve columns main-container-wrapper">
		    <?php
		        function do_nothing( $sender ){}
		        $layout = new LBSidebarResizer( 'front_page' );
		        $layout -> render_frontend( 'do_nothing' );
		    ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>