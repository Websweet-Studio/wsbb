<?php
$images       = isset($settings->images) ? $settings->images : array();
$slider_mode  = isset($settings->slider_mode) ? $settings->slider_mode : 'carousel';
$display_mode = isset($settings->display_mode) ? $settings->display_mode : 'grid';
$is_marquee   = $slider_mode === 'marquee';
$is_carousel  = $slider_mode === 'carousel';

if (empty($images)) {
    echo '<p class="wsbb-image-carousel-empty">' . esc_html__('No images selected.', 'wsbb') . '</p>';
    return;
}

$rows      = intval($settings->rows);
$cols      = intval($settings->columns);
$gap       = intval($settings->gap);
$per_chunk = $rows * $cols;
$chunks    = array_chunk($images, $per_chunk);
$aspect    = isset($settings->aspect_ratio) ? $settings->aspect_ratio : '16-9';

// Carousel visible count: use carousel_slides if set, otherwise columns
$carousel_visible = isset($settings->carousel_slides) ? intval($settings->carousel_slides) : $cols;
$carousel_step    = isset($settings->carousel_slides) ? intval($settings->carousel_slides) : 1;
?>

<div <?php $module->render_attributes(); ?>>

    <?php if ($is_marquee): ?>
        <?php // Marquee: horizontal flex row — all images side by side, cloned for seamless loop 
        ?>
        <div class="wsbb-ic-wrapper wsbb-ic-mode-marquee"
            data-mode="marquee"
            data-marquee-speed="<?php echo intval($settings->marquee_speed); ?>"
            data-marquee-dir="<?php echo esc_attr($settings->marquee_direction); ?>"
            data-marquee-pause="<?php echo esc_attr($settings->marquee_pause); ?>">

            <div class="wsbb-ic-marquee-track"
                style="--wsbb-cols:<?php echo $cols; ?>; --wsbb-gap:<?php echo $gap; ?>px;">

                <?php foreach ($images as $photo_id): ?>
                    <div class="wsbb-ic-marquee-item" style="width: calc((100% - (var(--wsbb-cols) - 1) * var(--wsbb-gap)) / var(--wsbb-cols));">
                        <?php echo wp_get_attachment_image(intval($photo_id), 'medium_large', false, array('class' => 'wsbb-ic-img wsbb-ic-aspect-' . esc_attr($aspect), 'loading' => 'lazy')); ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    <?php elseif ($is_carousel): ?>
        <?php // Carousel mode: each image is a slide, carousel_slides = visible count 
        ?>
        <div class="wsbb-ic-wrapper wsbb-ic-mode-carousel"
            data-mode="carousel"
            data-visible="<?php echo $carousel_visible; ?>"
            data-step="<?php echo $carousel_step; ?>"
            data-autoplay="<?php echo esc_attr($settings->carousel_autoplay); ?>"
            data-autoplay-speed="<?php echo intval($settings->carousel_autoplay_speed); ?>"
            data-arrows="<?php echo esc_attr($settings->carousel_arrows); ?>"
            data-dots="<?php echo esc_attr($settings->carousel_dots); ?>"
            data-loop="<?php echo esc_attr($settings->carousel_loop); ?>">

            <?php if ($settings->carousel_arrows === 'yes'): ?>
                <button class="wsbb-carousel-prev" type="button" aria-label="<?php esc_attr_e('Previous', 'wsbb'); ?>">&lsaquo;</button>
            <?php endif; ?>

            <div class="wsbb-ic-track"
                style="--wsbb-carousel-gap:<?php echo $gap; ?>px;">

                <?php foreach ($images as $photo_id): ?>
                    <div class="wsbb-ic-slide" style="flex: 0 0 calc((100% - (<?php echo $carousel_visible; ?> - 1) * <?php echo $gap; ?>px) / <?php echo $carousel_visible; ?>);">
                        <div class="wsbb-ic-item"><?php echo wp_get_attachment_image(intval($photo_id), 'medium_large', false, array('class' => 'wsbb-ic-img wsbb-ic-aspect-' . esc_attr($aspect), 'loading' => 'lazy')); ?></div>
                    </div>
                <?php endforeach; ?>

            </div>

            <?php if ($settings->carousel_arrows === 'yes'): ?>
                <button class="wsbb-carousel-next" type="button" aria-label="<?php esc_attr_e('Next', 'wsbb'); ?>">&rsaquo;</button>
            <?php endif; ?>

            <?php if ($settings->carousel_dots === 'yes'): ?>
                <div class="wsbb-carousel-dots"></div>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <?php // Static grid/list — no animation 
        ?>
        <div class="wsbb-ic-wrapper"
            style="--wsbb-cols:<?php echo $cols; ?>; --wsbb-gap:<?php echo $gap; ?>px;">

            <div class="wsbb-ic-grid <?php echo $display_mode === 'list' ? 'wsbb-ic-list' : ''; ?>"
                style="--wsbb-rows:<?php echo $rows; ?>; --wsbb-cols:<?php echo $cols; ?>; --wsbb-gap:<?php echo $gap; ?>px;">
                <?php foreach ($images as $photo_id): ?>
                    <div class="wsbb-ic-item"><?php echo wp_get_attachment_image(intval($photo_id), 'medium_large', false, array('class' => 'wsbb-ic-img wsbb-ic-aspect-' . esc_attr($aspect), 'loading' => 'lazy')); ?></div>
                <?php endforeach; ?>
            </div>

        </div>
    <?php endif; ?>

</div>