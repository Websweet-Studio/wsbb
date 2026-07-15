<?php
$layout_type = isset($settings->layout_type) ? $settings->layout_type : 'grid';
$is_carousel = $layout_type === 'carousel';
$items       = isset($settings->testimoni_items) ? $settings->testimoni_items : array();
$carousel_slides = isset($settings->carousel_slides) ? intval($settings->carousel_slides) : 3;
$carousel_gap    = isset($settings->carousel_gap) ? intval($settings->carousel_gap) : 20;

if (empty($items)) {
    echo '<p class="wsbb-testimoni-empty">' . __('No testimonials found.', 'wsbb') . '</p>';
    return;
}
?>

<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-testimoni-wrapper wsbb-testimoni-<?php echo esc_attr($layout_type); ?>">

        <?php if ($is_carousel): ?>
            <div class="wsbb-testimoni-carousel"
                data-slides="<?php echo intval($settings->carousel_slides); ?>"
                data-autoplay="<?php echo esc_attr($settings->carousel_autoplay); ?>"
                data-autoplay-speed="<?php echo intval($settings->carousel_autoplay_speed); ?>"
                data-arrows="<?php echo esc_attr($settings->carousel_arrows); ?>"
                data-dots="<?php echo esc_attr($settings->carousel_dots); ?>"
                data-loop="<?php echo esc_attr($settings->carousel_loop); ?>">

                <?php if ($settings->carousel_arrows === 'yes'): ?>
                    <button class="wsbb-carousel-prev" type="button" aria-label="<?php esc_attr_e('Previous', 'wsbb'); ?>">&lsaquo;</button>
                <?php endif; ?>

                <div class="wsbb-testimoni-carousel-track" style="gap: <?php echo $carousel_gap; ?>px;">
                <?php endif; ?>

                <?php foreach ($items as $item): ?>
                    <div class="wsbb-testimoni-item" <?php if ($is_carousel): ?> style="flex: 0 0 calc((100% - (<?php echo $carousel_slides; ?> - 1) * <?php echo $carousel_gap; ?>px) / <?php echo $carousel_slides; ?>);" <?php endif; ?>>
                        <div class="wsbb-testimoni-item-inner">

                            <?php if ($settings->show_rating === 'yes' && !empty($item->rating)): ?>
                                <div class="wsbb-testimoni-rating" style="text-align: <?php echo esc_attr($settings->rating_align); ?>;">
                                    <?php
                                    $stars = intval($item->rating);
                                    for ($s = 1; $s <= 5; $s++) {
                                        echo $s <= $stars
                                            ? '<span class="wsbb-star wsbb-star-filled">&#9733;</span>'
                                            : '<span class="wsbb-star wsbb-star-empty">&#9734;</span>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($settings->show_text === 'yes' && !empty($item->text)): ?>
                                <div class="wsbb-testimoni-text">
                                    <p><?php echo nl2br(esc_html($item->text)); ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="wsbb-testimoni-author">
                                <?php if ($settings->show_avatar === 'yes' && !empty($item->photo)): ?>
                                    <?php $avatar_src = wp_get_attachment_image_src(intval($item->photo), array(300, 300)); ?>
                                    <?php if ($avatar_src): ?>
                                        <div class="wsbb-testimoni-avatar">
                                            <img src="<?php echo esc_url($avatar_src[0]); ?>" alt="<?php echo esc_attr($item->name); ?>" loading="lazy" />
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <div class="wsbb-testimoni-info">
                                    <?php if ($settings->show_name === 'yes' && !empty($item->name)): ?>
                                        <strong class="wsbb-testimoni-name"><?php echo esc_html($item->name); ?></strong>
                                    <?php endif; ?>
                                    <?php if ($settings->show_role === 'yes' && !empty($item->role)): ?>
                                        <span class="wsbb-testimoni-role"><?php echo esc_html($item->role); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($is_carousel): ?>
                </div><!-- .wsbb-testimoni-carousel-track -->

                <?php if ($settings->carousel_arrows === 'yes'): ?>
                    <button class="wsbb-carousel-next" type="button" aria-label="<?php esc_attr_e('Next', 'wsbb'); ?>">&rsaquo;</button>
                <?php endif; ?>

                <?php if ($settings->carousel_dots === 'yes'): ?>
                    <div class="wsbb-carousel-dots"></div>
                <?php endif; ?>
            </div><!-- .wsbb-testimoni-carousel -->
        <?php endif; ?>

    </div><!-- .wsbb-testimoni-wrapper -->
</div>