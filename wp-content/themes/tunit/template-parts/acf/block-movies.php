<div class="block-movies">
    <div class="block-movies__inner inner">
        <?php if ($title = get_field('title')): ?>
            <h1 class="block-movies__title block-title centered"><?php echo $title; ?></h1>
        <?php endif; ?>
        <div class="block-movies__container">
            <div class="block-movies__filters">
                <?php get_template_part('template-parts/helpers/filters/search-form'); ?>
                <?php get_template_part('template-parts/helpers/filters/filters-form'); ?>
            </div>
            <div class="block-movies__content">
                <?php get_template_part('template-parts/helpers/filters/sorting-dropdown'); ?>
                <div class="movies-list" id="movies-container">
                    <!-- Movies will be dynamically loaded here -->
                </div>
                <div class="block-movies__load-more">
                    <button id="load-more" class="movies-load-more btn-primary" data-page="1">Load more</button>
                </div>
            </div>
        </div>
    </div>
</div>