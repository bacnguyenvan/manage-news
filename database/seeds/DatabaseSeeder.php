<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ArticleSeeder::class);
        // $this->call(AuthorSeeder::class);
        // $this->call(ArticleClassSeeder::class);
        // $this->call(ArticleAuthorSeeder::class);
        // $this->call(ArticleArticleClassSeeder::class);
        // $this->call(TopicSeeder::class);
        // $this->call(BookletClassSeeder::class);
        $this->call(CommittMemberSeeder::class);
    }
}
