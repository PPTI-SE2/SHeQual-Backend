<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post = Post::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        
        $alreadyLiked = Like::where('posts_id', $post->id)->where('users_id', $user->id)->exists();

        if (!$alreadyLiked) {
            return [
                'posts_id' => $post->id,
                'users_id' => $user->id,
            ];
        }
    }
}
