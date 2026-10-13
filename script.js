
document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("searchInput");
    const searchMessage = document.getElementById("searchMessage");

    const grid = document.getElementById("businessGrid");
    const previousButton = document.getElementById("prevBusinesses");
    const nextButton = document.getElementById("nextBusinesses");
    const status = document.getElementById("carouselStatus");

    if (!grid) return;

    const cards = Array.from(grid.querySelectorAll(".business-card"));

    let currentPage = 0;
    let visibleCount = 4;
    let filteredCards = [...cards];

    // Number of cards shown according to screen width
function updateVisibleCount() {
    if (window.innerWidth <= 600) {
        visibleCount = 1;
    } else if (window.innerWidth <= 1000) {
        visibleCount = 2;
    } else {
        visibleCount = 3;
    }

    currentPage = 0;
    renderCards();
}

    // Display the current carousel page
    function renderCards() {
        const totalPages = Math.max(
            1,
            Math.ceil(filteredCards.length / visibleCount)
        );

        currentPage = Math.min(currentPage, totalPages - 1);

        cards.forEach(card => {
            card.hidden = true;
        });

        const start = currentPage * visibleCount;
        const currentCards = filteredCards.slice(
            start,
            start + visibleCount
        );

        currentCards.forEach(card => {
            card.hidden = false;
        });

        if (previousButton) {
            previousButton.disabled =
                currentPage === 0 || filteredCards.length === 0;
        }

        if (nextButton) {
            nextButton.disabled =
                currentPage >= totalPages - 1 ||
                filteredCards.length === 0;
        }

        if (status) {
            status.textContent = filteredCards.length
                ? `Showing ${start + 1}–${Math.min(
                    start + visibleCount,
                    filteredCards.length
                )} of ${filteredCards.length} businesses`
                : "No businesses found.";
        }

        if (searchMessage) {
            searchMessage.textContent = filteredCards.length
                ? `${filteredCards.length} sample listing(s) found.`
                : "No matching sample listings. Try another search.";
        }
    }

    // Search and filter the business cards
    function searchBusinesses(query) {
        const term = query.trim().toLowerCase();

        filteredCards = cards.filter(card => {
            const category = (
                card.dataset.category || ""
            ).toLowerCase();

            const content = card.textContent.toLowerCase();

            return (
                !term ||
                category.includes(term) ||
                content.includes(term)
            );
        });

        currentPage = 0;
        renderCards();
    }

    // Search form
    if (searchForm && searchInput) {
        searchForm.addEventListener("submit", event => {
            event.preventDefault();

            searchBusinesses(searchInput.value);

            document.getElementById("businesses")
                ?.scrollIntoView({ behavior: "smooth" });
        });
    }

    // Category buttons, popular searches and Explore buttons
    document.querySelectorAll("[data-search]").forEach(button => {
        button.addEventListener("click", () => {
            const term = button.dataset.search || "";

            if (searchInput) {
                searchInput.value = term;
            }

            searchBusinesses(term);

            document.getElementById("businesses")
                ?.scrollIntoView({ behavior: "smooth" });
        });
    });

    // Previous page
    if (previousButton) {
        previousButton.addEventListener("click", () => {
            if (currentPage > 0) {
                currentPage--;
                renderCards();
            }
        });
    }

    // Next page
    if (nextButton) {
        nextButton.addEventListener("click", () => {
            const totalPages = Math.ceil(
                filteredCards.length / visibleCount
            );

            if (currentPage < totalPages - 1) {
                currentPage++;
                renderCards();
            }
        });
    }

    // Update layout when the browser is resized
    window.addEventListener("resize", updateVisibleCount);

    updateVisibleCount();
});
