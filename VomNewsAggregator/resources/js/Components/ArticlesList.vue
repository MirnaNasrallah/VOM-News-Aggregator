<template>
    <div>
        <!-- Filter Section -->
        <div class="filters">
            <label for="source">Source:</label>
            <select v-model="filters.source" id="source">
                <option value="">All</option>
                <option value="The Guardian">The Guardian</option>
                <option value="NewsAPI">NewsAPI</option>
                <option value="New York Times">New York Times</option>
            </select>

            <label for="date">Date:</label>
            <input type="date" v-model="filters.date" id="date" />

            <label for="category">Category:</label>
            <input type="text" v-model="filters.category" id="category" placeholder="e.g., Politics" />

            <button @click="fetchArticles">Apply Filters</button>
            <button @click="resetFilters">Clear Filters</button>
        </div>

        <!-- Articles Grid -->
        <div class="articles-grid">
            <div v-for="article in articles" :key="article.id" class="article-card">
                <img :src="article.thumbnail" alt="Thumbnail">

                <h3>{{ truncateText(article.title, 25) }}</h3>
                <p>{{ truncateText(article.description, 200) }}</p>
                <div class="read-more">
                    <router-link :to="`/articles/${article.id}`">Read More</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            articles: [],
            filters: {
                source: '',
                date: '',
                category: '',
            },
        };
    },
    methods: {
        fetchArticles() {
            const params = new URLSearchParams();
            if (this.filters.source) params.append('source', this.filters.source);
            if (this.filters.date) params.append('date', this.filters.date);
            if (this.filters.category) params.append('category', this.filters.category);

            const queryString = params.toString();
            const url = queryString
                ? `http://127.0.0.1:8000/api/articles?${queryString}`
                : `http://127.0.0.1:8000/api/articles`;

            axios
                .get(url)
                .then(response => {
                    this.articles = response.data;
                })
                .catch(error => {
                    console.error('Error fetching articles:', error);
                });
        },
        resetFilters() {
            this.filters.source = '';
            this.filters.date = '';
            this.filters.category = '';
            this.fetchArticles();
        },
        truncateText(text, maxLength) {
            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        },
    },
    mounted() {
        this.fetchArticles();
    },
};
</script>


<style scoped>
/* Filter Section */
.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 30px;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.filters label {
    font-weight: bold;
    margin-right: 8px;
}

.filters select,
.filters input,
.filters button {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
    transition: all 0.3s ease;
}

.filters select:hover,
.filters input:hover,
.filters button:hover {
    border-color: #007bff;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
}

.filters button {
    background-image: linear-gradient(to bottom right, #07294d, #6491c2);
    color: white;
    cursor: pointer;
    font-weight: bold;
    border: none;
}

.filters button:hover {
    background-image: linear-gradient(to bottom right, #6491c2, #07294d);
}

/* Articles Grid */
.articles-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.article-card {
    flex: 1 1 calc(33.333% - 20px);
    max-width: 350px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    position: relative;
    padding-bottom: 50px;
}

.article-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
}

h3 {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0;
    color: #333;
}

p {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
}

.router-link {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

.router-link:hover {
    text-decoration: underline;
}
.read-more{
    position: absolute; left: 0; width: 100%; bottom: 0;
    margin-bottom: 15px;

}

.read-more a {
    background-image: linear-gradient(to bottom right, #07294d, #6491c2);
    padding: 10px;
    color: white;
    font-weight: 200;
    border-radius: 5px;
   margin: 0 auto; text-align: 'center';

}
</style>
