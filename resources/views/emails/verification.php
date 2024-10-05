<!DOCTYPE html>
    <html lang="en">
        <head>
           <meta charset="utf-8">
               <title>REJOY STORE</title>
           <meta name="viewport" content="width=device-width, initial-scale = 1.0">
           <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body>
	<h4>Welcome To Rejoystore <?=$data['name']?></h4>
         <h5 class="text-primary">REJOY STORE Account Verification:</h5>
           <p>Thank you for registering with Rejoy store,
           Please click or copy and paste the link below in the browser to verify your account</p><br />
           http://mystore.local/verify/user/<?=$data['verification_token']?>
           <h4>Rejoy Store @2019</h4>
</body>
</html>