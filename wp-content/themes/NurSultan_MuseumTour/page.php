<?php get_header(); ?>
<main id="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!--<header class="header">
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>-->
<div class="entry-content">
<!--<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
<?php the_content(); ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>-->

<div id="str1">
	<span id="tagline">
		<span>Вы окунетесь в историю культурного наследия</span><br>
		в лучших музеях Нур-Султана
	</span>
	<?php echo do_shortcode( '[wonderplugin_carousel id="1"]' ); ?>
</div>


<div id="str2">
	<div id="left_triangle"></div>
	<div id="right_triangle"></div>


	<div id="sss"></div>

		<select name="filter_category" id="filter" onchange="filter_change(this.selectedIndex)">
			<option value="all">Все</option>
			<?php
				$categories = get_categories(
					['child_of' => 1,]
				);

				if ($categories) {
					foreach ($categories as $cat) {
						echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';
					}
				}
			?>
		</select>

	<span id="str2_tag">Музеи</span>

	<div id="museums_block">
		
	</div>
		
	
</div>




<div id="str3">
	<div class="events_news">
		<div class="str3_tags">Событий</div>

		<div class="events_news_list" id="events_list">
			<?php
				$events = get_posts([
					'numberposts' => 5,
					'post_type'   => 'post',
					'category'    => 14,
				]);


				foreach ($events as $post) { setup_postdata($post);
				?>
					<a class="events_news_post" href="<?php the_permalink() ?>">
						<time>
							<?php the_time('d.m.y в H:i') ?>
						</time>

						<span>
							<?php the_title() ?>
						</span>
					</a>
				<?php
				}

				wp_reset_postdata();
			?>
		</div>
	</div>

	<div id="str3_line"></div>

	<div class="events_news">
		<div class="str3_tags">Новости</div>

		<div class="events_news_list" id="news_list">
			<?php
				$news = get_posts([
					'numberposts' => 5,
					'post_type'   => 'post',
					'category'    => 11,
				]);


				foreach ($news as $post) { setup_postdata($post);
				?>
					<a class="events_news_post" href="<?php the_permalink() ?>">
						<time>
							<?php the_time('d.m.y в H:i') ?>
						</time>

						<span>
							<?php the_title() ?>
						</span>
					</a>
				<?php
				}

				wp_reset_postdata();
			?>
		</div>
	</div>
</div>



<div id="str4">
	<div id="str4_line1"></div>

	<div id="contact_form_block">
		<div id="contact_form">
			<span id="form_tag">Свяжитесь с нами</span>
			<?php echo do_shortcode('[contact-form-7 id="103" title="Contact form 1"]'); ?>
		</div>

		<div id="contact">
			<span id="contact_tag">Контакты</span>

			<span class="contact_info">
				<span>Адресс</span> <br>
				г. Нур-Султан, ул. Сейфуллина
			</span>

			<span class="contact_info">
				<span>Телефон</span> <br>
				+7 (727) 291 91 01<br>
				+7 (702) 155 50 55
			</span>

			<span class="contact_info">
				<span>Почта</span> <br>
				admin@example.com
			</span>
		</div>
	</div>
	
	<div id="str4_line2"></div>
</div>


</div>
</article>
<?php if ( comments_open() && ! post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>





<?php
			
			$museums = get_posts([
				'numberposts' => -1,
				'post_type'   => 'post',
				'category'    => 1,
			]);

			$i = 0;

			$mus = [];
			class mm {}

			foreach ($museums as $post) { setup_postdata($post);
				
				$museum = new mm();

				$museum->name = get_the_title();
				$museum->category = get_the_category();
				//$museum->category = get_the_terms(get_the_id(), 'museums_cat');
				$museum->url = get_the_permalink();
				$museum->thumbnail = get_the_post_thumbnail_url(get_the_id(),'full');

				$mus[] = $museum;
			}

			wp_reset_postdata();

			$json = json_encode($mus);	
		?>



		<script type="text/javascript">
			let museums = JSON.parse('<?php echo $json; ?>');
			
			show('all');

			function filter_change(index) {
				let filter = document.getElementById('filter');
				let value = filter.options[index].value;

				show(value);
			}

			function show(cat) {
				let museums_block = document.getElementById('museums_block');
				museums_block.innerHTML = '';
				
				let filtered = [];

				if (cat == 'all') {
					filtered = museums;
				} else {
					museums.forEach(item => {
						if (item.category) {			
							item.category.forEach(cat_id => {
								if (cat_id.term_id == cat) {
									filtered.push(item);
								}
							}) //inner-foreach
						} //if
					}) //foreach
				}


				let subfilter = [];
				for (let i = 0; i<Math.ceil(filtered.length/6); i++) {
					subfilter[i] = filtered.slice( (i*6), (i*6)+6 )
				}
				
				subfilter.forEach(ss => {
					let museums_wrapper = document.createElement('div');
					museums_wrapper.className = 'museums_wrapper';

					ss.forEach(item => {
						let museum = document.createElement('a');
						let museum_img = document.createElement('div');
						let museum_name = document.createElement('span');

						museum.className = 'museum';
						museum_img.className = 'museum_img';
						museum_name.className = 'museum_name';

						museum.href = item.url;
						museum_img.style.backgroundImage = 'url('+item.thumbnail+')';
						if (!item.thumbnail) {museum_img.textContent = "Отсутствует изображение"}
						museum_name.textContent = item.name;

						museum.appendChild(museum_img);
						museum.appendChild(museum_name);
						museums_wrapper.appendChild(museum);
					});
					museums_block.appendChild(museums_wrapper);
				});

				let is_page = 1;
				let step = 0;
		
				let right_triangle = document.getElementById('right_triangle');
				right_triangle.onclick = function() {
					console.log(is_page, subfilter.length);
					if (is_page < subfilter.length) {
						step += 960;
						document.querySelector('.museums_wrapper').style.marginLeft = -step +'px';
						is_page++;	
					}
					triangle_active();
				}

				let left_triangle = document.getElementById('left_triangle');
				left_triangle.onclick = function() {
					if (is_page > 1) {
						step -= 960;
						document.querySelector('.museums_wrapper').style.marginLeft = step +'px';
						is_page--;
					}
					triangle_active();
				}



				function triangle_active() {
					if (is_page < subfilter.length) {
					right_triangle.className = "triangle_active";
					} else {
						right_triangle.className = "";
					}
					if (is_page > 1) {
						left_triangle.className = "triangle_active";
					} else {
						left_triangle.className = "";
					}
				}
				triangle_active();




				/*
				let i = 0;
				filter.forEach(item => {
					if (i == 6) {return}
					let museum = document.createElement('a');
					let museum_img = document.createElement('div');
					let museum_name = document.createElement('span');

					museum.className = 'museum';
					museum_img.className = 'museum_img';
					museum_name.className = 'museum_name';

					museum.href = item.url;
					museum_img.style.backgroundImage = 'url('+item.thumbnail+')';
					if (!item.thumbnail) {museum_img.textContent = "Отсутствует изображение"}
					museum_name.textContent = item.name;

					museum.appendChild(museum_img);
					museum.appendChild(museum_name);
					museums_block.appendChild(museum);

					i++;
				});*/
			}


           // КОНТАКТНАЯ ФОРМА
			document.getElementById('form_name').placeholder = "Ваше имя";
			document.getElementById('form_email').placeholder = "Ваш email";
			document.getElementById('form_message').placeholder = "Ваше сообщение";

		</script>