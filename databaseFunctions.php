<?php
/**
 * Created by PhpStorm.
 * User: yhb15154
 * Date: 23/06/2016
 * Time: 09:37
 */

namespace App\Http\Controllers;

use DB;
use App\Provider;
use App\Visitor;
use App\Http\Controllers\Controller;


//******* functions to search for visitors
function searchVisitorByFirstName($firstName)
{
    $visitors = DB::table('visitors')->where('forename', $firstName)->get();

}

function searchVisitorBySurame($surname)
{
    $visitors = DB::table('visitors')->where('surname', $surname)->get();
}

function searchVisitorByEmail($email)
{
    $visitors = DB::table('users')->where('email', $email)->get();
}


//***** functions to search for providers

function searchProviderByName($providerName)
{
    $provider = DB::table('providers')->where('name', $providerName)->get();
}

function searchProviderById($providerId)
{
    $provider = DB::table('providers')->where('provider_id', $providerId)->get();
}

function searchProviderByRegion($providerRegion)
{
    $provider = DB::table('providers')->where('region', $providerRegion)->get();
}

function searchProviderByCounty($providerCounty)
{
    $provider = DB::table('providers')->where('county', $providerCounty)->get();
}

function searchProviderByHistoricCounty($providerHistoricCounty)
{
    $provider = DB::table('providers')->where('historic_county', $providerHistoricCounty)->get();
}

function searchProviderByType($providerType)
{
    $provider = DB::table('providers')->where('type', $providerType)->get();
}


//***** functions tpo search for users

function searchUserById($userId)
{
    $user = DB::table('users')->where('user_id', $userId)->get();
}

function searchUserByType($userType)
{
    $user = DB::table('users')->where('type', $userType)->get();
}


//***** functions for messages

function findMessagesByDate($date)
{
    $message = DB::table('messages')->where('time', $date)->get();
}

function findUnreadMessages()
{
    $message = DB::table('messages')->where('read', 'no')->get();
}

function findOldestUnansweredMessage()
{
    $message = DB::table('messages')->where('read', '=', 'no')
        ->min('time')->get();
}

function findUnansweredMessagesByProvider($providerId)
{
    $message = DB::table('messages')->where('read', '=', 'no')
        ->where('provider_id', '=', $providerId)->get();
}

//***** function for retriving specific records

function getProvider($user_id)
{
    $provider = Provider::where('user_id', '=', $user_id)->first();
}

function getVisitor($user_id)
{
    $visitor = Visitor::where('visitor_id', '=', $user_id)->first();
}

function getProviderByProviderId($provider_id)
{
    $provider = Provider::where('provider_id', '=', $provider_id)->first();
}

function getVisitorByVisitorId($visitor_id)
{
    $visitor = Visitor::where('visitor_id', '=', $visitor_id)->first();
}