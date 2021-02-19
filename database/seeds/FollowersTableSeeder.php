<?php

use App\Models\User;
use Illuminate\Database\Seeder;


class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $user = User::first();
        $user_id = $user->id;

        //给用户1加关注其他用户 
        $followers = $users->slice(1);
        $followers_ids = $followers->pluck('id')->toArray();
        $user->follow($followers_ids);

        //其他用户关注1
        foreach ($followers as  $follower) {
            $follower->follow($user_id);
        }
    }
}
