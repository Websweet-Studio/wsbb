<?php
$btn_url     = ! empty( $settings->btn_link ) ? $settings->btn_link : '#';
$btn_rel     = ! empty( $settings->btn_link_nofollow ) ? ' rel="nofollow"' : '';
$btn_new_tab = ! empty( $settings->btn_link_target ) ? ' target="_blank"' : '';
$is_featured = ( 'yes' === $settings->featured );
$card_class  = $is_featured ? ' wsbb-pricelist-card--featured' : '';
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-pricelist-card<?php echo esc_attr( $card_class ); ?>">
        <?php if ( $is_featured && ! empty( $settings->featured_label ) ) : ?>
            <span class="wsbb-pricelist-badge"><?php echo esc_html( $settings->featured_label ); ?></span>
        <?php endif; ?>

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

        <?php if ( ! empty( $settings->btn_text ) ) : ?>
            <div class="wsbb-pricelist-btn-wrap">
                <a href="<?php echo esc_url( $btn_url ); ?>" class="wsbb-pricelist-btn"<?php echo $btn_rel . $btn_new_tab; ?>>
                    <?php echo esc_html( $settings->btn_text ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
