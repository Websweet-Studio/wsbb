<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-editor-inner">
        <?php echo wp_kses_post(FLBuilderUtils::wpautop($settings->editor_content, true)); ?>
    </div>
</div>
