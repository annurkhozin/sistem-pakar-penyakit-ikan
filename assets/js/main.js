var current_page = null;
var sammyApp = $.sammy(function () {
	function view(data) {
		document.title = stripHtmlTags(data.title);
		$(".html").html(data.html);
		var open = $("body.sidebar-open").html();
		if (open) {
			$("[data-widget=pushmenu]").click();
		}
	}

	this.get("#/", function (context) {
		context.redirect("#/apps?page=beranda");
	});
	this.notFound = function (context) {
		$.ajax({
			url: "error",
			method: "GET",
			cache: false,
			success: function (resp) {
				view(resp);
			},
			error: function (err) {},
		});
	};

	this.get("#/apps", function (context) {
		var page = this.params["page"];
		current_page = page;
		$.ajax({
			url: page,
			method: "GET",
			cache: false,
			success: function (resp) {
				view(resp);
			},
			error: function (err) {
				message("error", "Pastikan koneksi internet anda terhubung");
			},
		});
	});
});

$(function () {
	sammyApp.run("#/");
});

function stripHtmlTags(str) {
	if (str === null || str === "") {
		return false;
	} else {
		str = str.toString();
		return str.replace(/<[^>]*>/g, "");
	}
}
