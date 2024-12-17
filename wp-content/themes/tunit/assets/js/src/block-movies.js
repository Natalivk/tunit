document.addEventListener("DOMContentLoaded", function () {
    const moviesContainer = document.getElementById("movies-container");
    const loadMoreBtn = document.getElementById("load-more");
    const filtersForm = document.getElementById("movies-filters-form");
    const sortBySelect = document.getElementById("sort-by");
    const searchInput = document.getElementById("search");
    let page = 1;
    let currentSort = 'rating_desc'; // Default sort order
    let currentSearch = ''; // Default search query

    // Fetch movies via AJAX
    function fetchMovies(reset = false) {
        const formData = new FormData();
        formData.append("action", "fetch_movies");
        formData.append("page", page);

        // Include filters and sort values
        const genre = document.getElementById("genre").value || '';
        const yearFrom = document.getElementById("year-from").value || '';
        const yearTo = document.getElementById("year-to").value || '';

        formData.append("genre", genre);
        formData.append("year_from", yearFrom);
        formData.append("year_to", yearTo);
        formData.append("sort_by", currentSort);
        formData.append("search", currentSearch);

        fetch(movies_ajax.ajaxurl, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (reset) {
                    moviesContainer.innerHTML = ''; // Clear container on reset
                    page = 1; // Reset page counter
                }

                if (data.html) {
                    moviesContainer.insertAdjacentHTML("beforeend", data.html);
                    page++;
                }

                // Toggle "Load More" button visibility
                loadMoreBtn.style.display = data.has_more_posts ? "block" : "none";
            })
            .catch((error) => console.error("Error fetching movies:", error));
    }

    // Event listener for Load More button
    loadMoreBtn.addEventListener("click", function () {
        fetchMovies();
    });

    // Event listener for filters form submission (Apply button)
    filtersForm.addEventListener("submit", function (e) {
        e.preventDefault();
        page = 1; // Reset page counter
        fetchMovies(true); // Fetch movies based on filters and search
    });

    // Event listener for sorting dropdown
    sortBySelect.addEventListener("change", function () {
        currentSort = sortBySelect.value; // Update current sort value
        page = 1; // Reset page counter
        fetchMovies(true); // Fetch movies based on new sort value
    });

    // Event listener for search input
    searchInput.addEventListener("input", function () {
        currentSearch = searchInput.value; // Update current search query
        page = 1; // Reset page counter
        fetchMovies(true); // Fetch movies based on search query
    });

    // Initial fetch
    fetchMovies(true);


// Select box wrapper interaction
    const selectWrappers = document.querySelectorAll(".select-wrapper");
    selectWrappers.forEach((wrapper) => {
        const select = wrapper.querySelector("select");

        // Add 'active' class on focus
        select.addEventListener("focus", () => wrapper.classList.add("active"));

        // Remove 'active' class on blur
        select.addEventListener("blur", () => wrapper.classList.remove("active"));

    });
});


