<template>
    <div>

      <header class="website-overview" v-if="!isArticleView">
        <h1>Welcome to VoM News Aggregator</h1>
        <p>Explore news from The Guardian, NewsAPI, and New York Times.</p>
      </header>

      <section class="featured-articles" v-if="!isArticleView">
        <h2>Featured Articles</h2>
        <SwiperComponent />
      </section>

      <section class="articles-list" v-if="!isArticleView">
        <h2>All Articles</h2>
        <ArticlesListComponent />
      </section>

      <section v-if="isArticleView">
        <router-link :to="`/`"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</router-link>
        <ArticleViewComponent :id="this.$route.params.id"/>
      </section>
    </div>
  </template>

  <script>
  import SwiperComponent from './SwiperComponent.vue';
  import ArticlesListComponent from './ArticlesList.vue';
  import ArticleViewComponent from './ArticleViewComponent.vue';

  export default {
    components: {
      SwiperComponent,
      ArticlesListComponent,
      ArticleViewComponent
    },
    computed: {
      isArticleView() {
        return this.$route.name === 'article-view';
      },
    },
  };
  </script>


  <style scoped>
  /* General Reset */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  /* Website Overview */
  .website-overview {
    text-align: center;
    padding: 40px 20px;
    background-image: linear-gradient(to bottom right, #07294d, #6491c2);
    color: #fff;
    border-radius: 10px;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
  }

  .website-overview h1 {
    font-size: 36px;
    margin-bottom: 10px;
    font-weight: bold;
    letter-spacing: 1px;
  }

  .website-overview p {
    font-size: 18px;
    margin-bottom: 0;
    opacity: 0.9;
  }

  /* Featured Articles Section */
  .featured-articles {
    padding: 30px;
    background-color: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 40px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  }

  .featured-articles h2 {
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
    text-transform: uppercase;
  }

  /* Articles List Section */
  .articles-list {
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  }

  .articles-list h2 {
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
    text-transform: uppercase;
  }
  </style>
