<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProviderMonthlyReport extends Model
{
    protected $table = 'provider_monthly_reports';

    protected $primaryKey = 'provider_monthly_report_id';

    protected $fillable = [
        'provider_id','report_id','start_date','end_date','report_index',
        //
        'page_visits',
        
        //credits
        'credits_earned','credits_earned_through_visits',
        
        //messages
        'messages_unread','messages_received','new_conversations',
        
        //searches
        'searches_offered','searches_accepted','searches_outstanding','searches_completed',

        //totals
        'total_page_visits','total_messages','total_messages_unread','total_conversations','total_searches_completed'
    ];
    
    
}
