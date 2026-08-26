<?php
/**
 * Site footer.
 *
 * @package CR_Practice
 */
?>
<footer class="site-footer">
	<div class="container">
		<p>
			<?php
			printf(
				/* translators: %s: Current year. */
				esc_html__( 'Copyright %s', 'cr-practice' ),
				esc_html( wp_date( 'Y' ) )
			);
			?>
		</p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
