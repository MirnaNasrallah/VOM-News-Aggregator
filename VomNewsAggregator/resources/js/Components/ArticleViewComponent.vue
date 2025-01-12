<template>
    <div v-if="article" class="single-article">
      <img :src="article.thumbnail" alt="Thumbnail">
      <h1>{{ article.title }}</h1>
      <p><strong>Source:</strong> {{ article.source }}</p>
      <p><strong>Category:</strong> {{ article.category }}</p>
      <p><strong>Author:</strong> {{ article.author }}</p>
      <p><strong>Published at:</strong> {{ article.published_at }}</p>
      <p>{{ article.description }}</p>
      <p>{{ article.content }}</p>
      <a :href="article.url" target="_blank" class="read-more">Read Full Article</a>
    </div>
    <div v-else>
      <p>Loading article...</p>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    props: ['id'],
    data() {
      return {
        article: null,
      };
    },
    mounted() {
      axios
        .get(`http://127.0.0.1:8000/api/articles/${this.id}`)
        .then(response => {
          this.article = response.data;
        })
        .catch(error => {
          console.error('Error fetching the article:', error);
        });
    },
  };
  </script>

  <style scoped>
  .single-article {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
  }

  img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 20px;
  }

  h1 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
  }

  p {
    font-size: 16px;
    margin: 5px 0;
    color: #666;
  }

  .read-more {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-image: linear-gradient(to bottom right, #07294d, #6491c2);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
  }

  .read-more:hover {
    background-color: #0056b3;
  }
  </style>
