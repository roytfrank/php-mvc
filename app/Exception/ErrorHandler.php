<?php declare (strict_types = 1);

namespace App\Exception;
use App\Classes\Mail;

class ErrorHandler {

	public function handle($error_number, $error_message, $error_file, $error_line) {
		$error = "There is an error numbet {$error_number}, the message {$error_message}, the file is {$error_file}, and the line is {$error_line}";
		$environment = getenv("APP_ENV");
		if ($environment === 'local') {
			$whoops = new \Whoops\Run;
			$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
			$whoops->register();
		} else {
			$data = [
				'to' => getenv("ADMIN_EMAIL"),
				'name' => 'Site Admin',
				'subject' => 'error report from site',
				'view' => 'errors',
				'body' => $error,
			];
			self::emailAdmin($data)->outputFriendlyError();
		}
	}

	public function outputFriendlyError() {
		ob_end_clean();
		return view('errors/app');
		exit;
	}

	public static function emailAdmin($data) {
		$mail = new Mail;
		$mail->send($data);
		return new static; //for method chaining
	}

}