<?php //get_header(); ?>
<main id="content">
<header class="header">
	<a href="http://wordress.nurbeklu.beget.tech/">Главная</a>
	<?php get_sidebar(); ?>
<div class="archive-meta"><?php if ( '' != the_archive_description() ) { echo esc_html( the_archive_description() ); } ?></div>
</header>
<h1 class="cat-title"><?php single_term_title(); ?></h1>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php endwhile; endif; ?>
<?php get_template_part( 'nav', 'below' ); ?>
</main>
<?php get_footer(); ?>




<style type="text/css">
	.header {
		padding: 40px 30px 20px 30px;
		display: flex;
	}
	.cat-title {
		text-align: center;
	}
	#primary > ul {
		list-style: none;
		margin: 0;
		margin-left: 40px;
	}
	#categories-6 > .widget-title {
		display: none;
	}
	#categories-6 > ul {
		display: flex;
	}
	#categories-6 > ul > li {
		margin-right: 40px;
	}
</style>