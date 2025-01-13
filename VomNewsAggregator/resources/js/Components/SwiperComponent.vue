<template>
    <div class="swiper-container">
      <swiper
        :slides-per-view="3"
        space-between="30"
        :pagination="{ clickable: true }"
        loop


      >
        <swiper-slide v-for="article in articles" :key="article.id">
          <div class="article-card">
            <router-link :to="`/articles/${article.id}`">
              <img :src="article.thumbnail" alt="Thumbnail" />
            </router-link>
            <h3>{{ article.title }}</h3>
          </div>
        </swiper-slide>
      </swiper>
    </div>
  </template>


<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import axios from 'axios';

export default {
    components: { Swiper, SwiperSlide },
    data() {
        return {
            articles: [],
        };
    },
    mounted() {
        axios.get('http://127.0.0.1:8000/api/featured')
            .then(response => {
                this.articles = response.data;
            })
            .catch(error => {
                console.error('Error fetching articles:', error);
            });
    },
};
</script>
<style scoped>
.swiper-container {
    width: 100%;
    height: auto;

    padding: 20px;
}

.swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 300px;
}

.article-card {
    text-align: center;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    max-width: 90%;
    margin: auto;
}

.article-card:hover {
    transform: translateY(-10px);
}

img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.article-card h3 {
    padding: 10px;
    font-weight: 700;

}

/* Media query for mobile devices */
@media (max-width: 768px) {
    .swiper-slide {
        flex: 0 0 100%; /* Show only one article at a time */
        width: 100%;
    }
}

</style>
