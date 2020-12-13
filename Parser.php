<?php
require_once("simplehtmldom/simple_html_dom.php");

class Parser{

	const MAX_SIZE_NUMBER = 7;
	const TAG = 'cv-spread-overview';
	const ATTR = ':spread-data';

	private function genString(int $max_size, string $str) : string
	{
		$length = strlen($str);
		if($length < $max_size)
		{
			for($i = 0; $i < $max_size - $length; $i++)
			{
				$str .= ' ';
			}
		}
		return $str;
	}

	public static function getPage(string $url) : ?string 
	{

	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_REFERER, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.125 Safari/533.4");
	    $page = curl_exec($curl);
	    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	    curl_close($curl);
	    
	    return ($page && ($code == 200)) ? $page : null;
	}

	public static function getDataObj(string $page) : array
	{
		$dom = new simple_html_dom();
	    $dom->load($page);

	    foreach($dom->find(self::TAG) as $a){

			if (isset($a->attr[self::ATTR])) {
				$section = $a->attr[self::ATTR];
			}

			$dataObj = json_decode($section);
		}

		return $dataObj;
	}

	public static function printObj($dataObj)
	{
		foreach ($dataObj as $city) 
		{
			echo 
				self::genString(self::MAX_SIZE_NUMBER, $city->code).' '.
				self::genString(self::MAX_SIZE_NUMBER, $city->sick).' '.
				self::genString(self::MAX_SIZE_NUMBER, $city->healed).' '.
				self::genString(self::MAX_SIZE_NUMBER, $city->died).' '.
				self::genString(self::MAX_SIZE_NUMBER, $city->sick_incr).' '.
				self::genString(self::MAX_SIZE_NUMBER, $city->healed_incr).' '.
				self::genString(self::MAX_SIZE_NUMBER, $city->died_incr).' '.
				$city->title.PHP_EOL;
		}
	}
}

?>
