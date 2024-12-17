<?php //abbagalamaga
get_header();
global $wp_query;

$sort_orders = get_sort_orders();
$sort_filter = isset($_GET['sort_by']) ? $_GET['sort_by'] : false;

$guidelines = get_query_post_items('guidelines', get_search_query(), 6);
$faqs = get_query_post_items('faqs', get_search_query(), 4);
?>
    <section class="search-page">
        <div class="search-page__top-inner">

            <div class="search-page__title">
                <h1 class="page-title">
                    <?php _e('Search Result') ?>
                </h1>
            </div>
            <div class="search-page__search-bar-container">
                <form action="/">
                    <div class="search-page__search-bar-form">
                        <div class="search-page__search-bar-inner">
                            <div class="search-page__input-container">
                                <input class="search-page__search-bar" name="s" id="s"
                                       value="<?php echo get_search_query(); ?>"
                                       placeholder="What are you looking for?" type="text">
                                <button type="submit" class="search-page__search-icon-btn">
                                    <svg class="search-page__search-icon" width="22" height="22" viewBox="0 0 22 22"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.5692 18.1429C14.2835 18.1429 18.1406 14.2857 18.1406 9.57143C18.1406 4.85714 14.2835 1 9.5692 1C4.85491 1 0.997768 4.85714 0.997768 9.57143C0.997768 14.2857 4.85491 18.1429 9.5692 18.1429ZM9.5692 2.42857C13.4978 2.42857 16.7121 5.64286 16.7121 9.57143C16.7121 13.5 13.4978 16.7143 9.5692 16.7143C5.64063 16.7143 2.42634 13.5 2.42634 9.57143C2.42634 5.64286 5.64063 2.42857 9.5692 2.42857Z"
                                              fill="#9747FF" stroke="#9747FF"/>
                                        <path d="M20.2857 21.0001C20.5 21.0001 20.6429 20.9287 20.7857 20.7859C21.0714 20.5001 21.0714 20.0716 20.7857 19.7859L15.6429 14.643C15.3571 14.3573 14.9286 14.3573 14.6429 14.643C14.3571 14.9287 14.3571 15.3573 14.6429 15.643L19.7857 20.7859C19.9286 20.9287 20.0714 21.0001 20.2857 21.0001Z"
                                              fill="#9747FF" stroke="#9747FF"/>
                                    </svg>
                                </button>
                            </div>
                            <input name="sort_by" id="sort_by" placeholder="Sort By" type="hidden">
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="search-page__inner start-grid">

            <div class="search-page__action-panel">
                <div class="search-page__action-panel-count-res active" data-scroll-to="start-grid">
                    <?php _e('All Results') ?> <span><?php echo $wp_query->found_posts; ?></span>
                </div>

                <div class="search-page__action-panel-count-res" data-scroll-to="guidelines-grid">
                    <?php _e('Guidelines') ?> <span><?php echo $guidelines->found_posts; ?></span>
                </div>

                <div class="search-page__action-panel-count-res" data-scroll-to="faqs-grid">
                    <?php _e('FAQ') ?> <span><?php echo $faqs->found_posts; ?></span>
                </div>
            </div>
            <?php if ($guidelines->have_posts()): ?>
                <div class="search-page__action-title block-title-m guidelines-grid">
                    <?php _e('Guidelines') ?>

                    <?php if ($guidelines->found_posts > 6): ?>
                        <div class="search-page__action-title-link js-search-load-more" data-posttype="guidelines">
                            <?php _e('See ALl') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="search__items guidelines  js-items" data-posttype="guidelines">
                    <?php while ($guidelines->have_posts()): $guidelines->the_post(); ?>
                        <div class="post-item">

                            <div class="post-item__nav-item-inner">
                                <div class="post-item__nav-item-img-wrap col-center">
                                    <?php if ($icon = get_field('icon')): ?>
                                        <?php echo get_render_image($icon, 'full'); ?>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php the_permalink(); ?>"
                                   class="post-item__accordion-link">  <?php the_title(); ?>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

            <?php if ($faqs->have_posts()):
                $search_page = get_field('search_page', 'option') ?>
                <div class="search-page__action-title block-title-m faqs-grid">
                    <?php _e('Frequently Asked Questions') ?>

                    <?php if ($faqs->found_posts > 4): ?>
                        <div class="search-page__action-title-link js-search-load-more" data-posttype="faqs">
                            <?php _e('See ALl') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="search__items faqs js-items" data-posttype="faqs">
                    <?php while ($faqs->have_posts()): $faqs->the_post(); ?>
                        <div class="post-item">

                            <a class="post-item__title-link" target="_blank" 
                            href="<?php echo $search_page; ?>?faq=<?php echo get_the_ID(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

        </div>
    </section>
<?php
get_footer();