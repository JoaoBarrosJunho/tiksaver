<?php

namespace App\classes;

use App\activities\metrics;
use App\db\database;
use DateInterval;
use DateTime;
use PDO;

class stats
{

   
    public static function traffic($days = 30,$time = 'days')
    {
        switch($time){
            case 'days':
                $startDate = (new DateTime('now'))->sub(new DateInterval("P30D"));

                $response = ["date" => [], "values" => []];
                $i = 0;

                function subdate($date)
                {
                    return $date->add(new DateInterval("P1D"));
                }

                for ($i; $i < $days; $i++) {
                    $d = subdate($startDate);
                    $response['date'][] = "'" . $d->format('M d') . "'";
                    $dformated = $d->format('Y-m-d');
                    $metrics = metrics::select("date = '$dformated'", null, null, "COUNT(id) AS TotalViews");
                    $response['values'][] = $metrics[0]->TotalViews ? $metrics[0]->TotalViews : 0;
                }
            break;
            case 'mounths':

                $startDate = (new DateTime('now'))->sub(new DateInterval("P12M"));

                $response = ["date" => [], "values" => []];
                $i = 0;

                function subdate($date)
                {
                    return $date->add(new DateInterval("P1M"));
                }

                for ($i; $i < 12; $i++) {
                    $d = subdate($startDate);
                    $response['date'][] = "'" . $d->format('M Y') . "'";
                    $dformated = $d->format('m-Y');
                    $initial_date = (new DateTime("01-".$dformated))->format('Y-m-d');
                    $finalDate = (new DateTime("01-".$dformated))->add(new DateInterval("P31D"))->format('Y-m-d');
                    $metrics = metrics::select("date BETWEEN '$initial_date' AND '$finalDate'", null, null, "COUNT(id) AS TotalViews");
                    $response['values'][] = $metrics[0]->TotalViews ? $metrics[0]->TotalViews : 0;
                }

            break;
            case 'years':
                $startDate = (new DateTime('now'))->sub(new DateInterval("P10Y"));

                $response = ["date" => [], "values" => []];
                $i = 0;

                function subdate($date)
                {
                    return $date->add(new DateInterval("P1Y"));
                }

                for ($i; $i < 10; $i++) {
                    $d = subdate($startDate);
                    $response['date'][] = "'" . $d->format('Y') . "'";
                    $dformated = $d->format('Y');
                    $initial_date = (new DateTime("01-01-".$dformated))->format('Y-m-d');
                    $finalDate = (new DateTime("31-12-".$dformated))->format('Y-m-d');
                    $metrics = metrics::select("date BETWEEN '$initial_date' AND '$finalDate'", null, null, "COUNT(id) AS TotalViews");
                    $response['values'][] = $metrics[0]->TotalViews ? $metrics[0]->TotalViews : 0;
                }
            break;
            default:
            $startDate = (new DateTime('now'))->sub(new DateInterval("P30D"));

            $response = ["date" => [], "values" => []];
            $i = 0;

            function subdate($date)
            {
                return $date->add(new DateInterval("P1D"));
            }

            for ($i; $i < $days; $i++) {
                $d = subdate($startDate);
                $response['date'][] = "'" . $d->format('M d') . "'";
                $dformated = $d->format('Y-m-d');
                $metrics = metrics::select("date = '$dformated'", null, null, "COUNT(id) AS TotalViews");
                $response['values'][] = $metrics[0]->TotalViews ? $metrics[0]->TotalViews : 0;
            }
            break;
        }
        



        return $response;
    }

    /**
     * Returns traffic data 
     */
    public static function getTraffic($days = 30,$time = 'days')
    {
        $traffic = self::traffic($days,$time);


        $dates = implode(",", $traffic['date']);
        $values = implode(",", $traffic['values']);

        return "<script>const datesM = [$dates];
                const dataChart = [$values]</script>";
    }

    public static function PopularPosts()
    {
        $posts = (new database('postmetrics'))->selectINNERJOIN(null," posts ON postmetrics.post_id = posts.id GROUP BY post_id ","TotalViews DESC","10 OFFSET 0"," post_id,post_title,post_guid,COUNT(*) AS TotalViews ")->fetchAll(PDO::FETCH_CLASS);
        return $posts;
        
    }

    public static function ipControl()
    {
        
        $list = (new database('postmetrics'))->selectINNERJOIN(null," posts ON postmetrics.post_id = posts.id ","id DESC","100 OFFSET 0"," postmetrics.id,ip,ip_country,post_guid")->fetchAll(PDO::FETCH_CLASS);

        return $list;
        
    }
}
