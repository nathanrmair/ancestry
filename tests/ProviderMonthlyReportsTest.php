<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Report;
use App\Provider;
use Carbon\Carbon;
use App\ProviderMonthlyReport;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Reports\ProviderReportsController;

class ProviderMonthlyReportsTest extends TestCase
{
    private $visitor1, $visitor2,$admin,$noOfProviders = 6;
    
    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();

        for ($i = 1; $i <= $this->noOfProviders; $i++) {
            $user = factory(App\User::class)->create([
                'type' => 'provider',
                'user_id' => $i,
                'email'=>($i.'@email.com')
            ]);

            factory(App\Provider::class)->create([
                'user_id' => $user->user_id,
                'provider_id'=> ($i),
                'name' => ('provider' . chr((65 + $this->noOfProviders) - $i)),//creates reverse alphabetical list
                'description' => ('provider' .$i)

            ]);
            info('provider' . chr((65 + $this->noOfProviders) - $i));
        }

        $this->visitor1 = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => (1+$this->noOfProviders)
        ]);
        $this->visitor2 = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => (2+$this->noOfProviders)
        ]);

        factory(App\Visitor::class)->create([
            'user_id' => $this->visitor1->user_id
        ]);
        factory(App\Visitor::class)->create([
            'user_id' => $this->visitor2->user_id
        ]);

        $this->admin = factory(App\User::class)->create([
            'type' => 'admin',
            'user_id' => (3+$this->noOfProviders)
        ]);
        
    }

    public function testVisits()
    {
        $provider = Provider::find(1);
        $this->be($this->visitor1);
        $this->visit('provider_overview/'.Hashids::encode($provider->user_id));
        ProviderReportsController::generateReports(Carbon::now()->subMonth());
        $report1 = ProviderMonthlyReport::where('provider_id',$provider->provider_id)->where('report_index',0)->first();
        $this->assertEquals(1,$report1->page_visits);
    }

//    public function testVisitsNextMonth()
//    {
//        $provider = Provider::find(1);
//        $this->be($this->visitor1);
//        $this->visit('provider_overview/'.Hashids::encode($provider->user_id));
//        ProviderReportsController::generateReports(Carbon::now('Europe/London'));
//        $report1 = ProviderMonthlyReport::where('provider_id',$provider->provider_id)->where('report_index',0)->first();
//        $report2 = ProviderMonthlyReport::where('provider_id',$provider->provider_id)->where('report_index',1)->first();
//        $this->assertNotEquals($report1->start_date,$provider->created_at);
//        $this->assertNotNull($report2);
//        $this->assertEquals(1,$report2->page_visits);
//        $this->assertEquals(2,$report2->total_page_visits);
//        //$this->assertTrue(Provider::find(1));
//     
//    }
}
