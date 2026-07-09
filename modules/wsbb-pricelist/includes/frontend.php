<?php
$btn_url     = ! empty($settings->btn_link) ? $settings->btn_link : '#';
$btn_rel     = ! empty($settings->btn_link_nofollow) ? ' rel="nofollow"' : '';
$btn_new_tab = ! empty($settings->btn_link_target) ? ' target="_blank"' : '';
$is_featured = ('yes' === $settings->featured);

$card_style     = ! empty($settings->card_style) ? $settings->card_style : 'standard';
$btn_style      = ! empty($settings->btn_style) ? $settings->btn_style : 'filled';
$show_shadow    = ! empty($settings->show_shadow) ? $settings->show_shadow : 'yes';
$content_align  = ! empty($settings->content_align) ? $settings->content_align : 'left';

$card_class  = 'wsbb-pricelist-card';
$card_class .= ' wsbb-pricelist-card--' . $card_style;
$card_class .= $is_featured ? ' wsbb-pricelist-card--featured' : '';
$card_class .= 'yes' !== $show_shadow ? ' wsbb-pricelist-card--no-shadow' : '';
$card_class .= ' wsbb-pricelist-card--align-' . $content_align;

$btn_class   = 'wsbb-pricelist-btn';
$btn_class  .= ' wsbb-pricelist-btn--' . $btn_style;

$is_elevated = ('elevated' === $card_style);
?>
<div <?php $module->render_attributes(); ?>>
    <div class="<?php echo esc_attr($card_class); ?>">
        <?php if ( $is_featured && ! empty( $settings->featured_label ) ) : ?>
            <span class="wsbb-pricelist-badge"><?php echo esc_html( $settings->featured_label ); ?></span>
        <?php endif; ?>

        <?php if ( $is_elevated ) : ?>
        <div class="wsbb-pricelist-price-wrap">
            <?php if ( ! empty( $settings->plan_name ) ) : ?>
                <h3 class="wsbb-pricelist-name"><?php echo esc_html( $settings->plan_name ); ?></h3>
            <?php endif; ?>
            <div class="wsbb-pricelist-price">
                <?php if ( ! empty( $settings->currency ) ) : ?>
                    <span class="wsbb-pricelist-currency"><?php echo esc_html( $settings->currency ); ?></span>
                <?php endif; ?>
                <span class="wsbb-pricelist-price-amount"><?php echo esc_html( $settings->price ); ?></span>
                <?php if ( ! empty( $settings->period ) ) : ?>
                    <span class="wsbb-pricelist-period"><?php echo esc_html( $settings->period ); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="wsbb-pricelist-body">
        <?php endif; ?>

        <?php if ( ! $is_elevated ) : ?>
            <?php if ( ! empty( $settings->plan_name ) ) : ?>
                <h3 class="wsbb-pricelist-name"><?php echo esc_html( $settings->plan_name ); ?></h3>
            <?php endif; ?>
            <div class="wsbb-pricelist-price">
                <?php if ( ! empty( $settings->currency ) ) : ?>
                    <span class="wsbb-pricelist-currency"><?php echo esc_html( $settings->currency ); ?></span>
                <?php endif; ?>
                <span class="wsbb-pricelist-price-amount"><?php echo esc_html( $settings->price ); ?></span>
                <?php if ( ! empty( $settings->period ) ) : ?>
                    <span class="wsbb-pricelist-period"><?php echo esc_html( $settings->period ); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $settings->description ) ) : ?>
            <div class="wsbb-pricelist-desc"><?php echo wp_kses_post( $settings->description ); ?></div>
        <?php endif; ?>

        <?php if ( ! empty( $settings->features ) ) : ?>
            <ul class="wsbb-pricelist-features">
                <?php foreach ( $settings->features as $feature ) : ?>
                    <li class="wsbb-pricelist-feature">
                        <span class="wsbb-pricelist-feature-icon"></span>
                        <?php echo esc_html( $feature ); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ( ! $is_elevated && ! empty( $settings->btn_text ) ) : ?>
            <div class="wsbb-pricelist-btn-wrap">
                <a href="<?php echo esc_url( $btn_url ); ?>" class="<?php echo esc_attr( $btn_class ); ?>"<?php echo $btn_rel . $btn_new_tab; ?>>
                    <?php echo esc_html( $settings->btn_text ); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ( $is_elevated ) : ?>
        </div>
            <?php if ( ! empty( $settings->btn_text ) ) : ?>
            <div class="wsbb-pricelist-btn-wrap">
                <a href="<?php echo esc_url( $btn_url ); ?>" class="<?php echo esc_attr( $btn_class ); ?>"<?php echo $btn_rel . $btn_new_tab; ?>>
                    <?php echo esc_html( $settings->btn_text ); ?>
                </a>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
