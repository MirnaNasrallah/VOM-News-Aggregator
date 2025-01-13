<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_paginated_articles()
    {
        // Arrange: create some articles
        Article::factory()->count(15)->create();

        // Act: make a GET request to fetch paginated articles
        $response = $this->getJson(route('articles.index'));

        // Assert: the response contains the correct structure for pagination
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',  // the actual articles
            'current_page',
            'last_page',
            'per_page',
            'total',
            // other pagination keys as needed
        ]);

        // Assert: the 'data' contains the expected number of articles per page
        $response->assertJsonCount(10, 'data');  // Assuming 10 articles per page
    }


    /** @test */
    public function it_filters_articles_by_source()
    {
        // Arrange: create articles with different sources
        $article1 = Article::factory()->create(['source' => 'The Guardian']);
        $article2 = Article::factory()->create(['source' => 'NewsAPI']);

        // Act: make a GET request with the source filter
        $response = $this->getJson(route('articles.index', ['source' => 'The Guardian']));

        // Assert: only articles from 'The Guardian' are returned
        $response->assertStatus(200);
        $response->assertJsonFragment(['source' => 'The Guardian']);
        $response->assertJsonMissing(['source' => 'NewsAPI']);
    }

    /** @test */
    public function it_filters_articles_by_date()
    {
        // Arrange: create articles with different dates
        $article1 = Article::factory()->create(['published_at' => '2025-01-01 00:00:00']);
        $article2 = Article::factory()->create(['published_at' => '2025-01-02 00:00:00']);

        // Act: make a GET request with the date filter
        $response = $this->getJson(route('articles.index', ['date' => '2025-01-01 00:00:00']));

        // Assert: only articles from '2025-01-01' are returned
        $response->assertStatus(200);
        $response->assertJsonFragment(['published_at' => '2025-01-01 00:00:00']);
        $response->assertJsonMissing(['published_at' => '2025-01-02 00:00:00']);
    }

    /** @test */
    public function it_filters_articles_by_category()
    {
        // Arrange: create articles with different categories
        $article1 = Article::factory()->create(['category' => 'Technology']);
        $article2 = Article::factory()->create(['category' => 'Science']);

        // Act: make a GET request with the category filter
        $response = $this->getJson(route('articles.index', ['category' => 'Technology']));

        // Assert: only articles from 'Technology' category are returned
        $response->assertStatus(200);
        $response->assertJsonFragment(['category' => 'Technology']);
        $response->assertJsonMissing(['category' => 'Science']);
    }

    /** @test */
    public function it_returns_single_article()
    {
        // Arrange: create an article
        $article = Article::factory()->create();

        // Act: make a GET request to fetch the article by ID
        $response = $this->getJson(route('articles.show', $article->id));

        // Assert: the response contains the article's data
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $article->title]);
    }

    /** @test */
    public function test_it_returns_404_if_article_not_found()
    {
        $response = $this->json('GET', '/api/articles/99999'); // Assuming 999 does not exist

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Article not found',
                 ]);
    }




}
