<?php

class Mail {

	protected $object;
	protected $content;
	protected $personal_object;
	protected $personal_content;

	public function __construct($object, $content) {
		global $config;
		$this->object = $object;
		$this->content = $content;
		$this->replace(array('%title%' => $config['title']));
		if (getProject()) {
			if (onlyDefaultProject()) {
				$this->replace(array('%project%' => ''));
			}
			else {
				$this->replace(array('%project%' => getProject()));
			}
		}
	}

	public function replace($find) {
		foreach ($find as $k => $v) {
			$this->content = str_replace($k, $v, $this->content);
			$this->object = str_replace($k, $v, $this->object);
		}
		$this->personal_object = $this->object;
		$this->personal_content = $this->content;
	}

	public function replace_personal($find) {
		foreach ($find as $k => $v) {
			$this->personal_content = str_replace($k, $v, $this->content);
			$this->personal_object = str_replace($k, $v, $this->object);
		}
	}

	public function send($to) {
		global $config;
		if (!$config['email']
			|| !filter_var($to, FILTER_VALIDATE_EMAIL))
			{ return true; }
		
		$title = htmlspecialchars_decode($config['title']);
		$from = '=?UTF-8?B?'.base64_encode($title)."?=";
	
		$headers  = 'From: '.$from.' <'.$config['email'].'>'."\n";
		$headers .= 'MIME-Version: 1.0'."\n";
		$headers .= 'Content-Type: text/plain; charset="UTF-8"'."\n";
		$headers .= 'Content-Transfer-Encoding: 8bit'."\n";
		$headers .= "\n";
	
		$object = '=?UTF-8?B?'.base64_encode($this->personal_object).'?=';


		if(!empty($config['sendgrid_auth'])){
			$data = Array ( 
				"personalizations" => Array ( 
					Array ( 
						"to" => Array ( Array ( "email" => $to ) ),
						"subject" => $object
					) 
				),
				"from" => Array ( "email" => $from ),
				"content" => Array ( 
					Array ( 
						"type" => "text",
						"value" => $this->personal_content
					) 
				) 
			);
			$data_string = json_encode($data);
		
		
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json', 
				'Authorization: Bearer '.$config['sendgrid_auth'],
			    'Content-Length: '.strlen($data_string)
			));
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			// if not successful
			if( $httpCode != "202" ){
				// send normal mail
				mail($to, $object, $this->personal_content, $headers);
			}
			return true;
		}
		else{
			return mail($to, $object, $this->personal_content, $headers);
		}
	}


}

?>