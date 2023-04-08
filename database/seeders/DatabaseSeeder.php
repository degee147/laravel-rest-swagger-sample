<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;

class DatabaseSeeder extends Seeder
{
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory(50)->create();
        for ($i = 0; $i < 50; $i++) {

            $title = $this->faker->sentence();
            $slug = Str::slug($title, '-');


            $article = Article::create([
                "title" => $title,
                "slug" => $slug,
                "thumbnail" => "https://via.placeholder.com/150x150",
                "cover" => "https://via.placeholder.com/400x200",
                "body" => $this->faker->paragraphs(3, true)
            ]);

            $tag = Tag::find(rand(0, 50));
            $article->tags()->attach($tag);

        }
    }
}
