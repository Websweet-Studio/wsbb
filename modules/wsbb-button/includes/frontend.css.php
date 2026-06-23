<?php
// Hover background color & padding
$pad_h = isset($settings->padding_h) ? intval($settings->padding_h) : 24;
$pad_v = isset($settings->padding_v) ? intval($settings->padding_v) : 12;

if (!empty($settings->bg_hover_color)):
?>
.fl-node-<?php echo $id; ?> .wsbb-button-link:hover {
    background-color: <?php echo FLBuilderColor::hex_or_rgb($settings->bg_hover_color); ?>;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .wsbb-button-link {
    padding: <?php echo $pad_v; ?>px <?php echo $pad_h; ?>px;
}
