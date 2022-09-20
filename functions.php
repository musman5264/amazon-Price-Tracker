<?php

//Global Variables
$url = '';

//Function to get ASIN from Amazon US URL
function ama_url($url)
{
    GLOBAL $url;
preg_match_all ("/(?:dp|o|gp|-)\/(B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))/", $url, $matches,PREG_PATTERN_ORDER);   
return $matches[1][0];
}
function ama_load_info($url){
    GLOBAL $url;
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_ENCODING => '', // Warning: if we don't say "Accept-Encoding: gzip", the SOB's at Amazon will send it gzip-compressed anyway.
        CURLOPT_URL => $url
    ));
    $html = curl_exec($ch);
    @($domd = new DOMDocument())->loadHTML($html);
    $xp=new DOMXPath($domd);
    $product=[];
    //$product["productName"]=trim($domd->query("//*[contains(@class, 'post-inner')]"));
    $product["stock"]=trim($domd->getElementById("availability"));
    $prodInfo=$xp->query("//*[@id='productOverview_feature_div']//tr[contains(@class,'a-spacing-small')]");
    foreach($prodInfo as $info){
        $product[trim($info->getElementsByTagName("td")->item(0)->textContent)]=trim($info->getElementsByTagName("td")->item(1)->textContent);
    }
}

//Function to Find and Replace

function rep_class($text, $search, $pre, $post=0, $offset=0){
    //stores the value from the post variables
    //This is to point to the string characters to search for the matching pair
    //This variable is used to store the length of the search string 
    $searchLength = strlen($search);
        //The while loop takes three parameters 
        //first parameter will take the current text 
        //second parameter will take the text which wants to search
        //third parameter will take the character where the search is matched
        while ($stringPostion = strpos($text, $search, $offset))
        
                {
                    //This will check if we have visited all the characters of the string
                    $offset = $stringPostion + $searchLength;
                    //This function takes four parameters 
                    //First param checks the string to check
                    //second param replaces the find string
                    //third param specify from where the string replacing should start
                    //fourth param specify how many character should be replaced
                    if($post == 0){$post = $offset;}elseif($post == '1'){$post = ' ';}
                    $text = substr_replace($text, $pre.$post, $stringPostion, $searchLength);
                }
    return $text;
}
