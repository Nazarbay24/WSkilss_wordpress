<div class="entry-summary">
<?php if ( has_post_thumbnail() ) : ?>
<a class="post_thumb" href="<?php the_permalink(); ?>"  title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('large'); ?></a>
<?php endif; ?>
<?php the_excerpt(); ?>
<?php if ( is_search() ) { ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
<?php } ?>
</div>

<style type="text/css">
	.post_thumb img {
		
	}
</style>