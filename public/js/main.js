function notify(message = '', type = '',  icon = '', title = "Failed! : "){
	$.notify({
		title: title,
		message: message,
		icon: 'fa fa-'+icon,
	},{
		type: type,
		delay: 3000,
		animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutUp'
		},
	});
}

function previewImage() {
	document.getElementById("image-preview").style.display = "block";
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

	oFReader.onload = function(oFREvent) {
		document.getElementById("image-preview").src = oFREvent.target.result;
	};
};

function capitalize(s){
	if (typeof s !== 'string') return ''
		return s.charAt(0).toUpperCase() + s.slice(1)
}

const list_sidebar_menu = [
	{
		id: '#dashboard-menu',
		url: '/dashboard/home',
	},
	{
		id: '#users-menu',
		url: '/dashboard/users',
	},
	{
		id: '#comments-menu',
		url: '/comments/index',
	},
];

(function () {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();
	
	$(list_sidebar_menu).each(function(index, item){
		if(document.URL.indexOf(item.url) > -1){
			$(item.id).addClass('active');
		}
	})

})();
