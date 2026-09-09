<?php
/**
 * Timeline / Milestones block template.
 *
 * @package ACF_Module_Workbench
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow           = trim( (string) get_field( 'eyebrow' ) );
$heading           = trim( (string) get_field( 'heading' ) );
$introduction      = trim( (string) get_field( 'introduction' ) );
$heading_level     = (string) get_field( 'heading_level' );
$raw_entries       = get_field( 'entries' );
$raw_block_data    = isset( $block['data'] ) && is_array( $block['data'] ) ? $block['data'] : array();
$is_editor_preview = ! empty( $is_preview );
$allowed_headings    = array( 'h2', 'h3', 'h4' );
$allowed_tones       = array( 'brand', 'success', 'danger', 'neutral' );
$allowed_badge_icons = array( 'none', 'history', 'announcement', 'palette', 'database' );
$allowed_note_icons  = array( 'auto', 'none', 'feature', 'improvement', 'bug', 'launch', 'performance' );
$entries           = array();

$heading_level = in_array( $heading_level, $allowed_headings, true ) ? $heading_level : 'h2';
$heading_map   = array(
	'h2' => array( 'entry' => 'h3', 'group' => 'h4' ),
	'h3' => array( 'entry' => 'h4', 'group' => 'h5' ),
	'h4' => array( 'entry' => 'h5', 'group' => 'h6' ),
);

if ( is_array( $raw_entries ) ) {
	foreach ( $raw_entries as $entry_index => $raw_entry ) {
		if ( ! is_array( $raw_entry ) ) {
			continue;
		}

		$marker_label = isset( $raw_entry['marker_label'] ) ? trim( (string) $raw_entry['marker_label'] ) : '';
		$badge_icon   = isset( $raw_entry['badge_icon'] ) ? (string) $raw_entry['badge_icon'] : 'none';
		$title        = isset( $raw_entry['title'] ) ? trim( (string) $raw_entry['title'] ) : '';
		$date_context = isset( $raw_entry['date_context'] ) ? trim( (string) $raw_entry['date_context'] ) : '';
		$date_type    = isset( $raw_entry['date_type'] ) ? (string) $raw_entry['date_type'] : 'exact';
		$raw_date_key = 'entries_' . $entry_index . '_exact_date';
		$exact_date   = isset( $raw_block_data[ $raw_date_key ] )
			? trim( (string) $raw_block_data[ $raw_date_key ] )
			: ( isset( $raw_entry['exact_date'] ) ? trim( (string) $raw_entry['exact_date'] ) : '' );
		$period       = isset( $raw_entry['period'] ) ? trim( (string) $raw_entry['period'] ) : '';
		$raw_groups   = isset( $raw_entry['content_groups'] ) && is_array( $raw_entry['content_groups'] ) ? $raw_entry['content_groups'] : array();
		$groups       = array();

		if ( '' === $marker_label || '' === $title ) {
			continue;
		}

		foreach ( $raw_groups as $raw_group ) {
			if ( ! is_array( $raw_group ) ) {
				continue;
			}

			$label     = isset( $raw_group['group_label'] ) ? trim( (string) $raw_group['group_label'] ) : '';
			$summary   = isset( $raw_group['summary'] ) ? trim( (string) $raw_group['summary'] ) : '';
			$tone      = isset( $raw_group['tone'] ) ? (string) $raw_group['tone'] : 'brand';
			$raw_notes = isset( $raw_group['notes'] ) && is_array( $raw_group['notes'] ) ? $raw_group['notes'] : array();
			$notes     = array();

			foreach ( $raw_notes as $raw_note ) {
				$note      = is_array( $raw_note ) && isset( $raw_note['note'] ) ? trim( (string) $raw_note['note'] ) : '';
				$note_icon = is_array( $raw_note ) && isset( $raw_note['note_icon'] ) ? (string) $raw_note['note_icon'] : 'auto';

				if ( '' !== $note ) {
					$notes[] = array(
						'text' => $note,
						'icon' => in_array( $note_icon, $allowed_note_icons, true ) ? $note_icon : 'auto',
					);
				}
			}

			if ( '' === $label && '' === $summary && empty( $notes ) ) {
				continue;
			}

			$groups[] = array(
				'label'   => $label,
				'summary' => $summary,
				'tone'    => in_array( $tone, $allowed_tones, true ) ? $tone : 'brand',
				'notes'   => $notes,
			);
		}

		$date_timestamp = null;
		$date_value     = 'period' === $date_type ? $period : $exact_date;

		if ( 'exact' === $date_type && preg_match( '/^(\d{4})-?(\d{2})-?(\d{2})$/', $exact_date, $date_matches ) ) {
			$date_parts = array_map( 'intval', array_slice( $date_matches, 1 ) );

			if ( checkdate( $date_parts[1], $date_parts[2], $date_parts[0] ) ) {
				$date_value     = sprintf( '%04d-%02d-%02d', $date_parts[0], $date_parts[1], $date_parts[2] );
				$date_object    = new DateTimeImmutable( $date_value, wp_timezone() );
				$date_timestamp = $date_object->getTimestamp();
			} else {
				$date_value = '';
			}
		} elseif ( 'exact' === $date_type ) {
			$date_value = '';
		}

		$entries[] = array(
			'marker_label' => $marker_label,
			'badge_icon'   => in_array( $badge_icon, $allowed_badge_icons, true ) ? $badge_icon : 'none',
			'title'        => $title,
			'date_context' => $date_context,
			'date_type'    => 'period' === $date_type ? 'period' : 'exact',
			'date_value'   => $date_value,
			'date_timestamp' => $date_timestamp,
			'highlight'    => ! empty( $raw_entry['highlight'] ),
			'groups'       => $groups,
		);
	}
}

if ( '' === $heading || empty( $entries ) ) {
	if ( ! $is_editor_preview ) {
		return;
	}

	$wrapper_attributes = get_block_wrapper_attributes(
		array( 'class' => 'timeline-milestones timeline-milestones--incomplete' )
	);
	?>
	<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated by WordPress. ?>>
		<p class="timeline-milestones__editor-guidance"><?php esc_html_e( 'Timeline / Milestones: add a heading and at least one complete entry to preview this block.', 'acf-module-workbench' ); ?></p>
	</div>
	<?php
	return;
}

$heading_id         = wp_unique_id( 'timeline-milestones-heading-' );
$entry_heading      = $heading_map[ $heading_level ]['entry'];
$group_heading      = $heading_map[ $heading_level ]['group'];
$wrapper_attributes = get_block_wrapper_attributes(
	array( 'class' => 'timeline-milestones' )
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated by WordPress. ?> aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<header class="timeline-milestones__header">
		<div class="timeline-milestones__heading-group">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="timeline-milestones__eyebrow">
					<span class="timeline-milestones__eyebrow-icon" aria-hidden="true"></span>
					<?php echo esc_html( $eyebrow ); ?>
				</p>
			<?php endif; ?>

			<<?php echo esc_html( $heading_level ); ?> class="timeline-milestones__heading" id="<?php echo esc_attr( $heading_id ); ?>"><?php echo esc_html( $heading ); ?></<?php echo esc_html( $heading_level ); ?>>
			<span class="timeline-milestones__heading-rule" aria-hidden="true"></span>
		</div>

		<?php if ( '' !== $introduction ) : ?>
			<p class="timeline-milestones__introduction"><?php echo esc_html( $introduction ); ?></p>
		<?php endif; ?>
	</header>

	<ol class="timeline-milestones__entries">
		<?php foreach ( $entries as $entry_index => $entry ) : ?>
			<li class="timeline-milestones__entry<?php echo $entry['highlight'] ? ' timeline-milestones__entry--highlight' : ''; ?>">
				<span class="timeline-milestones__marker" aria-hidden="true"></span>

				<div class="timeline-milestones__metadata">
					<p class="timeline-milestones__badge">
						<?php if ( 'none' !== $entry['badge_icon'] ) : ?><span class="timeline-milestones__badge-icon timeline-milestones__badge-icon--<?php echo esc_attr( $entry['badge_icon'] ); ?>" aria-hidden="true"></span><?php endif; ?>
						<?php echo esc_html( $entry['marker_label'] ); ?>
					</p>
					<<?php echo esc_html( $entry_heading ); ?> class="timeline-milestones__entry-title"><?php echo esc_html( $entry['title'] ); ?></<?php echo esc_html( $entry_heading ); ?>>

					<?php if ( '' !== $entry['date_value'] ) : ?>
						<p class="timeline-milestones__date">
							<?php if ( '' !== $entry['date_context'] ) : ?><span><?php echo esc_html( $entry['date_context'] ); ?>: </span><?php endif; ?>
							<?php if ( 'exact' === $entry['date_type'] ) : ?>
								<time datetime="<?php echo esc_attr( $entry['date_value'] ); ?>"><?php echo esc_html( wp_date( get_option( 'date_format' ), $entry['date_timestamp'] ) ); ?></time>
							<?php else : ?>
								<span><?php echo esc_html( $entry['date_value'] ); ?></span>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $entry['groups'] ) ) : ?>
					<div class="timeline-milestones__card">
						<?php foreach ( $entry['groups'] as $group ) : ?>
							<div class="timeline-milestones__group timeline-milestones__group--<?php echo esc_attr( $group['tone'] ); ?>">
								<?php if ( '' !== $group['label'] ) : ?>
									<<?php echo esc_html( $group_heading ); ?> class="timeline-milestones__group-label"><?php echo esc_html( $group['label'] ); ?></<?php echo esc_html( $group_heading ); ?>>
								<?php endif; ?>

								<?php if ( '' !== $group['summary'] ) : ?>
									<p class="timeline-milestones__group-summary"><?php echo esc_html( $group['summary'] ); ?></p>
								<?php endif; ?>

								<?php if ( ! empty( $group['notes'] ) ) : ?>
									<ul class="timeline-milestones__notes" role="list">
										<?php foreach ( $group['notes'] as $note ) : ?>
											<?php $note_icon = 'auto' === $note['icon'] ? $group['tone'] : $note['icon']; ?>
											<li<?php echo 'none' === $note_icon ? ' class="timeline-milestones__note--without-icon"' : ''; ?>>
												<?php if ( 'none' !== $note_icon ) : ?><span class="timeline-milestones__note-icon timeline-milestones__note-icon--<?php echo esc_attr( $note_icon ); ?>" aria-hidden="true"></span><?php endif; ?>
												<span><?php echo esc_html( $note['text'] ); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</section>
