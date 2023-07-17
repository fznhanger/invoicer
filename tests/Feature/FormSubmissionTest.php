<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FormSubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_form()
    {
        Mail::fake();

        $faker = \Faker\Factory::create();
        return redirect('/form', [
            'invoice-number' => $faker->unique()->randomNumber(),
            'amount' => $faker->unique()->randomNumber(),
            'address' => $faker->address(),
            'invoice-date' => $faker->date(),
            'description' => $faker->sentence(),
        ]);
    }
}
