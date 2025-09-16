 // Save recipe to favorites
function saveFavorite(title, url, image) {
    fetch('favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `title=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}&image=${encodeURIComponent(image)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("✅ Recipe saved to favorites!");
        } else {
            alert("⚠️ Error saving recipe.");
        }
    })
    .catch(() => alert("⚠️ Error connecting to server."));
}

// Dark mode toggle
document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const toggleBtn = document.getElementById('darkModeToggle');
    if (!toggleBtn) return;

    // Apply saved theme
    const saved = localStorage.getItem('theme');
    if (saved === 'dark') body.classList.add('dark-mode');
    toggleBtn.textContent = body.classList.contains('dark-mode') ? '☀️ Light Mode' : '🌙 Dark Mode';

    // Toggle theme on click
    toggleBtn.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        const now = body.classList.contains('dark-mode') ? 'dark' : 'light';
        localStorage.setItem('theme', now);
        toggleBtn.textContent = now === 'dark' ? '☀️ Light Mode' : '🌙 Dark Mode';
    });
});

// Recipe search
document.getElementById('searchBtn').addEventListener('click', function () {
    const ingredients = document.getElementById('ingredients').value.trim();
    const cuisine = document.getElementById('cuisine').value;
    const diet = document.getElementById('diet').value;

    if (ingredients === "") {
        alert("⚠️ Please enter some ingredients!");
        return;
    }

    const spinner = document.getElementById('loading_spinner');
    if (spinner) spinner.style.display = 'flex';

    const query = `ingredients=${encodeURIComponent(ingredients)}&cuisine=${encodeURIComponent(cuisine)}&diet=${encodeURIComponent(diet)}`;

    fetch(`search.php?${query}`)
        .then(response => response.json())
        .then(data => {
            const recipesDiv = document.getElementById('recipes');
            recipesDiv.innerHTML = "";

            if (!data.results || data.results.length === 0) {
                recipesDiv.innerHTML = "<p>No recipes found.</p>";
            } else {
                data.results.forEach(recipe => {
                    const recipeCard = document.createElement('div');
                    recipeCard.className = 'recipe-card';
                    recipeCard.innerHTML = `
                        <img src="${recipe.image}" alt="${recipe.title}">
                        <h3>${recipe.title}</h3>
                        <a href="${recipe.sourceUrl}" target="_blank">View Recipe</a>
                        <button class="save-btn">Save</button>
                    `;
                    recipesDiv.appendChild(recipeCard);

                    // Attach click listener for saving
                    recipeCard.querySelector('.save-btn').addEventListener('click', () => {
                        saveFavorite(recipe.title, recipe.sourceUrl, recipe.image);
                    });
                });
            }
        })
        .catch(() => {
            alert("⚠️ Error fetching data.");
        })
        .finally(() => {
            if (spinner) spinner.style.display = 'none';
        });
});