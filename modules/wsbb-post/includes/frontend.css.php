<?php
$layout_type = isset($settings->layout_type) ? $settings->layout_type : 'grid';
$is_custom   = isset($settings->layout_content) && $settings->layout_content === 'custom';
$gap         = isset($settings->gap) ? intval($settings->gap) : 20;
$gap_medium  = isset($settings->gap_medium) ? intval($settings->gap_medium) : 0;
$gap_responsive = isset($settings->gap_responsive) ? intval($settings->gap_responsive) : 0;
?>

/* ===== Grid Layout ===== */
<?php if ($layout_type === 'grid'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  display: grid;
  grid-template-columns: repeat(<?php echo intval($settings->columns); ?>, 1fr);
  gap: <?php echo $gap; ?>px;
  }

  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  grid-template-columns: repeat(<?php echo intval($settings->columns_medium); ?>, 1fr);
  <?php if ($gap_medium > 0): ?>gap: <?php echo $gap_medium; ?>px;<?php endif; ?>
  }
  }

  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  grid-template-columns: repeat(<?php echo intval($settings->columns_responsive); ?>, 1fr);
  <?php if ($gap_responsive > 0): ?>gap: <?php echo $gap_responsive; ?>px;<?php endif; ?>
  }
  }
<?php endif; ?>

/* ===== Masonry Layout ===== */
<?php if ($layout_type === 'masonry'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  column-count: <?php echo intval($settings->columns); ?>;
  column-gap: <?php echo $gap; ?>px;
  }

  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  break-inside: avoid;
  margin-bottom: <?php echo $gap; ?>px;
  }

  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  column-count: <?php echo intval($settings->columns_medium); ?>;
  <?php if ($gap_medium > 0): ?>column-gap: <?php echo $gap_medium; ?>px;<?php endif; ?>
  }
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  margin-bottom: <?php echo $gap_medium > 0 ? $gap_medium : $gap; ?>px;
  }
  }

  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  column-count: <?php echo intval($settings->columns_responsive); ?>;
  <?php if ($gap_responsive > 0): ?>column-gap: <?php echo $gap_responsive; ?>px;<?php endif; ?>
  }
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  margin-bottom: <?php echo $gap_responsive > 0 ? $gap_responsive : $gap; ?>px;
  }
  }
<?php endif; ?>

/* ===== List Layout ===== */
<?php if ($layout_type === 'list'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  display: flex;
  flex-direction: column;
  gap: <?php echo $gap; ?>px;
  }
  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  <?php if ($gap_medium > 0): ?>gap: <?php echo $gap_medium; ?>px;<?php endif; ?>
  }
  }
  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  <?php if ($gap_responsive > 0): ?>gap: <?php echo $gap_responsive; ?>px;<?php endif; ?>
  }
  }
<?php endif; ?>

/* ===== Carousel Layout ===== */
<?php if ($layout_type === 'carousel'):
  $carousel_gap = isset($settings->carousel_gap) ? intval($settings->carousel_gap) : 20;
  $carousel_slides = isset($settings->carousel_slides) ? intval($settings->carousel_slides) : 3;
  $carousel_slides_medium = isset($settings->carousel_slides_medium) ? intval($settings->carousel_slides_medium) : 2;
  $carousel_slides_responsive = isset($settings->carousel_slides_responsive) ? intval($settings->carousel_slides_responsive) : 1;
?>
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  flex: 0 0 calc((100% - (<?php echo $carousel_slides; ?> - 1) * <?php echo $carousel_gap; ?>px) / <?php echo $carousel_slides; ?>);
  }

  .fl-node-<?php echo $id; ?> .wsbb-post-carousel-track {
  gap: <?php echo $carousel_gap; ?>px;
  }

  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  flex: 0 0 calc((100% - (<?php echo $carousel_slides_medium; ?> - 1) * <?php echo $carousel_gap; ?>px) / <?php echo $carousel_slides_medium; ?>);
  }
  }

  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  flex: 0 0 calc((100% - (<?php echo $carousel_slides_responsive; ?> - 1) * <?php echo $carousel_gap; ?>px) / <?php echo $carousel_slides_responsive; ?>);
  }
  }
<?php endif; ?>

/* ===== Common ===== */
.fl-node-<?php echo $id; ?> .wsbb-post-item-inner {
border-radius: <?php echo intval($settings->border_radius); ?>px;
<?php if (!empty($settings->card_bg_color)): ?>
  background-color: <?php echo FLBuilderColor::hex_or_rgb($settings->card_bg_color); ?>;
<?php endif; ?>
<?php
$card_border_w = isset($settings->card_border_width) ? intval($settings->card_border_width) : 0;
if ($card_border_w > 0 && !empty($settings->card_border_color)):
?>
  border: <?php echo $card_border_w; ?>px solid <?php echo FLBuilderColor::hex_or_rgb($settings->card_border_color); ?>;
<?php endif; ?>
}

<?php if (!$is_custom): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-image img {
  height: <?php echo intval($settings->image_height); ?>px;
  object-fit: cover;
  <?php
  $img_br = isset($settings->image_border_radius) ? intval($settings->image_border_radius) : 0;
  if ($img_br > 0):
  ?>
    border-radius: <?php echo $img_br; ?>px;
  <?php endif; ?>
  }
<?php endif; ?>

.fl-node-<?php echo $id; ?> .wsbb-post-pagination {
text-align: <?php echo esc_attr($settings->pagination_align); ?>;
}

/* ===== Style Tab: Typography ===== */
<?php if (!empty($settings->title_font)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-title a {
  <?php if (!empty($settings->title_font['family']) && 'Default' !== $settings->title_font['family']): ?>
    font-family: <?php echo esc_attr($settings->title_font['family']); ?>;
  <?php endif; ?>
  <?php if (!empty($settings->title_font['weight'])): ?>
    font-weight: <?php echo esc_attr($settings->title_font['weight']); ?>;
  <?php endif; ?>
  }
<?php endif; ?>

<?php if (!empty($settings->title_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-title a {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->title_color); ?>;
  }
<?php endif; ?>

<?php if (!empty($settings->meta_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-meta,
  .fl-node-<?php echo $id; ?> .wsbb-post-date,
  .fl-node-<?php echo $id; ?> .wsbb-post-author {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->meta_color); ?>;
  }
<?php endif; ?>

<?php if (!empty($settings->excerpt_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-excerpt {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->excerpt_color); ?>;
  }
<?php endif; ?>

<?php
// ── Button style ──────────────────────────────────────────
$btn_style         = isset($settings->btn_style) ? $settings->btn_style : 'filled';
$btn_bg            = !empty($settings->btn_bg_color) ? FLBuilderColor::hex_or_rgb($settings->btn_bg_color) : '#0073aa';
$btn_text          = !empty($settings->btn_text_color) ? FLBuilderColor::hex_or_rgb($settings->btn_text_color) : '#ffffff';
$btn_bg_hover      = !empty($settings->btn_bg_hover) ? FLBuilderColor::hex_or_rgb($settings->btn_bg_hover) : '';
$btn_text_hover    = !empty($settings->btn_text_hover) ? FLBuilderColor::hex_or_rgb($settings->btn_text_hover) : '';

$btn_border_radius = isset($settings->btn_border_radius) ? intval($settings->btn_border_radius) : 4;
$btn_border_width  = isset($settings->btn_border_width) ? intval($settings->btn_border_width) : 2;
$btn_border_color  = !empty($settings->btn_border_color) ? FLBuilderColor::hex_or_rgb($settings->btn_border_color) : '';
$btn_border_hover  = !empty($settings->btn_border_hover_color) ? FLBuilderColor::hex_or_rgb($settings->btn_border_hover_color) : '';

$btn_size_preset   = isset($settings->btn_size_preset) ? $settings->btn_size_preset : 'custom';
if ('custom' === $btn_size_preset) {
  $pad_h     = isset($settings->btn_padding_h) ? intval($settings->btn_padding_h) : 16;
  $pad_v     = isset($settings->btn_padding_v) ? intval($settings->btn_padding_v) : 8;
  $font_size = isset($settings->btn_font_size) ? intval($settings->btn_font_size) : 15;
} else {
  $presets = array(
    'small'  => array('pad_h' => 16, 'pad_v' => 8,  'font_size' => 13),
    'medium' => array('pad_h' => 24, 'pad_v' => 12, 'font_size' => 15),
    'large'  => array('pad_h' => 36, 'pad_v' => 16, 'font_size' => 18),
  );
  $p        = $presets[$btn_size_preset];
  $pad_h    = $p['pad_h'];
  $pad_v    = $p['pad_v'];
  $font_size = $p['font_size'];
}

$font_weight    = isset($settings->btn_font_weight) ? intval($settings->btn_font_weight) : 600;
$letter_spacing = isset($settings->btn_letter_spacing) ? floatval($settings->btn_letter_spacing) : 0;
$show_shadow    = isset($settings->btn_box_shadow) ? $settings->btn_box_shadow : 'no';
$shadow_hover   = isset($settings->btn_shadow_hover) ? $settings->btn_shadow_hover : 'no';

// Style-specific overrides
if ('outlined' === $btn_style && empty($btn_border_color)) $btn_border_color = $btn_bg;
if ('outlined' === $btn_style) $btn_text = $btn_border_color;
if ('ghost' === $btn_style) $btn_text = $btn_bg;
if ('ghost' === $btn_style && empty($btn_bg_hover)) $btn_bg_hover = $btn_bg;
if ('ghost' === $btn_style && empty($btn_text_hover)) $btn_text_hover = '#ffffff';
?>

/* ── Button base ───────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-post-readmore {
color: <?php echo $btn_text; ?>;
background-color: <?php echo $btn_bg; ?>;
border-radius: <?php echo $btn_border_radius; ?>px;
border: <?php echo $btn_border_width; ?>px solid <?php echo $btn_border_color ?: 'transparent'; ?>;
padding: <?php echo $pad_v; ?>px <?php echo $pad_h; ?>px;
font-size: <?php echo $font_size; ?>px;
font-weight: <?php echo $font_weight; ?>;
<?php if ($letter_spacing > 0): ?>
  letter-spacing: <?php echo $letter_spacing; ?>px;
<?php endif; ?>
<?php if ('yes' === $show_shadow): ?>
  box-shadow: 0 4px 14px rgba(0,0,0,0.15);
<?php endif; ?>
}

<?php if ('outlined' === $btn_style || 'ghost' === $btn_style): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-btn--<?php echo $btn_style; ?> {
  background: transparent;
  }
<?php endif; ?>

/* ── Button hover ──────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-post-readmore:hover {
<?php if (!empty($btn_text_hover)): ?>
  color: <?php echo $btn_text_hover; ?>;
<?php endif; ?>
<?php if (!empty($btn_bg_hover)): ?>
  background-color: <?php echo $btn_bg_hover; ?>;
<?php endif; ?>
<?php if (!empty($btn_border_hover)): ?>
  border-color: <?php echo $btn_border_hover; ?>;
<?php endif; ?>
<?php if ('yes' === $shadow_hover): ?>
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
<?php endif; ?>
}

/* ===== Custom Card CSS ===== */
<?php if ($is_custom && !empty($settings->custom_css_field)): ?>
  <?php echo $settings->custom_css_field; ?>

<?php endif; ?>