<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Silber\Bouncer\BouncerFacade as Bouncer;

use App\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	// Creating Default Roles
        $adminRole = Bouncer::role()->firstOrCreate([
		    'name' => 'administrator',
		    'title' => 'Administrator',
		]);

		$userManagerRole = Bouncer::role()->firstOrCreate([
		    'name' => 'user-manager',
		    'title' => 'User Manager',
		]);

		$shopManagerRole = Bouncer::role()->firstOrCreate([
		    'name' => 'shop-manager',
		    'title' => 'Shop Manager',
		]);

		// Create Default Users
		$administrator = User::updateOrCreate(['email'=>'administrator@example.com'],['name'=>'Administrator', 'email_verified_at' => now(), 'password'=>Hash::make('password')])->assign($adminRole);
		$userManager = User::updateOrCreate(['email'=>'user-manager@example.com'],['name'=>'User Manager', 'email_verified_at' => now(), 'password'=>Hash::make('password')])->assign($userManagerRole);
		$shopManager = User::updateOrCreate(['email'=>'shop-manager@example.com'],['name'=>'Shop Manager', 'email_verified_at' => now(), 'password'=>Hash::make('password')])->assign($shopManagerRole);

		// Create default customers
		$customers = factory(Customer::class, 200)->create();

		// Create default products
		$products = factory(Product::class, 100)->create();

		// Create default orders
		$faker = \Faker\Factory::create();
		$statuses = ['new','processed'];

		for ($i = 1; $i <= 50; $i++) {
			$total_amount = $faker->randomNumber(3);
			$order = Order::create([
				'customer_id' => Customer::inRandomOrder()->first()->id,
				'invoice_number' => 'INV'.$faker->randomNumber(4), 
				'total_amount' => $total_amount, 
				'status' => $statuses[array_rand($statuses)],
			]);

			for ($j=1; $j <= 2; $j++) { 
				$order->orderItems()->create([
					'product_id' => Product::inRandomOrder()->where(['in_stock'=>1])->first()->id,
					'quantity' => 1
				]);
			}
		}
    }
}
