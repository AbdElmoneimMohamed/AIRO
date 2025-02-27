<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Rules\ValidAgeList;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuotationTest extends TestCase
{
    use RefreshDatabase;

    public function authenticateUser()
    {
        $user = User::factory()->create();

        return $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->json('data.token');
    }

    public function testItRequiresAllFieldsForQuotationRequest()
    {
        $token = $this->authenticateUser();

        $response = $this->postJson('/api/quotation', [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['age', 'currency_id', 'start_date', 'end_date']);
    }

    public function testItValidatesAgeFieldAsCommaSeparatedList()
    {
        $rule = new ValidAgeList();

        // Valid ages
        $this->assertTrue($rule->passes('age', '28,35'));
        $this->assertTrue($rule->passes('age', '18,70'));

        // Invalid cases
        $this->assertFalse($rule->passes('age', '17,35')); // Age below 18
        $this->assertFalse($rule->passes('age', '28,71')); // Age above 70
        $this->assertFalse($rule->passes('age', 'abc,25')); // Non-numeric input
        $this->assertFalse($rule->passes('age', '')); // Empty input
        $this->assertFalse($rule->passes('age', '-1,28')); // negative input
    }

    public function testItRejectsInvalidCurrency()
    {
        $token = $this->authenticateUser();

        $response = $this->postJson(
            '/api/quotation',
            [
                'age' => '28,35',
                'currency_id' => 'INVALID',
                'start_date' => '2024-03-01',
                'end_date' => '2024-03-10',
            ],
            [
                'Authorization' => "Bearer {$token}",
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['currency_id']);
    }

    public function testItRejectsInvalidDateRange()
    {
        $token = $this->authenticateUser();

        $response = $this->postJson('/api/quotation', [
            'age' => '28,35',
            'currency_id' => 'EUR',
            'start_date' => '2024-03-10',
            'end_date' => '2024-03-01', // End date is before start date
        ], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    public function testItCalculatesCorrectTotalBasedOnAgeBrackets()
    {
        $token = $this->authenticateUser();

        $response = $this->postJson('/api/quotation', [
            'age' => '28,35', // Age in two different brackets
            'currency_id' => 'EUR',
            'start_date' => '2020-10-01',
            'end_date' => '2020-10-30',
        ], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([

                'success',
                'message',
                'data' => ['total', 'currency_id', 'quotation_id'],
            ]);

        // Verify the total price calculation
        $tripLength = Carbon::parse('2020-10-01')->diffInDays(Carbon::parse('2020-10-30')) + 1;

        $expectedTotal = (3 * 0.6 * $tripLength) + (3 * 0.7 * $tripLength);

        $response->assertJson([
            'data' => [
                'total' => number_format($expectedTotal, 2),
            ],
        ]);
    }
}
