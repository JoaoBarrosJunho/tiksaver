<?php

namespace App\classes;

use App\activities\activity;
use App\activities\metrics;
use App\db\database;
use App\login\user;
use DateInterval;
use DateTime;
use PDO;

class dashboard
{

    public static function TotalDownloads($where=null)
    {
        $where= $where!=null?" AND $where":'';
        $response = 00;
        $response = tk_video::find(null, null, null, 'COUNT(id) as Results')[0]->Results??'0';
        
        return $response = $response != 00 && $response < 10 ? '0' . $response : $response;
    }

    public static function TotalApiRequests($where=null)
    {
        $where= $where!=null?" AND $where":'';
        $response = 00;
        $response = api_logs::find("action_key='new_request'", null, null, 'COUNT(id) as Results')[0]->Results??'0';
        
        return $response = $response != 00 && $response < 10 ? '0' . $response : $response;
    }

   

    public static function TotalUsers()
    {
        $response = 00;
        $search = (new database('user'))->select(null, null, null, 'COUNT(id) as TotalAccounts')->fetchAll(PDO::FETCH_CLASS);
        if ($search[0]->TotalAccounts) {
            $response = $search[0]->TotalAccounts;
        }
        return $response = $response != 00 && $response < 10 ? '0' . $response : $response;
    }

    public static function SiteViews()
    {
        $response = '00';
        $search = metrics::select(null, null, null, "COUNT(id) AS TotalViews");;
        if ($search[0]->TotalViews) {
            $response = $search[0]->TotalViews;
        }
        return  $response != 00 && $response < 10 ? '0' . $response : $response;
    }

    public static function trafficDays($days = 7)
    {
        $startDate = (new DateTime('now'))->sub(new DateInterval("P7D"));

        $response = ["date" => [], "values" => []];
        $i = 0;

        

        for ($i; $i < $days; $i++) {
            $d = self::subdate($startDate);
            $response['date'][] = "'" . $d->format(leemclasses::option('date_format')) . "'";
            $dformated = $d->format('Y-m-d');
            $metrics = metrics::select("date = '$dformated'", null, null, "COUNT(id) AS TotalViews");
            $response['values'][] = $metrics[0]->TotalViews ? $metrics[0]->TotalViews : 0;
        }



        return $response;
    }

    public static function DownloadsDays($days = 7)
    {
        $startDate =(new DateTime('now'))->sub(new DateInterval("P".$days."D"));

        $response = ["date" => [], "values" => []];
        $i = 0;

        

        for ($i; $i < $days; $i++) {
            $d = self::subdate($startDate);
            $response['date'][] = "'" . $d->format(leemclasses::option('date_format')) . "'";
            $dformated = $d->format('Y-m-d 00:00:00');
            $dLimite = self::subdate((new DateTime($dformated)))->format('Y-m-d 00:00:00');
            $metrics = tk_video::find("created BETWEEN '$dformated' AND '$dLimite'", null, null, "COUNT(id) AS TotalViews");
            $response['values'][] = $metrics[0]->TotalViews ? $metrics[0]->TotalViews : 0;
        }



        return $response;
    }

    public static function ApiRequests($days = 7)
    {
        $startDate =(new DateTime('now'))->sub(new DateInterval("P".$days."D"));

        $response = ["date" => [], "values" => []];
        $i = 0;

        

        for ($i; $i < $days; $i++) {
            $d = self::subdate($startDate);
            $response['date'][] = "'" . $d->format(leemclasses::option('date_format')) . "'";
            $dformated = $d->format('Y-m-d 00:00:00');
            $dLimite = self::subdate((new DateTime($dformated)))->format('Y-m-d 00:00:00');
            $metrics = api_logs::find("created BETWEEN '$dformated' AND '$dLimite'", null, null, "COUNT(id) AS TotalViews");
            $response['values'][] = $metrics[0]->TotalViews ? $metrics[0]->TotalViews : 0;
        }



        return $response;
    }

   

    public static function subdate($date)
        {
            return $date->add(new DateInterval("P1D"));
        }
    /**
     * Returns traffic data for the last 7 days
     */
    public static function getTraffic($days = 7)
    {
        $traffic = self::trafficDays($days);
        $downloads = self::DownloadsDays($days);
        $apiRequests = self::ApiRequests($days);
        

        $dates = implode(",", $traffic['date']);
        $values = implode(",", $traffic['values']);

        $downloaddates = implode(",", $downloads['date']);
        $downloadvalues = implode(",", $downloads['values']);
        
        $apiValues = implode(",", $apiRequests['values']);

        return "<script>

                const viewsChart = {values:[$values],dates:[$dates]}
                const downloadChart = {values:[$downloadvalues],dates:[$downloaddates],apiValues:[$apiValues]}</script>";
    }

    public static function LastActivities()
    {
        $activities = activity::get();
        if ($activities) {
            $i = 0;
        
        krsort($activities);
            foreach ($activities as $a) {
                $date = isset($a->date)? (new DateTime($a->date))->format(leemclasses::getDateFormat()):null;
                if(!user::isAdmin()){
                    $user = isset($a->user)?$a->user:null;
                    if(user::logged('id')==$user){
                    echo '<labe class="flex flex-col">';
                    echo '<span class="text-sm font-semibold flex items-center dark:text-gray-100"><span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span> ' . $a->title . '</span>';
                    echo '<span class="text-sm text-gray-600 ml-4 dark:text-gray-300">' . $a->message . '</span>';
                    echo $date?'<span class="text-xs text-gray-600 ml-4">' . $date . '</span>':null;
                    echo '</labe>';
                    $i++;
                    }
                }else{
                    echo '<labe class="flex flex-col">';
                    echo '<span class="text-sm font-semibold flex items-center dark:text-gray-100"><span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span> ' . $a->title . '</span>';
                    echo '<span class="text-sm text-gray-600 ml-4 dark:text-gray-300">' . $a->message . '</span>';
                    echo $date?'<span class="text-xs text-gray-600 ml-4 dark:text-gray-400">' . $date . '</span>':null;
                    echo '</labe>';
                    $i++;
                }
                
            }
            print $i>0 ?null:'<label class="w-full h-screen flex items-center justify-center text-sm text-gray-200">'.tts['no_activities'].'</label>';
            return $i>0? true:false;
        }else{
            print '<label class="w-full h-screen flex items-center justify-center text-sm text-gray-500">'.tts['no_activities'].'</label>';
            return false;
        }
    }
}
