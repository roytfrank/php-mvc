<?php declare (strict_types = 1);

namespace App\Classes;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail {
	protected $mail;

	public function __construct() {
		$this->mail = new PHPMailer();
		$this->emailconf();
	}

	public function emailconf() {
		$this->mail->isSMTP();
		$this->mail->Host = getenv("SMTP_HOST");
		$this->mail->SMTPAuth = true;
		$this->mail->Mailer = getenv("MAILER");
		$environment = getenv("APP_ENV");
		$this->mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true,
			),
		);
		if ($environment === 'local') {
			$this->mail->SMTPDebug = 2;
		}
		$this->mail->Username = getenv("EMAIL_USERNAME");
		$this->mail->Password = getenv("EMAIL_PASSWORD");
		$this->mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		$this->mail->Port = getenv("SMTP_PORT");
	}

	public function send($data) {
		try {
			//Recipients
			$this->mail->setFrom(getenv("SUPPORT_EMAIL"));
			$this->mail->addAddress($data['to'], $data['name']); // Add a recipient
			$this->mail->addReplyTo(getenv("SUPPORT_EMAIL"), 'Reply');
			$this->mail->addCC('cc@example.com');
			// $this->mail->addBCC('bcc@example.com');
			// $this->mail->addAttachment('images/a.jpeg');
			// Content
			$this->mail->isHTML(true); // Set email format to HTML
			$this->mail->Subject = $data['subject'];
			$this->mail->Body = make($data['view'], array('data' => $data['body']));
			return $this->mail->send();
		} catch (Exception $e) {
			throw new \Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br />" . $e->getMessage());
		}
	}
}