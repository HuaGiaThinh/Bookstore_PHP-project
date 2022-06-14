// function changeStatus(url){
// 	$.get(url, function(data){
// 		var element		= 'a#status-' + data[0];
// 		var classRemoveActive = 'btn-success';
// 		var classRemoveIcon = 'fa-check';

// 		var classAddActive 	= 'btn-danger';
// 		var classAddIcon 	= 'fa-minus';

// 		if(data[1] == 'active'){
// 			classRemoveActive = 'btn-danger';
// 			classRemoveIcon = 'fa-minus';
// 			classAddActive 	= 'btn-success';
// 			classAddIcon 	= 'fa-check';
// 		}

// 		$(element).attr('href', "javascript:changeStatus('"+data[2]+"')")
// 		$(element).removeClass(classRemoveActive).addClass(classAddActive)
// 		$(element + ' i').removeClass(classRemoveIcon).addClass(classAddIcon)
// 	}, 'json');
// }

// function changeGroupACP(url){
// 	$.get(url, function(data){
// 		var element		= 'a#groupACP-' + data[0];
// 		var classRemoveActive = 'btn-success';
// 		var classRemoveIcon = 'fa-check';

// 		var classAddActive 	= 'btn-danger';
// 		var classAddIcon 	= 'fa-minus';

// 		if(data[1] == 1){
// 			classRemoveActive = 'btn-danger';
// 			classRemoveIcon = 'fa-minus';
// 			classAddActive 	= 'btn-success';
// 			classAddIcon 	= 'fa-check';
// 		}

// 		$(element).attr('href', "javascript:changeGroupACP('"+data[2]+"')")
// 		$(element).removeClass(classRemoveActive).addClass(classAddActive)
// 		$(element + ' i').removeClass(classRemoveIcon).addClass(classAddIcon)
// 		console.log(data);
// 	}, 'json');
// }

function submitForm(url){
	$('#main-form').attr('action', url);
	$('#main-form').submit();
}

function sortList(column, order){
	$('input[name=filter_column]').val(column);
	$('input[name=filter_column_dir]').val(order);
	$('#adminForm').submit();
}

function changePage(page){
	$('input[name=filter_page]').val(page);
	$('#main-form').submit();
}



function deleteItem(url) {
    let result = confirm("Bạn có chắc chắn muốn xóa không?");
    if (result) {
        window.location.replace(url)
    }
}


$(document).ready(function(){
	$('input[name=checkall-toggle]').change(function(){
		var checkStatus = this.checked;
		$('div.table-responsive').find(':checkbox').each(function(){
			this.checked = checkStatus;
		});
	})
	
	$('#filter-bar button[name=submit-keyword]').click(function(){
		$('#adminForm').submit();
	})
	
	$('#filter-bar button[name=clear-keyword]').click(function(){
		$('#filter-bar input[name=filter_search]').val('');
		$('#adminForm').submit();
	})
	
	$('#filter-bar select[name=filter_state]').change(function(){
		$('#adminForm').submit();
	})
	
	$('#filter-bar select[name=filter_group_acp]').change(function(){
		$('#adminForm').submit();
	})

	$('#currentPage').parent().addClass('active');

	$('.filter-element').on('change', function () {
		$('#filter-form').submit();
	});
})





