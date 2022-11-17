<?php get_header(); ?>

<div class="loop-single-post" ?> 
	<header class="entry-header alignwide">
		<h2 class="entry-title">
			<?php the_title(); ?>
		</h2>
	</header>

	<main>
		<?php the_content(); ?>
		<p>
			<h4><?php esc_html_e( 'Event details', 'loop' ); ?></h4>
		</p>
		<p>
			<?php loop_events_show_text_field( __( 'Organizer Name', 'loop' ), 'loop_events_organizer_name' ); ?>
		</p>
		<p>
			<?php loop_events_show_time(); ?>
		</p>
		<p>
			<?php loop_events_show_organizer_email(); ?>
		</p>
		<p>
			<?php loop_events_show_text_field( __( 'Address', 'loop' ), 'loop_events_address' ); ?>
		</p>
		<p>
			<?php loop_events_show_map_link(); ?>
		</p>
		<footer>
			<p>
				<?php echo get_the_term_list( $post->ID, LOOP_CPT_SLUG . '-tags', __( 'Tags: ' ), ', ' ); ?>
			</p>
		</footer>
	</main>
</div>

<?php get_footer(); ?>
