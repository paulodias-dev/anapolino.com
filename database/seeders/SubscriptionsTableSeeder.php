<?php

namespace Database\Seeders;

use App\Models\Core\Subscription;
use App\Models\Core\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('email', '!=', 'admin@anapolino.com.br')->get();
        $plans = Plan::all();

        foreach ($users as $user) {
            $plan = $plans->random();

            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'status' => 'active',
                'starts_at' => now(),
                'expires_at' => $plan->name === 'Grátis'
                    ? now()->addMonth()
                    : now()->addYear(),
                'auto_renew' => $plan->name !== 'Grátis',
            ]);
        }
    }
}
