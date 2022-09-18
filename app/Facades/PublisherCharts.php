<?php 

namespace App\Facades;

use App\Charts\PublisherOfferProfileChart;
use App\Models\Offer;
use App\Models\SallaAffiliate;
use Illuminate\Support\Facades\Facade;
use App\Models\SallaInfo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PublisherCharts extends Facade{
     
    // Get Registerd name of the component

    protected static function getFacadeAccessor()
    {
        return 'publisher-charts';
    }

    protected static function colors($number){
        $colors = array_reverse(['#227093','#ee5253', '#222f3e', '#ff9f43', '#40407a', '#0abde3', '#1abc9c', '#2ecc71', '#2c2c54',  '#3498db', '#9b59b6', '#2c2c54', '#34495e', '#16a085', '##16a085', '#27ae60', '#2980b9', '#8e44ad', '#f1c40f', '#e67e22' ,'#c0392b']);
        $colorsNo = count($colors) - $number;
        $nededColors = array_reverse(array_slice($colors,$colorsNo));
        return $nededColors;
    }

    static function chart($object, $title, $chartFor, $chartType, $datasetTitle){
        $chart = new PublisherOfferProfileChart;
        $offersNames = $object->pluck($title);
        $data = $object->pluck($chartFor);
        $colors =  PublisherCharts::colors(count($data));
        
        $chart = new PublisherOfferProfileChart;
        $chart->labels($offersNames);
        $chart->dataset($datasetTitle,$chartType, $data)->backgroundColor($colors);
        return $chart;
    }

}