(function(){
	'use strict';
	//check when document is ready and load specific page
	$(document).ready(function(){
		switch($("body").data("template-id")){
			case 'home':
			REJOY.store.featured();
			break;
			case 'cartItems':
			REJOY.store.cartpage();
			break;
			case'dashboard':
			REJOY.admin.dashboard();
            break;
			case 'singleProduct':
			REJOY.store.singles();
			break;
			case 'adminProduct':
            REJOY.admin.categorychangeevent();
			break;
			case 'adminAllProducts':
			REJOY.admin.productounavailable();
			REJOY.admin.producttoavailable();
			REJOY.admin.deleteproduct();
			break;
			case 'adminProductEdit':
			REJOY.admin.editeventchange();
			break;
			case 'adminCategories':
			REJOY.admin.update();
			REJOY.admin.delete();
			REJOY.admin.createsubcategory();
			REJOY.admin.editsubcategory();
			REJOY.admin.deletesubcategory();
			break;
			default:
		}
	});
})();