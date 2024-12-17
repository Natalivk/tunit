<?php get_header('not'); ?>

    <section class="not-found">
        <div class="not-found__inner">
            <?php if ($logo_404 = get_field('logo', 'option')): ?>
                <div class="not-found__logo">

                </div>

            <?php endif; ?>

            <div class="not-found__content">
                <div class="not-found__content-inner">
                    <?php if ($title_404 = get_field('title_404', 'option')): ?>
                        <h3 class="not-found__title block-title-m"><?php echo $title_404; ?></h3>
                    <?php endif; ?>
                    <?php if ($text_404 = get_field('text_404', 'option')): ?>
                        <p class="not-found__subtitle body-font"><?php echo $text_404; ?></p>
                    <?php endif; ?>
                    <div class="not-found__btn-wrapper">
                        <a class="not-found__btn btn-primary"
                           href="<?php echo home_url('/') ?>"><?php echo __('Go Home', 'ds'); ?></a>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>