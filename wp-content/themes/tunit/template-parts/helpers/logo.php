<?php
/**
 * @var array $args
 */

// get args
$class = $args['class'] ?? '';
?>
<?php if($logo = get_field('logo', 'option')): ?>
    <a class="page-logo <?php echo $class; ?>" href="<?php echo home_url('/'); ?>">
        <?php echo get_render_image($logo, 'full', get_bloginfo('name'), 'page-logo__img'); ?>
    </a>
<?php endif; ?>
