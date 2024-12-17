<form id="movies-filters-form" class="movies-filters">
    <div class="movies-filters__title">
        FILTER:
    </div>
    <div class="movies-filters__inner">

        <div class="movies-filters__item">
            <label for="genre">Genre:</label>
            <div class="select-wrapper">
                <select id="genre" name="genre">
                    <option value="">All</option>
                    <?php
                    $terms = get_terms(['taxonomy' => 'genre', 'hide_empty' => false]);
                    foreach ($terms as $term): ?>
                        <option value="<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <svg class="select-arrow" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.7889 7.80188L9.03894 11.5519L5.28894 7.80188L12.7889 7.80188Z" fill="#2F2105"/>
                </svg>
            </div>
        </div>
        <div class="movies-filters__year">
            <div class="movies-filters__item">
                <label for="year-from">Year From:</label>
                <div class="select-wrapper">
                    <select id="year-from" name="year_from">
                        <option value="">All</option>
                        <?php
                        $years = get_unique_years('ASC');
                        foreach ($years as $year): ?>
                            <option value="<?php echo esc_attr($year); ?>">
                                <?php echo esc_html($year); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <svg class="select-arrow" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.7889 7.80188L9.03894 11.5519L5.28894 7.80188L12.7889 7.80188Z" fill="#2F2105"/>
                    </svg>
                </div>
            </div>
            <div class="movies-filters__item">
                <label for="year-to">Year To:</label>
                <div class="select-wrapper">
                    <select id="year-to" name="year_to">
                        <option value="">All</option>
                        <?php
                        $years = get_unique_years('DESC');
                        foreach ($years as $year): ?>
                            <option value="<?php echo esc_attr($year); ?>">
                                <?php echo esc_html($year); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <svg class="select-arrow" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.7889 7.80188L9.03894 11.5519L5.28894 7.80188L12.7889 7.80188Z" fill="#2F2105"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="movies-filters__actions">
        <button type="submit" class="movies-filters__apply btn-primary">Apply</button>
    </div>
</form>