<?php
/**
 * Site footer.
 *
 * @package ACF_Module_Workbench
 */
?>
<footer class="site-footer">
	<div class="container">
		<p>
			<?php
			printf(
				/* translators: %s: Current year. */
				esc_html__( 'Copyright %s', 'acf-module-workbench' ),
				esc_html( wp_date( 'Y' ) )
			);
			?>
		</p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
