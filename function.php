<?php
class Youtube
{
    function scrape($url){    
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Opera/9.80 (BlackBerry; Opera Mini/4.5.33868/37.8993; HD; en_US) Presto/2.12.423 Version/12.16');
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
    $content = curl_exec ($ch);
    curl_close ($ch);
    return $this->remline($content);
    }
    function trending(){
        $response = $this->scrape('https://m.youtube.com/feed/trending?hl=id&gl=ID&client=mv-google');
        $totalfind = substr_count($response,'<td width="45">');
        $k = 0;
        $data = array();
        $response = str_replace('> <a href=','><a class="grabbing" href=',$response);
        $response = str_replace('dir="ltr"','campak',$response);
        while ($k < $totalfind) {
            $margin = $this->getAll($k+1,$response,'campak','</a>');
            $duration = $this->onlyStr('<div '.$this->getAll($k+1,$response,'</a> </div> <div','</div>').'</div>');
            $chtitle = $this->onlyStr($this->getStr($response,"$duration </div>","</div>"));
            $viewer = $this->onlyStr($this->getStr($response,"$chtitle </div>","</div>"));
            if(strpos($viewer, 'x ditonton') && $this->getStr($margin,'/watch?v=','&')){
            @$data[$k]['id'] .= $this->getStr($margin,'/watch?v=','&');
            @$data[$k]['title'] .= $this->onlyStr('<div'.$margin); 
            @$data[$k]['duration'] .= $duration;
            @$data[$k]['chtitle'] .= $chtitle;
            @$data[$k]['viewer'] .= str_replace('x ditonton', '',$viewer);
            }
            $k++;
        }
        $a = array(
            'items' => array_slice($data, 0, 12),
            'raw' => $response
            );
        return json_encode($a);
    }
    function search($q,$token = NULL,$limit = 100,$filter = NULL){
        if($token){
        $response = $this->scrape('https://m.youtube.com/results?client=mv-google&gl=EN&hl=en&search_sort=relevance&q='.rawurlencode($q).'&search_type=search_video&uploaded=&action_continuation=1&ctoken='.$token);
        }else{
        $response = $this->scrape('https://m.youtube.com/results?client=mv-google&gl=EN&hl=en&q='.rawurlencode($q).'&submit=Telusuri');
        }
            $initial = $this->getStr($response,"var ytInitialData = '","'");
        $int_data = preg_replace_callback(
          "(\\\\x([0-9a-f]{2}))i",
          function($a) {return chr(hexdec($a[1]));},
          $initial
        );
        $json = json_decode($int_data,1);
        if ($json === null
    && json_last_error() !== JSON_ERROR_NONE) {
        $int_data = str_replace(['\\"','\\'], '', $int_data);
        $json = json_decode($int_data,1);
}
        if(strpos($int_data,'universalWatchCardRenderer') && strpos($int_data, 'CARD_RENDERER_STYLE_TYPE_UNIVERSAL_WATCH_CARD')){
        $listing = $json['contents']['sectionListRenderer']['contents'][1]['itemSectionRenderer']['contents'];
        }else{
        $listing = $json['contents']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'];
        }
        $k = 0;
        $data = [];
        foreach ($listing as $dataz) {
            if(isset($dataz['compactVideoRenderer']['videoId'])){
                $duration = $this->covertime(@$dataz['compactVideoRenderer']['lengthText']['runs'][0]['text']);
                $parsed = date_parse($duration);
            @$data[$k]['id'] .= $dataz['compactVideoRenderer']['videoId'];
            @$data[$k]['title'] .= $this->cleanText($dataz['compactVideoRenderer']['title']['runs'][0]['text']); 
            @$data[$k]['duration'] .= $dataz['compactVideoRenderer']['lengthText']['runs'][0]['text'];
            if(strpos($duration,'00:') != -1){
                @$data[$k]['durationformat'] .= str_replace('00:','',$duration). ' min';
            }else{
                @$data[$k]['durationformat'] .= $duration;
            }
            @$data[$k]['size'] .=  $this->formatSizeUnits(($parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']) * (24 * 10));
            @$data[$k]['channel'] .= $dataz['compactVideoRenderer']['shortBylineText']['runs'][0]['text'];
            @$data[$k]['view'] .= $dataz['compactVideoRenderer']['viewCountText']['runs'][0]['text'];
            @$data[$k]['nonapi'] .= 'yes';
            @$data[$k]['type'] .= 'video';
            $k++;
            }
        }
        $a = array(
            'items' => $limit == 100 ? $data : array_slice($data, 0, $limit),
            'query' => $q,
            'first' => $data[2],
            'raw' => $response
            );
        return json_encode($a);
        
    }
    
    function getYT($ytid){    
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_URL, 'https://www.youtube-nocookie.com/embed/'.$ytid);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
    $content = curl_exec ($ch);
    curl_close ($ch);
    return $content;
    }
    function getData($ytid){
        $data = urldecode($this->getYT($ytid));
        $k = array();
        $k['id'] = $ytid;
        $k['title'] = $this->getStr($data,'<title>','- YouTube');
        $k['duration'] = gmdate("H:i:s", $this->getStr($data,'\"videoDurationSeconds\":\"','\"'));
        $k['chtitle'] = $this->getStr($data,'"expanded_title":"','"');
        $k['view'] = $this->getStr($data,'\"subtitle\":{\"runs\":[{\"text\":\"','views');
        return json_encode($k);
    }
    function remline($string){
        $string= str_replace(PHP_EOL, ' ', $string);
        $string= str_replace('&nbsp;', ' ', $string);
        $string= str_replace(array("\r","\n"), "", $string);
        $string= trim(preg_replace('/\s\s+/', ' ', $string));
        return $string;
    }
    function getStr($string,$start,$end){
        $str = explode($start,$string,2);
        $str = @explode($end,$str[1],2);
        return $str[0];
    }
    
    function cleanText($str){
        $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UTF-16BE');
        }, $str);
         return $str;
    }
    function getBetween($content,$start,$end){
        $r = explode($start, $content);
        if (isset($r[1])){
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }
    function covertime($data){
        $totaldot = substr_count($data,'.');
        if($totaldot == 1){

            return '00:'.str_replace('.', ':', $data);
        }else{
            return $data;
        }
    }
        function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
    function onlyStr($data){
        $data = rtrim(ltrim(strip_tags($data)));
        return trim($data);
    }
    function getAll($x,$content,$start,$end){
        $r = explode($start, $content);
            if (isset($r[$x])){
                $r = explode($end, $r[$x]);
                return $r[0];
            }
        return '';
    }
}
?>