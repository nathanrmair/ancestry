<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
    public function clenseDB(){
        if(Schema::hasTable('users')){
            $tables = DB::select('SHOW TABLES');
            foreach ($tables as $table) {
                if (Schema::hasTable($table->Tables_in_sample)) {
                    DB::table($table->Tables_in_sample)->delete();
                }
            }
        }
        else{
            Artisan::call('migrate', [
                '--env' => 'local'
            ]);
        }

    }
    
    static public function toDBformat($dateString){
        $string = substr($dateString,6,4);
        $string .= '-';
        $string .= substr($dateString,3,2);
        $string .= '-';
        $string .= substr($dateString,0,2);
        return $string;
    }
    
}
