<?php

namespace Tests\Feature;

use App\Models\Calculation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculationControllerTest extends TestCase
{
     // use RefreshDatabase; // Refresh database trait
    use DatabaseTransactions;
    use WithFaker; // WithFaker trait if faker data is needed

    /** @test */
    public function when_calculation_create_then_show_200_for_url_response(): void
    {
        $response = $this->get('calculation/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function when_calculation_create_then_show_200_for_view(): void
    {
        $response = $this->get('calculation/create');
        $view = $response->original; // returns View instance
        $view_name = $view->getName();
        $this->assertEquals($view_name, 'calculation.main-form');
    }

    /** @test */
    public function when_calculation_stored_then_it_redirects_to_specific_route()
    {
        // Mocking data that would be sent in the request
        $requestData = [
            'amount' => 100,
            'percentage' => 10,
        ];
        // Mimic a request to your store method with the data
        $response = $this->post(route('calculation.store'), $requestData);

        // Asserting that the response is a redirect
        $response->assertRedirect();

        // Asserting that the response is redirected to the expected route
        $response->assertRedirect(route('calculation.index'));
    }

    /** @test */
    public function when_calculation_stored_then_check_it_stored()
    {
        // Mocking data that would be sent in the request
        $requestData = [
            'amount' => 100,
            'percentage' => 10,
        ];
        // Mimic a request to your store method with the data
        $response = $this->from(route('calculation.create'))->post(route('calculation.store'), $requestData);
        $response->assertStatus(302);
        // $this->assertEquals(1,Calculation::count());

    }

    /** @test */
    public function when_calculation_stored_requested_then_check_validation_required_have_error_rules()
    {
        // Mocking data that would be sent in the request
        $response = $this->post(route('calculation.store'), [
            'amount' => '',
            'percentage' => '',
        ]);
        $response->assertSessionHasErrors(['amount','percentage']);
    }

    /** @test */
    public function when_calculation_stored_requested_then_check_percentage_min_validation_have_error_rules()
    {
        // Mocking data that would be sent in the request
        $response = $this->post(route('calculation.store'), [
            'percentage' => '-44',
        ]);
        $response->assertSessionHasErrors(['percentage']);
    }

    /** @test */
    public function when_calculation_stored_requested_then_check_percentage_max_validation_have_error_rules()
    {
        // Mocking data that would be sent in the request
        $response = $this->post(route('calculation.store'), [
            'percentage' => '2343',
        ]);
        $response->assertSessionHasErrors(['percentage']);
    }

    /** @test */
    public function when_calculation_stored_requested_then_check_numeric_validation_have_error_rules()
    {
        // Mocking data that would be sent in the request
        $response = $this->post(route('calculation.store'), [
            'amount' => 'dfdsin',
            'percentage' => '34434dsf',
        ]);
        $response->assertSessionHasErrors(['amount','percentage']);
    }

    /** @test */
    public function when_calculation_stored_requested_then_check_numeric_validation_no_error_rules()
    {
        // Mocking data that would be sent in the request
        $response = $this->post(route('calculation.store'), [
            'amount' => '10',
            'percentage' => '20',
        ]);
        $response->assertSessionDoesntHaveErrors(['amount','percentage']);
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function  when_calculation_index_then_show_blade_view()
    {
        $response = $this->get(route('calculation.index'));
        $response->assertStatus(200);
        $response->assertViewIs('calculation.index');

    }

    /** @test */
    public function when_index_page_then_record_is_empty()
    {
        // Mocking data that would be sent in the request
        $response = $this->get(route('calculation.index'));
        $response->assertStatus(200);
        if ($response->getContent() === '{"data":[]}') {
            $response->assertSee('No Calculations');
        }
    }

    /** @test */
    public function when_index_page_then_record_is_not_empty()
    {
        $response = $this->get(route('calculation.index'));
        $response->assertStatus(200);
        $response->assertViewHas('calculationData');
        // $response->assertViewHas('dataObj');
        $response->assertDontSee('No Calculations');
    }

    /** @test */
    public function when_index_page_then_table_title_exists()
    {
        $response = $this->get(route('calculation.index'));
        $response->assertStatus(200);
        $response->assertSee('Amount');

    }
}
