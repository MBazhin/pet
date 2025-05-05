<?php

namespace Database\Seeders;

use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Throwable;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            /** @var User $testUser */
            $testUser = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        } catch (Throwable) {}

        User::factory(rand(5, 10))->create();

        /** @var User $firstUsers */
        /** @var User $secondUser */
        /** @var User $thirdUser */
        [$firstUsers, $secondUser, $thirdUser] = User::query()
            ->whereKeyNot($testUser->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        tap(Chat::factory()
            ->hasAttached([$testUser, $firstUsers])
            ->create(), fn (Chat $chat) => $chat
                ->users
                ->each(fn (User $user) => Message::factory()
                    ->for($chat)
                    ->for($user, 'sender')
                    ->create()
                ));

        tap(Chat::factory()
            ->hasAttached([$secondUser, $testUser])
            ->create(), fn (Chat $chat) => $chat
                ->users
                ->each(fn (User $user) => Message::factory()
                    ->for($chat)
                    ->for($user, 'sender')
                    ->create()
                ));

        tap(Chat::factory()
            ->hasAttached([$secondUser, $thirdUser])
            ->create(), fn (Chat $chat) => $chat
                ->users
                ->each(fn (User $user) => Message::factory()
                    ->for($chat)
                    ->for($user, 'sender')
                    ->create()
                ));
    }
}
