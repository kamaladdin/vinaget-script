<?php

class dl_crocko_com extends Download {

	public function CheckAcc($cookie){
		$data = $this->lib->curl("http://www.crocko.com/accounts", "language=en;".$cookie, "");
		if(stristr($data, 'Premium membership: Active<br />') || stristr($data, 'Premium membership: Expiring<br />')) return array(true, "Until ".$this->lib->cut_str($data, 'Ends:  ',', in'));
		else if(stristr($data, '<h4>Premium account <strong>active</strong></h4>')) return array(true, "Until ".$this->lib->cut_str($data, 'End time:  ',', in'));
		else if(stristr($data, 'Premium membership: No premium')) return array(false, "accfree");
		else return array(false, "accinvalid");
	}
       
    public function Login($user, $pass){
		$post["login"]= $user;
		$post["password"]= $pass;
		$data = $this->lib->curl("http://www.crocko.com/accounts/login", "language=en", $post);                        
		$cookie = "language=en;{$this->lib->GetCookies($data)}";
		return $cookie;
	}
	
    public function Leech($url) {
		if(stristr($url, "crocko.com/f/")) $this->error("Not Support Folder", true, false, 2);
		$data = $this->lib->curl($url, "language=en;".$this->lib->cookie, "");	
		if(stristr($data,"Sorry,<br />the page you're looking for<br />isn't here") || stristr($data,"Please go to home page or one of this links") || stristr($data,"Information is not available at this time")) 
		$this->error("dead", true, false, 2);
		elseif(!preg_match('@https?:\/\/d(\d+\.)?crocko\.com\/file_contents\/file\/id\/[A-Z0-9]+\/cont_id\/[0-9]+@i', $data, $giay))
		$this->error("notfound", true, false, 2);
		else 	
		return trim($giay[0]);
		return false;
    }
	
}

/*
* Open Source Project
* Vinaget by ..::[H]::..
* Version: 2.7.0
* Crocko.com Download Plugin By giaythuytinh176
* Fix by [FZ]
* Downloader Class By [FZ]
* Date: 18.7.2013
* Fixed login account by giaythuytinh176 [22.7.2013]
*/
?>