<?php
class Weather 
{
    private $url;

    public function get_cities()
    {
        $cities_json = file_get_contents("resources/city.list.json");
        $cities = json_decode($cities_json, true);
        $egyptian_cities = array();

        foreach ($cities as $key => $value) {
            foreach ($value as $k => $val) {
                if ($k === "country" && $val === "EG") {
                    array_push($egyptian_cities, $cities [$key]);
                }
            }
        }
        return $egyptian_cities;
    }

    public function get_weather($cityid)
    {
        $url = "https://api.openweathermap.org/data/2.5/weather?id=" . $cityid . "&appid=8bb709db69b1b8aaf1bb6d4445f5b0c4";
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $response_body = (string) $response->getBody();
        $weather_data = json_decode($response_body, true);
        return $weather_data;


    }

    public function get_current_time()
    {
        echo date("l") . " " . date("h") . " " . date("a") . "<br>";
        echo  date("d") . "th" . " " . date("F") . " " . date("Y") . "<br>";
    }
}
?>