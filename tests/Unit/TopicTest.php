<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Topic;
use App\Models\User;
use Database\Seeders\TopicsSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\LikesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function topic_can_be_stored()
    {
        $this->seed(UsersSeeder::class);
        $this->actingAs(User::first());

        $this->post(route('topics.store'), [
            'title' => 'Test_title',
            'owner_id' => 1,
            'category_id' => 1,
        ]);

        $this->assertEquals(1, Topic::count());
    }

    /** @test */
    public function topic_can_not_be_stored_because_of_max_length()
    {
        $this->seed(UsersSeeder::class);
        $this->actingAs(User::first());

        $this->post(route('topics.store'), [
            'title' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magn Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magn Lorem ipsum dolor sit amet, consetetudtgt',
            'owner_id' => 1,
            'category_id' => 1,
        ]);

        $this->assertEquals(0, Topic::count());
    }

    /** @test */
    public function topic_can_be_updated()
    {
        $this->seed(TopicsSeeder::class);
        $this->seed(UsersSeeder::class);
        $this->actingAs(User::first());

        $newCategoryId = 2;

        $this->put(route('topics.update', 1), [
            'title' => 'new_title',
            'category_id' => $newCategoryId,
        ]);

        $this->assertEquals('new_title', Topic::first()->title);
        $this->assertEquals($newCategoryId + 1, Topic::first()->category_id);
    }

    /** @test */
    public function topic_can_be_deleted()
    {
        $this->seed(TopicsSeeder::class);
        $this->seed(UsersSeeder::class);
        $this->actingAs(User::first());

        $topicCountBeforeDelete = Topic::count();

        $this->delete(route('topics.destroy', Topic::first()));

        $this->assertEquals($topicCountBeforeDelete - 1, Topic::count());
    }

    /** @test */
    public function topic_has_like()
    {
        $this->seed();

        $likesCount = Topic::find(1)->likesCount;

        $checkLikes = !is_null($likesCount) && is_numeric($likesCount);

        $this->assertTrue($checkLikes);
    }

    /** @test */
    public function topic_has_isliked()
    {
        $this->seed();
        $this->actingAs(User::first());

        $this->assertArrayHasKey('isLiked', Topic::find(1));
    }

    /** @test */
    public function topic_like_can_be_toggled()
    {
        $this->seed();
        $this->seed(LikesSeeder::class);
        $this->actingAs(User::first());

        $likesCountBeforeUpdate = Topic::first()->likesCount;
        $this->put(route('topics.toggle-like', Topic::first()));
        $likesCountAfterUpdate = Topic::first()->likesCount;

        $this->assertEquals($likesCountBeforeUpdate - 1, $likesCountAfterUpdate);
    }
}
