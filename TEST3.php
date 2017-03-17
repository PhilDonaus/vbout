<?php
include("simple_html_dom2.php");
//------------------------------------------------------------------

class myVBOUT{
	public $weburl;
	public $webhtml;
	public $abouturl;
	public $abouthtml;
	public $social;
	public $aboutus;
	public $email;
	//--------------------------------------------------------------
	public function __construct($web,$mail){
	$this -> weburl = $web;
	$this -> email = $mail;
	}
	//--------------------------------------------------------------
	public function MasterKey($weburl){ //TAKES IN HTML
		$weburl1 = myVBOUT::checkurl($weburl);
		print_r($weburl1);
		
		$arContext['http']['timeout'] = 15;
		$context = stream_context_create($arContext);
		
		
		$html = file_get_html($weburl1,false,$context);
		if(empty($html)){
			return $links = array('facebook' =>'N/A',
					'twitter'=>'N/A',
					'instagram'=>'N/A',
					'linkedin'=>'N/A',
					'youtube'=>'N/A',
					'google+'=>'N/A',
					'pinterest'=>'N/A','about'=>'N/A');
			$html->clear();
			unset($html);
		}else{
			$html1 = myVBOUT::process($html);
			$social = myVBOUT::ParseLinks($html1,$weburl1);
			$html->clear();
			unset($html);
			return $social;
		}

	}
	//--------------------------------------------------------------
	public function process($webhtml){
		$links = array();
		foreach($webhtml->find('a') as $a){
			$links[] = $a->href;
		}
		return $links;
	}
	//--------------------------------------------------------------
	public function process2($abouthtml){
		$links = array();
		if(!$abouthtml){ return array(); }
		else{
			foreach ($abouthtml -> find('p') as $p){
				$links[] = $p ->innertext;
				$links[] = '   ';
			}
			return $links;
		}
	}
	//--------------------------------------------------------------
	public function ParseLinks($urlstring,$url){ // receives an array of links
		$fb = myVBOUT::searchstr($urlstring,'://www.facebook.com/') or ("NA");
		$tw = myVBOUT::searchstr($urlstring,'://twitter.com/') or ("NA");
		$ig = myVBOUT::searchstr($urlstring,'://www.instagram.com') or ("NA");
		$li = myVBOUT::searchstr($urlstring,'://www.linkedin.com/company') or "NA";
		$yt = myVBOUT::searchstr($urlstring,'://www.youtube.com/user') or "NA";
		$gp = myVBOUT::searchstr($urlstring,'://google.com/+') or "NA";
		$pi = myVBOUT::searchstr($urlstring,'://www.pinterest.com') or "NA";
		$about = myVBOUT::aboutcheck($urlstring,$url);
		$about = myVBOUT::aboutrun($about);
	
		$links = array('facebook' =>$fb,
				'twitter'=>$tw,
				'instagram'=>$ig,
				'linkedin'=>$li,
				'youtube'=>$yt,
				'google+'=>$gp,
				'pinterest'=>$pi,
				'about' => $about);
	
		return $links; //AS ARRAY
	}
	//--------------------------------------------------------------
	function searchstr($var, $url){//$var is an array, $url is the target link
		foreach($var as $point){
			if (strpos($point, $url) !== false){
				return $point;
				break;
			}//should return the point it found
		}
	}
	//--------------------------------------------------------------
	public function gradingsystem($rows,$email){
		//get the social media rows
		$points = 0;
		$level = '';
		if (strlen($rows['facebook']) > 5){$points++;}
		if (strlen($rows['instagram']) > 5){$points = $points +2;}
		if (strlen($rows['twitter']) > 5){$points = $points +2;}
		if (strlen($rows['linkedin']) > 5){$points = $points +5;}
		if (strlen($rows['youtube']) > 5){$points++;}
		if (strlen($rows['google+']) > 5){$points++;}
		if (strlen($rows['pinterest']) > 5){$points++;}
	
		if ((strlen($rows['linkedin']) > 5) or (strlen($email) > 3))
		{$level = 'L1';}
		else if ((strlen($rows['twitter']) > 5) or (strlen($rows['instagram']) > 5) )
		{$level = 'L2';}
		else 
		{$level = 'L3';}
	
		return array($points,$level);
	}
	//--------------------------------------------------------------
	public function domainMatch($email, $website){
		$mail = strpbrk($email, '@');
		$mail = substr($mail, 1,5);
		$domain = preg_replace(array('/http:/','/https:/','/www./'),"",$website);
		$domain =substr($domain, 2,5);
	
		if ($domain != $mail){return FALSE;}
		else{return TRUE;}
	}
	//--------------------------------------------------------------
	function aboutcheck($pagehtml,$url){
		$newlink;
		foreach ($pagehtml as $a){
			if (strpos($a,'about') !== false){
				$newlink = $a;	
				break;}
			elseif(strpos($a,'whoarewe') !== false){
				$newlink = $a;
				break;}
			elseif(strpos($a,'faq') !== false){
				$newlink = $a;
				break;}
			else{$newlink = '';}
		}
		$url = substr($url,0,0);
		if (strlen($url) > strlen($newlink)){
			return $url.$newlink;}
		else { return $newlink; }
	
	}
	//--------------------------------------------------------------
	public function aboutrun($faqlink){
		
		$arContext['http']['timeout'] = 5;
		$context = stream_context_create($arContext);
		$html1 = file_get_html($faqlink,false,$context);
		$html2 = myVBOUT::process2($html1);
		$html2 = implode($html2);
		$html2 = preg_replace('/style=\\"[^\\"]*/','', $html2);
		$html2 = strip_tags($html2);
		$html2 = myVBOUT::findtheend($html2);
		return $html2;
	}
	//--------------------------------------------------------------
	//--------------------------------------------------------------
	//--------------------------------------------------------------
	//--------------------------------------------------------------
	function returnlargestArray($array){
		$size = '';
		foreach($array as $element){
			if (strlen($element) > strlen($size)){ $size = $element;}
		}
		return $size;
	}
	//--------------------------------------------------------------
	function findtheend($mstring){
		//go to 3000 characters
		$nstring = explode('.',$mstring);
		$number = 0;
		$newarray = array();
		foreach ($nstring as $sentence){
			$number = $number + strlen($sentence);
			$newarray[] = $sentence;
			$newarray[] ='. ';
			if (strlen($number)>1200){break;}
		}
		$r = implode($newarray);
		return $r;
	}
	
	public function RUNIT(){
		$master = myVBOUT::MasterKey($this->weburl);
		$grade = myVBOUT::gradingsystem($master,$this->email);
		$flag = myVBOUT::domainmatch($this->email,$this->weburl);
		$newarray = array('grade'=> $grade[0],'level'=>$grade[1],'flag'=> $flag);
		return $master + $newarray;
	}
	
	public function checkurl($string){
		$newvar = '';
		if (substr($string,0,4) != 'http'){
			$newvar = 'http://'.$string;
		}
		else {$newvar = $string;}
		$newvar = trim(preg_replace('/\s\s+/','', $newvar));
		return $newvar;
	}
}
//===============END OF CLASS=======================================

function myclock($starttime, $runtime){
	$runtime1 = $runtime - $starttime;
	$hours = $runtime1/3600;
	$totalminutes = $runtime1 / 60;
	$minutes = $totalminutes % 60;
	$seconds = $runtime % 60;
	return "TIME: [".floor($hours)."hr] : [".floor($minutes)." min] : [".$seconds."sec]";
}

