
const searchForm = document.getElementById("searchForm");
const searchInput = document.getElementById("searchInput");
const businessCards = document.querySelectorAll(".business-card");
const searchMessage = document.getElementById("searchMessage");

function searchBusinesses(query) {
    const term = query.trim().toLowerCase();
    let visibleCount = 0;

    businessCards.forEach((card) => {
        const category = card.dataset.category.toLowerCase();
        const content = card.textContent.toLowerCase();

        const matches =
            !term ||
            category.includes(term) ||
            content.includes(term);

        card.hidden = !matches;

        if (matches) {
            visibleCount++;
        }
    });

    searchMessage.textContent = visibleCount
        ? `${visibleCount} sample listing(s) found.`
        : "No matching sample listings. Try Doctors, Restaurants or Salons.";

    document.getElementById("businesses").scrollIntoView({
        behavior: "smooth"
    });
}

searchForm.addEventListener("submit", (event) => {
    event.preventDefault();
    searchBusinesses(searchInput.value);
});

document.querySelectorAll("[data-search]").forEach((button) => {
    button.addEventListener("click", () => {
        const term = button.dataset.search;
        searchInput.value = term;
        searchBusinesses(term);
    });
});
