<?php

namespace Database\Seeders;

use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $testUser */
        $testUser = User::query()
            ->where('name', '=', 'Test User')
            ->firstOrFail();

        $users = User::query()
            ->whereKeyNot($testUser)
            ->inRandomOrder()
            ->get();

        /** @var User $firstUsers */
        /** @var User $secondUser */
        /** @var User $thirdUser */
        [$firstUsers, $secondUser, $thirdUser] = $users->slice(0, 3);

        $this->storeChat($testUser, $firstUsers, 100);
        $this->storeChat($secondUser, $testUser, rand(50, 100));
        $this->storeChat($secondUser, $thirdUser, 50);

        $users->slice(4)
            ->each(fn (User $user) => $this->storeChat($testUser, $user, rand(0, 100)));
    }

    protected function storeChat($user1, $user2, $messagesCount = 2): void
    {
        tap(Chat::factory()
            ->hasAttached([$user1, $user2])
            ->create(), function (Chat $chat) use ($messagesCount) {
                for ($i = 0; $i < $messagesCount; $i++) {
                    Message::factory()
                        ->for($chat)
                        ->for($chat->users->random(), 'sender')
                        ->create();
                }
            });
    }
}
