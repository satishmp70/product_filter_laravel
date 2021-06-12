<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use App\Traits\ReformatFiles\DownloadHelper;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
// use App\Excel\CustomNumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Facades\Excel;


class RareCaratCrawler
{
    protected $shape;
    // protected $exportFromArray;
    // protected $exportData;

    function __construct($shape, $exportFromArray = false, $exportData = false)
    {
        $this->shape     = $shape;
        // $this->exportFromArray  = $exportFromArray;
        // $this->exportData       = $exportData;

        $this->inititate();

    }


	public function title(): string
    {	
        return 'Sheet1';
    }


    public function requestData($price='')
    {
              
       
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://webapi.rarecarat.com/diamonds2',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"diamond":{"hasMedia":false,"shapes":['.$this->shape.'],"priceMin":350,"priceMax":2000000,"caratMin":"'.$price.'","caratMax":15,"cutMax":3,"cutMin":-1,"colorMax":8,"colorMin":1,"clarityMax":8,"clarityMin":1,"fluorescenceMax":4,"fluorescenceMin":0,"certificateLabs":[2,5,0],"polishMax":3,"polishMin":1,"symmetryMax":3,"symmetryMin":1,"tableWidthPercentageMin":0,"tableWidthPercentageMax":100,"depthPercentageMin":0,"depthPercentageMax":100,"lengthToWidthRatioMin":1,"lengthToWidthRatioMax":2.75,"lengthMin":3,"lengthMax":20,"widthMin":3,"widthMax":20,"heightMin":2,"heightMax":12,"crownAngleMin":23,"crownAngleMax":40,"pavilionAngleMin":38,"pavilionAngleMax":43,"girdleThicknessPercentageMin":1.5,"girdleThicknessPercentageMax":7,"girdleThicknessMax":8,"girdleThicknessMin":1,"pricePerCaratMin":0,"pricePerCaratMax":50000,"pairSearch":false,"isLabGrown":true,"dealScoreRatings":[],"qualityScoreRankings":[],"shippingDays":-1,"showSaleDiamonds":false},"setting":{"priceMin":0,"priceMax":1000000,"styles":[],"metals":[]},"retailer":{"showOnline":true,"showLocal":true,"postalCode":"400051","distance":75,"retailers":[35,23,32,17,27,55,54,30,24,107,53,38,15,103,40,52,105,12],"localRetailers":[],"features":[]}}',
                // CURLOPT_POSTFIELDS =>'{"diamond":{"hasMedia":false,"shapes":[1,10,6,2,4,8,5,9,3,7],"priceMin":350,"priceMax":2000000,"caratMin":"'.$price.'","caratMax":15,"cutMax":3,"cutMin":-1,"colorMax":8,"colorMin":1,"clarityMax":8,"clarityMin":1,"fluorescenceMax":4,"fluorescenceMin":0,"certificateLabs":[2,5,0],"polishMax":3,"polishMin":1,"symmetryMax":3,"symmetryMin":1,"tableWidthPercentageMin":0,"tableWidthPercentageMax":100,"depthPercentageMin":0,"depthPercentageMax":100,"lengthToWidthRatioMin":1,"lengthToWidthRatioMax":2.75,"lengthMin":3,"lengthMax":20,"widthMin":3,"widthMax":20,"heightMin":2,"heightMax":12,"crownAngleMin":23,"crownAngleMax":40,"pavilionAngleMin":38,"pavilionAngleMax":43,"girdleThicknessPercentageMin":1.5,"girdleThicknessPercentageMax":7,"girdleThicknessMax":8,"girdleThicknessMin":1,"pricePerCaratMin":0,"pricePerCaratMax":50000,"pairSearch":false,"isLabGrown":true,"dealScoreRatings":[],"qualityScoreRankings":[],"shippingDays":-1,"showSaleDiamonds":false},"setting":{"priceMin":0,"priceMax":1000000,"styles":[],"metals":[]},"retailer":{"showOnline":true,"showLocal":true,"postalCode":"400051","distance":75,"retailers":[35,23,32,17,27,55,54,30,24,107,53,38,15,103,40,52,105,12],"localRetailers":[],"features":[]}}',
          CURLOPT_HTTPHEADER => array(
            'origin: https://www.rarecarat.com',
            ': https://www.rarecarat.com/',
            'Content-Type: application/json',
            'Cookie: __cfduid=db5113332dce81c91c6702ac52dedfa8f1618641875'
          ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode( $response, true );


    }



 
    public function inititate($value='')
    {   
        $file_path = storage_path()."/rare_isLabGrown_".$this->shape.".csv";

        $file = fopen($file_path,"w");

        for ($i=1; $i < 30; $i++) { 

            $price = $i / 2;
             
            $data = $this->requestData($price);

            if (isset($data['diamonds'])) {
                
                foreach ($data['diamonds'] as $key => $diamond) {
      
                    $list = array($diamond['itemId'] ?? '',
                                  $diamond['retailer']['name']?? '',
                                  $diamond['certificateLab']?? '',
                                  $diamond['url']?? '',
                                  $diamond['itemId']?? '',
                                  $diamond['price']?? '',
                                  $diamond['pricePerCarat']?? '',
                                  $diamond['shape']?? '',
                                  $diamond['carat']?? '',
                                  $diamond['cut']?? '',
                                  $diamond['color']?? '',
                                  $diamond['colorDescription']?? '',
                                  $diamond['clarity']?? '',
                                  $diamond['fluorescence']?? '',
                                  $diamond['polish']?? '',
                                  $diamond['symmetry']?? '',
                                  $diamond['wirePrice']?? '',
                                  $diamond['fairPriceDifference']?? ''
                              );
                    
               
                    $file = fopen($file_path,"a");

                    fputcsv($file, $list);
            
                    fclose($file);


                }

            }
            

            \Log::info(['minPrice'=>$price,'loop'=>$i]);
        }
       
    }



    public function findImages($page='')
    {
        $start = strpos($page, "colorImages");

        $end = strpos($page, "colorToAsin");


        $images = substr($page, $start, ($end - $start));

        $images = str_replace("\n", '', $images);

        $images = str_replace( "var data = ", '', $images);

        $images = str_replace("colorImages': ", "",  $images);

        $images = str_replace("'", '"',  $images);
            

        $images = substr($images, 0, -2);


        $images = json_decode($images, true);
        

        $imageArray[0] = isset($images['initial'][0]['hiRes'] ) ? $images['initial'][0]['hiRes'] : '';
        $imageArray[1] = isset($images['initial'][1]['hiRes'] ) ? $images['initial'][1]['hiRes'] : '';
        $imageArray[2] = isset($images['initial'][2]['hiRes'] ) ? $images['initial'][2]['hiRes'] : '';
        $imageArray[3] = isset($images['initial'][3]['hiRes'] ) ? $images['initial'][3]['hiRes'] : '';
        $imageArray[4] = isset($images['initial'][4]['hiRes'] ) ? $images['initial'][4]['hiRes'] : '';
        $imageArray[5] = isset($images['initial'][5]['hiRes'] ) ? $images['initial'][5]['hiRes'] : '';
        $imageArray[6] = isset($images['initial'][6]['hiRes'] ) ? $images['initial'][6]['hiRes'] : '';
        $imageArray[7] = isset($images['initial'][7]['hiRes'] ) ? $images['initial'][7]['hiRes'] : '';
      
        return $imageArray;
    }


    public function findVideo($page='')
    {
        // $start = strpos($page, 'data-video-url="');
        /*first*/
        $start = strpos($page, 'imageBlockVariations_feature_div');


        // $end = strpos($page, 'class="a-section vse-video-item">');
        $end = strpos($page, 'bottomRow');
        
        // dd($start, $end);
        $block = substr($page, $start, ($end - $start));

        // dd($block);
        /*second*/
        $start = strpos($block, '{"dataInJson":null');


        // $end = strpos($block, 'holderc3e249ed73934f67add72b712974fa6c');
        $end = strpos($block, '","airyConfigEnabled":false,');
        
        // dd($start, $end);
        $section = substr($block, $start, ($end - $start));

        $section .= '"}';

        $videos = json_decode($section, true);

        $array[0] = isset($videos['videos'][0]['url']) ? $videos['videos'][0]['url'] : '';
        $array[1] = isset($videos['videos'][1]['url']) ? $videos['videos'][0]['url'] : '';

        return $array;

    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function array():array
    {	
        // $data = file_get_contents(storage_path().'/sample.txt');
        $data = file_get_contents(storage_path().'/sample.txt');
        
        $skus = str_replace("\n", "", $data);

        $skus = explode('|||', $skus);

        $array = [];

        foreach ($skus as $key => $sku) {

            if (empty($sku)) {

                continue;
            }
            
            $images = [];
            $videos = [];
            try {
            
                $string = explode("||", $sku);

                $skuName = $string[0];

               

                $page       = $this->requestAmazon($string[1]);

                // echo "$page";

                // dd(3);
                // $page  = $this->requestAmazon('https://www.amazon.com/dp/B07NCY17QY');

                // cache()->put('page', $page, 2000);
                // $page       = cache()->get('page');
                $images     = $this->findImages($page);

                $videos  = $this->findVideo($page);

                 \Log::info( [$skuName, array_merge( array_merge( $string,  $videos),  $images)] );
                 
            } catch (\Exception $e) {
                // dd($e);
                \Log::info($sku, explode("||", $sku), $e->getMessage());

                $file = fopen(storage_path().'/errors.txt', "w");
                fwrite($file, $sku, true );
                fclose($file);
                  
            }
            $array[] =   array_merge( array_merge( $string,  $videos),  $images);
               sleep(5);
            
        }

        return $array;

    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function columnFormats(): array
    {       

        return [
                'A' => NumberFormat::FORMAT_TEXT,
                'B' => NumberFormat::FORMAT_TEXT,
                'C' => NumberFormat::FORMAT_TEXT,
                'D' => NumberFormat::FORMAT_TEXT,
                'E' => NumberFormat::FORMAT_TEXT,
                'F' => NumberFormat::FORMAT_TEXT,
                'G' => NumberFormat::FORMAT_TEXT,
                'H' => NumberFormat::FORMAT_TEXT,
                'I' => NumberFormat::FORMAT_TEXT,
                'J' => NumberFormat::FORMAT_TEXT,
                'K' => NumberFormat::FORMAT_TEXT,
                'L' => NumberFormat::FORMAT_TEXT,
                'M' => NumberFormat::FORMAT_TEXT,
                'N' => NumberFormat::FORMAT_TEXT,
                'O' => NumberFormat::FORMAT_TEXT,
                'P' => NumberFormat::FORMAT_TEXT
            ];


    }

}

