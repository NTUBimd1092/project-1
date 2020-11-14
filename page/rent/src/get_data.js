function Favorate(myObj, userid) {
	$(document).ready(function () {
		$.ajax({
			type: "POST",
			url: "get_data.php",
			data: {
				'Action': 'Favorate',
				'Link': myObj.id,
				'userid': userid
			},
			contentType: "application/x-www-form-urlencoded; charset=utf-8",
			success: function (data) {
				var text = data.substr(-6);
				if (text == 'Insert') {
					// alert("收藏");
					$(myObj).attr("src", "images/selectedFav.png");
				} else if (text == 'Delete') {
					// alert("移除");
					$(myObj).attr("src", "images/favorite.png");
				}
			},
			error: function (e) {
				console.log("error", e)
			}
		});
	})
}