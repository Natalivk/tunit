<div class="banner-hero">
    <div class="banner-hero__inner inner">
        <div class="banner-hero__content">
            <?php if ($title = get_field('title')): ?>
                <h1 class="banner-hero__title block-title"><?php echo $title; ?></h1>
            <?php endif; ?>

            <?php if ($text = get_field('text')): ?>
                <p class="banner-hero__text"><?php echo $text; ?></p>
            <?php endif; ?>
            <div class="banner-hero__btn">
                <?php if ($cta = get_field('button')): ?>
                    <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>"
                       class="banner-hero__cta btn-primary">
                        <?php echo $cta['title']; ?>
                    </a>
                <?php endif; ?>
                <?php if ($link = get_field('url')): ?>
                    <a  href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"
                       class="banner-hero__link btn-link">
                        <?php echo $link['title']; ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
        <div class="banner-hero__image">
            <?php if ($image = get_field('image')): ?>
                <img class="img-cover" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
            <?php endif; ?>
        </div>

    </div>

</div>