<html>
    <head>
        <?php include('header.php'); ?>

    </head>
    <body>

        <div class="container bg">
<?php
$getplaceText = $_GET['place']; 

    function getwoed($getplaceText){

        $yql_query = 'select woeid from geo.places where text="'.$getplaceText.'" LIMIT 1' ;  
        $yql_base_url = "http://query.yahooapis.com/v1/public/yql"; 
        $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query); 
        $doc = new DOMDocument(); 
        $doc->load($yql_query_url);  
        $results = $doc->getElementsByTagName("results");           

            foreach($results as $rslt){
                $place = $rslt->getElementsByTagName("place"); 
                    foreach($place as $placegotten){
                        $woeid = $placegotten->getElementsByTagName("woeid"); 
                        $number = $woeid->item(0)->nodeValue;
                        getFlickerImage($number, $getplaceText);
            }
        }    
    }

?>

<?php
getwoed($getplaceText) ; 

function getWeather($woeid, $flickr_src, $flickr_url, $title, $id, $farm,  $server_id, $title, $secret){
$flickr_src;
$woeid = $woeid;
$doc = new DOMDocument();
$url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D$woeid&diagnostics=true";
$doc->load($url);

    $channel = $doc->getElementsByTagName("channel");
        foreach($channel as $chnl){

            $item = $chnl->getElementsByTagName("item");
                 foreach($item as $itemgotten){

                    if($itemgotten){
                        echo "<div class='big'>";

                        echo "<p class='lead'>".$itemgotten->getElementsByTagNameNS(
                        "http://xml.weather.yahoo.com/ns/rss/1.0","condition")->item(0)->getAttribute("text")." ";

                        echo "<span class='small'>".$itemgotten->getElementsByTagNameNS("http://xml.weather.yahoo.com/ns/rss/1.0","condition")->item(0)->getAttribute("temp")."&deg; F</span></p>";

                        echo $chnl->getElementsByTagNameNS("http://xml.weather.yahoo.com/ns/rss/1.0","forecast")->item(0)->getAttribute("code")."</p>";

                        echo "</div>"; // end big

                        echo "<div class='medium_box'>";

                        echo "<p class='lead'>".$chnl->getElementsByTagNameNS(
                        "http://xml.weather.yahoo.com/ns/rss/1.0","location")->item(0)->
                        getAttribute("city").", ";

                        echo $chnl->getElementsByTagNameNS(
                        "http://xml.weather.yahoo.com/ns/rss/1.0","location")->item(0)->
                        getAttribute("region")."</p>";

                        echo "<p class='small'>".$chnl->getElementsByTagNameNS(
                        "http://xml.weather.yahoo.com/ns/rss/1.0","forecast")->item(0)->
                        getAttribute("day").", ";

                        echo $chnl->getElementsByTagNameNS(
                        "http://xml.weather.yahoo.com/ns/rss/1.0","forecast")->item(0)->
                        getAttribute("date")."</p>";

                            echo "<u>API </u>" . $flickr_url;
                            echo "<br />";
                            echo "<u>source</u> " . $flickr_src;
                            echo "<br>";
                            echo "<u>Title</u> " . $title;
                            echo "<br>";
                            echo "<u>id</u> " . $id;
                            echo "<br>";
                            echo "<u>server</u> " . $server_id;
                            echo "<br>";
                            echo "<u>secret</u> " . $secret;
                            echo "<br>";
                            echo "<img src=".$flickr_src.">";

                        echo "</div>"; // medium box location and date

                    }

                else{
                    echo "<h1>there was an error<h2>";
                }
        }
    }
}

function getFlickerImage($woeid, $place){
    $app_id = '1b5bc9e651e3c1957500c392c3f7f778';
    $woeid; 
    $place;    

    $doc = new DOMDocument();
    $flickr_url ='http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$app_id.'&woe_id='.$woeid.'&per_page=1&format=rest';

    $feed = file_get_contents($flickr_url);
    $response = simplexml_load_string($feed);
  
  foreach ($response->photos->photo as $photo) {

    $id = $photo['id'];
    $farm = $photo['farm'];
    $server_id = $photo['server'];
    $secret = $photo['secret'];
    $title = $photo['title'];

      } 

    $flickr_src ='https://farm'.$farm.'.staticflickr.com/'.$server_id.'/'.$id.'_'.$secret.'_c.jpg'; 
                
    getWeather($woeid, $flickr_src, $flickr_url, $title, $id, $farm,  $server_id, $title, $secret); 

}


echo "<script type='text/javascript'>

(function(){

    var body = $('body');
    body.css('background:');

})();

</script>";


?>

     </body>
</html>