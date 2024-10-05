(function(){
	"use strict";
	REJOY.admin.dashboard = function(){
        chart();    
      setInterval(chart, 3000);
	}
	function chart(){
      var revenue = document.getElementById('revenue');
      var orders = document.getElementById('orders')
      var orderLabels = [];
      var orderData = [];
      var revenueLabels = [];
      var revenueData = [];
      axios.get('/dashboard/chart').then((response)=>{   	 
      	 response.data.orders.forEach(function(monthly){
            orderData.push(monthly.count);
      	 	orderLabels.push(monthly.new_date);
      	 });
      	 response.data.revenue.forEach(function(monthly){
      	 	revenueData.push(monthly.amount);
      	 	revenueLabels.push(monthly.new_date);
      	 });
   new Chart(revenue, {
    type: 'bar',
    data: {
        labels: revenueLabels,
        datasets: [{
            label: '# Revenue',
            data: revenueData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderWidth: 1
        }]
    }
});
new Chart(orders, {
    type: 'bar',
    data: {
        labels: orderLabels,
        datasets: [{
            label: '# Orders',
            data: orderData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderWidth: 1
        }]
    }
});
});
 }
})();