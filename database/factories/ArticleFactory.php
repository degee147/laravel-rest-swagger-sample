<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        $title = $this->faker->sentence();
        $slug = Str::slug($title, '-');
        return [
            "title" => $title,
            "slug" => $slug,
            "thumbnail" => "https://via.placeholder.com/150x150",
            "cover" => "https://via.placeholder.com/400x200",
            "body" => $this->faker->paragraphs(3, true)
        ];
    }
}
