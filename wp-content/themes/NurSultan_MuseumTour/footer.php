</div>
<footer id="footer">
<div id="copyright">
	Copyright 
&copy; <?php echo esc_html( date_i18n( __( 'Y', 'blankslate' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
	- Все права защищены
</div>

<div id="social">
	<?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ) ); ?>
</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>