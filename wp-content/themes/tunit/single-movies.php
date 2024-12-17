<?php
/**
 * Single Movie Template
 */

get_header(); ?>
    <section class="single-movie">
        <div class="single-movie__inner inner">
            <h1 class="single-movie__title block-title centered"><?php the_title(); ?></h1>
            <div class="single-movie__content-wrap">
                <?php if ($poster = get_field('poster')) : ?>
                    <div class="single-movie__image">
                        <?php if ($rating = get_field('rating')) : ?>
                            <div class="movie-item-rating post">
                                <p><?php echo esc_html($rating); ?></p>
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.36363 1.53594C7.55029 1.0436 8.25671 1.0436 8.44396 1.53594L9.65146 4.88077C9.69358 4.98973 9.76776 5.08335 9.8642 5.14928C9.96064 5.2152 10.0748 5.25033 10.1916 5.25002H13.159C13.7074 5.25002 13.9465 5.93252 13.5155 6.26677L11.4038 8.16669C11.3092 8.2394 11.2401 8.34021 11.2063 8.45465C11.1726 8.56909 11.176 8.69128 11.216 8.80369L11.9871 12.0721C12.175 12.5971 11.5671 13.048 11.1075 12.7249L8.23921 10.9049C8.14098 10.8358 8.02385 10.7988 7.90379 10.7988C7.78373 10.7988 7.6666 10.8358 7.56838 10.9049L4.70013 12.7249C4.24104 13.048 3.63263 12.5965 3.82046 12.0721L4.59163 8.80369C4.63163 8.69128 4.635 8.56909 4.60126 8.45465C4.56751 8.34021 4.49838 8.2394 4.40379 8.16669L2.29213 6.26677C1.86046 5.93252 2.10079 5.25002 2.64796 5.25002H5.61538C5.73221 5.25041 5.84641 5.21531 5.94287 5.14938C6.03932 5.08344 6.11349 4.98978 6.15554 4.88077L7.36304 1.53594H7.36363Z"
                                          fill="#FFD057" stroke="#FFD057" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>

                            </div>
                        <?php endif; ?>
                        <img src="<?php echo $poster['url']; ?>" alt="<?php the_title(); ?>">
                    </div>
                <?php endif; ?>
                <div class="single-movie__content">
                    <div class="single-movie__category ">
                        <div class="single-movie__category-inner body-font-m">
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'genre'); // Fetch terms associated with the current post
                            if ($terms && !is_wp_error($terms)) : ?>
                                <div class="single-movie__category body-font-m">
                                    <div class="single-movie__genre">Genre:</div>
                                    <div class="single-movie__category-inner body-font-m">
                                        <?php
                                        foreach ($terms as $term) {
                                            echo esc_html($term->name);
                                            if (end($terms) !== $term) {
                                                echo ', '; // Add comma between multiple terms
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                    <?php if ($dt = get_field('date')) : ?>
                        <div class="single-movie__date-release body-font-m">
                            <div class="single-movie__date-name">
                                Release Date:
                            </div>
                            <div class="single-movie__date body-font-m">
                                <?php echo $dt; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($year = get_field('year')) : ?>
                        <div class="single-movie__year body-font-m">
                            <div class="single-movie__year-name">
                                Year:
                            </div>
                            <div class="single-movie__year-inner body-font-m">
                                <?php echo $year; ?>
                            </div>

                        </div>
                    <?php endif; ?>

                    <?php if ($ds = get_field('description')) : ?>

                        <div class="single-movie__description wysiwyg-styles">
                            <?php echo $ds; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php get_footer();
