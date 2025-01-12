import { createRouter, createWebHistory } from 'vue-router';
import MainPage from './components/MainPage.vue';
import ArticleViewComponent from './components/ArticleViewComponent.vue';

const routes = [
  { path: '/', component: MainPage },
  { path: '/articles/:id', name: 'article-view', component: ArticleViewComponent, props: true },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
