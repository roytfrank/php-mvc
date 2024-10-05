<!DOCTYPE html>
    <html lang="en">
        <head>
           <meta charset="utf-8">
               <title>REJOY PURCAHSE STATEMENT</title>
           <meta name="viewport" content="width=device-width, initial-scale = 1.0">
           <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body>
       <div class="alert alert-sucess"><h4><?=user()->name;?></h4></div>
         <p>Your order confirmation details :
         	<span><?=$data['order_id'];?></span></p>
          <table cellpadding="5px;" cellspacing="5px" border="0" width="600px;" style="border:1px solid black;">
          	   <tr class="bg-dark">
          	   	  <th>Product Name</th>
          	   	  <th>Unit Price</th>
          	   	  <th>Quantity</th>
          	   	  <th>Total</th>
          	   </tr>
          	<?php foreach ($data['product'] as $items): ?>
          	 <tr>
          	 	<td width="400px;"><?=$items['name']?></td>
          	 	<td width="100px;"><?=$items['saleprice']?></td>
          	 	<td width="50px;"><?=$items['quantity']?></td>
          	 	<td width="50px;"><?=$items['totalPrice']?></td>
          	 </tr>
          	<?php endforeach?>
          	<h4>Total Amount: <?=$data['total'];?></h4>
          </table>
       <p>Thanks for the purchase. We hope to hear from you again shortly</p>
            <h4>Rejoy Store @2019</h4>
</body>
</html>