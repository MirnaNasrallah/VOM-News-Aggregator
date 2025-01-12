<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Article::class;
    public function definition(): array
    {
        return [
            'article_id' => $this->faker->unique()->uuid,
            'title' => $this->faker->sentence,
            'source' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'author' => $this->faker->name,
            'published_at' => $this->faker->dateTime,
        ];
    }
}
