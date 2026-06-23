<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-editor-inner">
        <?php echo FLBuilderUtils::wpautop($settings->editor_content, true); ?>
    </div>
</div>
