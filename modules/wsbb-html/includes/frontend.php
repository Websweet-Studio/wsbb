<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-html-inner">
        <?php echo wp_kses_post( $settings->html_content ); ?>
    </div>
</div>
