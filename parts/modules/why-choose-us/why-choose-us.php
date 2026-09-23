<?php
/**
 * Why Choose Us block template.
 *
 * @package ACF_Module_Workbench
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow           = trim( (string) get_field( 'eyebrow' ) );
$heading           = trim( (string) get_field( 'heading' ) );
$heading_level     = (string) get_field( 'heading_level' );
$introduction      = trim( (string) get_field( 'introduction' ) );
$raw_block_data    = isset( $block['data'] ) && is_array( $block['data'] ) ? $block['data'] : array();
$counter_position  = (string) get_field( 'counter_position' );
$reason_rows       = get_field( 'reasons' );
$closing_link      = get_field( 'closing_link' );
$is_editor_preview = ! empty( $is_preview );
$reasons           = array();

$heading_level = in_array( $heading_level, array( 'h2', 'h3', 'h4' ), true ) ? $heading_level : 'h2';
$show_counters = ! array_key_exists( 'show_counters', $raw_block_data ) || '1' === (string) $raw_block_data['show_counters'];
$counter_position = in_array( $counter_position, array( 'left', 'top' ), true ) ? $counter_position : 'left';

/**
 * Accept complete ACF links only.
 *
 * @param mixed $link Raw ACF link value.
 * @return array{url:string,title:string,target:string}|null
 */
$normalize_link = static function ( $link ): ?array {
	if ( ! is_array( $link ) ) {
		return null;
	}

	$url    = esc_url_raw( trim( (string) ( $link['url'] ?? '' ) ) );
	$title  = trim( (string) ( $link['title'] ?? '' ) );
	$target = '_blank' === ( $link['target'] ?? '' ) ? '_blank' : '';

	if ( '' === $url || '' === $title ) {
		return null;
	}

	return array( 'url' => $url, 'title' => $title, 'target' => $target );
};

if ( is_array( $reason_rows ) ) {
	foreach ( array_slice( $reason_rows, 0, 6 ) as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$claim       = trim( (string) ( $row['claim'] ?? '' ) );
		$explanation = trim( (string) ( $row['explanation'] ?? '' ) );

		if ( '' === $claim || '' === $explanation ) {
			continue;
		}

		$proof = trim( (string) ( $row['proof'] ?? '' ) );
		$reasons[] = array(
			'claim'       => $claim,
			'explanation' => $explanation,
			'proof'       => $proof,
			'source'      => '' !== $proof ? $normalize_link( $row['source'] ?? null ) : null,
		);
	}
}

$closing_link = $normalize_link( $closing_link );

if ( '' === $heading || count( $reasons ) < 2 ) {
	if ( ! $is_editor_preview ) {
		return;
	}

	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'why-choose-us why-choose-us--incomplete' ) );
	?>
	<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WordPress-generated attributes. ?>>
		<p class="why-choose-us__editor-guidance"><?php esc_html_e( 'Why Choose Us: add a heading and at least two complete reasons to preview this block.', 'acf-module-workbench' ); ?></p>
	</div>
	<?php
	return;
}

$heading_id         = wp_unique_id( 'why-choose-us-heading-' );
$item_heading_level = 'h' . min( 6, (int) substr( $heading_level, 1 ) + 1 );
$counter_class      = $show_counters ? 'why-choose-us--counters-' . $counter_position : 'why-choose-us--counters-hidden';
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'why-choose-us ' . $counter_class ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WordPress-generated attributes. ?> aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<header class="why-choose-us__header">
		<?php if ( '' !== $eyebrow ) : ?>
			<p class="why-choose-us__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>
		<<?php echo esc_html( $heading_level ); ?> class="why-choose-us__heading" id="<?php echo esc_attr( $heading_id ); ?>"><?php echo esc_html( $heading ); ?></<?php echo esc_html( $heading_level ); ?>>
		<?php if ( '' !== $introduction ) : ?>
			<p class="why-choose-us__introduction"><?php echo esc_html( $introduction ); ?></p>
		<?php endif; ?>
	</header>

	<ol class="why-choose-us__reasons" role="list">
		<?php foreach ( $reasons as $reason_index => $reason ) : ?>
			<li class="why-choose-us__reason<?php echo '' !== $reason['proof'] ? ' why-choose-us__reason--has-proof' : ''; ?><?php echo $show_counters ? ' why-choose-us__reason--has-counter' : ''; ?>">
				<?php if ( $show_counters ) : ?>
					<span class="why-choose-us__counter" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $reason_index + 1 ) ); ?></span>
				<?php endif; ?>
				<div class="why-choose-us__reason-copy">
					<<?php echo esc_html( $item_heading_level ); ?> class="why-choose-us__claim"><?php echo esc_html( $reason['claim'] ); ?></<?php echo esc_html( $item_heading_level ); ?>>
					<p class="why-choose-us__explanation"><?php echo esc_html( $reason['explanation'] ); ?></p>
				</div>
				<?php if ( '' !== $reason['proof'] ) : ?>
					<div class="why-choose-us__proof">
						<p class="why-choose-us__proof-label"><?php esc_html_e( 'In practice', 'acf-module-workbench' ); ?></p>
						<p class="why-choose-us__proof-text"><?php echo esc_html( $reason['proof'] ); ?></p>
						<?php if ( null !== $reason['source'] ) : ?>
							<a class="why-choose-us__source"<?php if ( $is_editor_preview ) : ?> role="link" aria-disabled="true"<?php else : ?> href="<?php echo esc_url( $reason['source']['url'] ); ?>"<?php if ( '_blank' === $reason['source']['target'] ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?><?php endif; ?>><?php echo esc_html( $reason['source']['title'] ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>

	<?php if ( null !== $closing_link ) : ?>
		<footer class="why-choose-us__footer">
			<a class="why-choose-us__cta"<?php if ( $is_editor_preview ) : ?> role="link" aria-disabled="true"<?php else : ?> href="<?php echo esc_url( $closing_link['url'] ); ?>"<?php if ( '_blank' === $closing_link['target'] ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?><?php endif; ?>>
				<span><?php echo esc_html( $closing_link['title'] ); ?></span><span aria-hidden="true">&rarr;</span>
			</a>
		</footer>
	<?php endif; ?>
</section>
