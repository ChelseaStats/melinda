<?php
// DEFINE
define('SLACKENDPT'	, 'https://hooks.slack.com/services/[redacted]');
define('TW_KEY1'	, '[redacted]');
define('TW_KEY2'	, '[redacted]');
define('TW_KEY3'	, '[redacted]');
define('TW_KEY4'	, '[redacted]');
define('MAIL_SERVER'	, '[redacted]');
define('MAIL_PORT'	, '[redacted]');
define("MAIL_AUTH"	, '[redacted]');


// USAGE
$melinda = new messenger();
$melinda->slack($message, $botName, $emoji, $room);
$melinda->twitter($message, $user);
$melinda->email($message, $title, $toAddress);
$melinda->screen($message, $alertBoostrapColor);

// CLASS
class messenger {

		public static function twitter( $message, $user ) {
			$user = strtoupper($user);
			switch($user) {
				case 'test':
				default :
					$connection = new TwitterOAuth( TW_KEY1, TW_KEY2, TW_KEY3, TW_KEY4);
					$connection->get('account/verify_credentials');
					$connection->post('statuses/update',array('status' => $message));
				break;
		}
				
		public static function slack($message, $name, $icon, $room = "[redacted]") {
			
			$room = ($room) ? $room : "[redacted]";
			$icon = ($icon) ? $icon : "[redacted]";
			$data = json_encode(array(
					"username"      => $name,
					"channel"       => "#{$room}",
					"text"          => $message,
					"icon_emoji"    => ":{$icon}:"
				));
			
			$ch = curl_init( SLACKENDPT );
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => $data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			return $result;
		}		

		public static function email( $message, $title, $email = 'noreply@domain.uk' ) {
			
			wp_mail( $email, 'New: ' . $title, $message );
		}
		
		public static function screen( $message, $alert ) {
			
			return '<div class="alert alert-' . $alert . '">' . $message . '</div>';
		}

		public function dbg($code) {
			
			print '<h5>'.gettype($code).'</h5>';
			print '<pre>';
			print_r($code);
			print '</pre>';
			print '<hr/>';
		}	
}
