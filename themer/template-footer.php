<?php
/**
 * Editor template for WSBB footer layouts.
 * Renders page content placeholder above, layout content in <footer>.
 *
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="wsbb-editor-placeholder" style="padding:48px 24px;text-align:center;min-height:320px;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#62625b;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif">
	<div style="font-size:28px;font-weight:700;color:#000;margin-bottom:8px"><?php esc_html_e( 'Page Content', 'wsbb' ); ?></div>
	<div style="font-size:14px"><?php esc_html_e( 'This area will render your theme content above the footer.', 'wsbb' ); ?></div>
</div>

<footer style="display:block;">
<?php while ( have_posts() ) { the_post(); the_content(); } ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
