<?php get_header(); ?>

<?php do_action('cp_content_before'); ?>
<div id="content" class="clearfix row">
	<?php do_action('cp_main_before'); ?>	
	<div id="main" class="col-md-9 clearfix" role="main">
		<?php do_action('cp_loop_before'); ?>
        <?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">	
            <div class="profilePicThumb" style="float: right;">
                <?php 
                if ( has_post_thumbnail() ) { // Проверка на наличие миниатюры для записи
                  the_post_thumbnail('thumbnail', 'class=img-circle');
                } 
                ?>
            </div>
            <header>
				<a href="<?php the_permalink(); ?>">#<?php the_ID(); ?></a>
				<h1><?php the_title();	?></h1>
				<?php echo get_the_term_list( get_the_ID(), 'subjects_category', 'Категории: ', ', ', '' ); ?> 
				<hr/>
			</header>

			<div class="entry-content">
			<?php do_action('cp_entry_content_before'); ?>
			<div>	

                <div class="entry-content-inner">
				<?php
					the_content();
				?>
				</div>
            </div>
			<?php do_action('cp_entry_content_after'); ?>
			<hr/>
			</div>
            <footer>
                <?php do_action('cp_entry_footer_before'); ?>
                <?php do_action('cp_post_before_comments'); ?>
                <?php comments_template('', true); ?>
                <?php do_action('cp_post_after_comments'); ?>
                <?php do_action('cp_entry_footer_after'); ?>
            </footer>
		</article>
		<?php do_action('cp_post_after'); ?>
        <?php endwhile; /* End loop */ ?>

	</div><!-- /#main -->
	<?php do_action('cp_main_after'); ?>

	<?php do_action('cp_sidebar_before'); ?>
	<aside id="sidebar" class="fluid-sidebar sidebar col-md-3" role="complementary">
		<?php do_action('cp_sidebar_inside_before'); ?>
		<div class="well">
			<?php dynamic_sidebar( 'persons' ); ?>
		</div>
		<?php do_action('cp_sidebar_inside_after'); ?>
	</aside><!-- /#sidebar -->
	<?php do_action('cp_sidebar_after'); ?>


</div><!-- /#content -->
<?php do_action('cp_content_after'); ?>

<?php get_footer(); ?>