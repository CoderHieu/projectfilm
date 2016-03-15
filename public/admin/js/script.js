//AngularJS
var myApp = angular.module('myApp', []);


$(document).ready(function(){
	$('.reset').click(function(){
		$('#frm-admin')[0].reset();
	});
	$('.add').click(function(){
	    $('#frm-admin').submit();
	    return false;
	});
	$('#btn_show').click(function(){
		if($('.menu_tool').hasClass('move-div')){
			$('.menu_tool').removeClass('move-div');
		}else{
			$('.menu_tool').addClass('move-div');
		}
	});

  //set height sidebar
  var height_main = $( window ).height() - (50 + 35);
  $('.sidebar').height(height_main);

  $('.sidebar').hover(function(){
      if($(this).hasClass('move_sidebar')){
          $(this).removeClass('move_sidebar');
      }else{
          $(this).addClass('move_sidebar');
      }
  });
  $(".select2").select2();


	$('a.delete').click(function(){
    	var xacnhanxoa = confirm('Bạn có chắc muốn xóa không?');
    	if(xacnhanxoa==true){
			$(this).parent().parent().fadeOut();
    		var id = $(this).attr('seq');
    		var control = $(this).attr('control');
            if(id != '')  
            { 
              $.ajax
              ({
                 method: "POST",
                 url: "admin/"+control+"/delete",
                 data: { id:id},
              });
            }
    	}		
	});
	$('a.div_hienthi').click(function(){
        var divid = $(this).attr('divid');
        var id = $(this).attr('seq');
        var control = $(this).attr('control');
        if(id != '')  
        {
              $.ajax
              ({
                 method: "POST",
                 url: "admin/"+control+"/show",
                 data: { id:id},
                 dataType: "html",
                  success: function(data){
                    $( '.'+divid ).html( data );
                  }
              });
        }       
    });
    $('a.div_active').click(function(){
        var divid = $(this).attr('divid');
        var id = $(this).attr('seq');
        var control = $(this).attr('control');
        if(id != '')  
        {
              $.ajax
              ({
                 method: "POST",
                 url: "admin/"+control+"/active",
                 data: { id:id},
                 dataType: "html",
                  success: function(data){
                    $( '.'+divid ).html( data );
                  }
              });
        }       
    });
    $('#search').keyup(function(){
        var keyword = $(this).val();
        var control = $(this).attr('control');
        if(keyword != '')  
        {
              $.ajax
              ({
                 method: "POST",
                 url: "admin/"+control+"/search",
                 data: { keyword:keyword},
                 dataType: "html",
                  success: function(data){
                    $('#div_load').html( data );
                  }
              });

        }      
    });
    $('.check-all').click(function() {  //on click
        if(this.checked) { // check select status
            $('.checkbox-menu').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox-menu').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    $('a#del-all').click(function(){
        if($('.check-all').is(':checked') || $('.checkbox-menu').is(':checked')) {
          var xacnhanxoa = confirm('Bạn có chắc muốn xóa không?');
          var control = $(this).attr('control');
          if(xacnhanxoa==true){
            var listid="";
            $("input[name='chon']").each(function(){
            if(this.checked){
              $(this).parent().parent().fadeOut();
              listid = listid+","+this.value;
            } 
            })
            listid=listid.substr(1);
            if(listid != '')  
            {
                $.ajax
                ({
                 method: "POST",
                 url: "admin/"+control+"/deleteall",
                 data: { listid:listid},
                });
                return false;
            }
          }
        }else{
          alert('Vui lòng chọn đối tượng bạn muốn thao tác!!');
        }
    });
    $('a#show-all').click(function(){
        if($('.check-all').is(':checked') || $('.checkbox-menu').is(':checked')) {
          var control = $(this).attr('control');
          $("input[name='chon']").each(function(){
          if(this.checked){
            var divid = $(this).parent().parent().find('.publish').children('a.div_hienthi').attr('divid');
            listid = this.value;
            $.ajax
              ({
               method: "POST",
               url: "admin/"+control+"/showall",
               data: { listid:listid},
               dataType: "html",
                  success: function(data){
                    $( '.'+divid ).html( data );
                  }
              });
          } 
          });
        }else{
          alert('Vui lòng chọn đối tượng bạn muốn thao tác!!');
        }
    });
    $('a#permission').click(function(){
        if($('.check-all').is(':checked') || $('.checkbox-menu').is(':checked')) {
            var id_role = $('#id_role').val();
            var listid="";
            var unlistid="";
            $("input[name='chon']").each(function(){
            if(this.checked){
              listid = listid+","+this.value;
            }else{
              unlistid = unlistid+","+this.value;
            } 
            })
            listid=listid.substr(1);
            unlistid=unlistid.substr(1);
            if(listid != '')  
            {
                $.ajax
                ({
                 method: "POST",
                 url: "admin/role/updatepermission",
                 data: { listid:listid,unlistid:unlistid,id_role:id_role},
                });
                alert('Cập nhật phân quyền thành công!');
                return false;
            }
        }else{
          alert('Vui lòng chọn đối tượng bạn muốn thao tác!!');
        }
    });
    $('.sort').change(function() {
	      var id = $(this).attr('seq');
	      var sort = $(this).val();
	      var control = $(this).attr('control');
	      if(id != '')  
	      {
	          $.ajax
	          ({
	             method: "POST",
	             url: "admin/"+control+"/sort",
	             data: { id:id, sort:sort},
	          });
	      }       
	   });
    $('#typeid').change(function() {
        var typeid = $(this).val();
        var control = $(this).attr('control');
        if(typeid != '')  
        {
            $.ajax
            ({
              method: "POST",
              url: "admin/"+control+"/listcate",
              data: { typeid:typeid },
              dataType: "html",
              success: function(data){
                  $('#cateid').html(data);
              }
            });
        }       
     });
     $('.menu_item').click(function() {
          //$(this).parent().find('.fa-angle-down').css("display", "block");
          $(this).parent().find('.menu_child').animate({
              height: "toggle"
          }, 300);
     }); 
     $('#birthday').datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss'
    });
    $('#parentid').change(function(){
        var parentid = $(this).val();
        var id = $(this).attr('seq');
        var control = $(this).attr('control');
        if(parentid != '')  
        {
              $.ajax
              ({
                 method: "POST",
                 url: "admin/"+control+"/changeparentid",
                 data: { id:id,parentid:parentid},
                 dataType: "html",
              });
        }       
    });
    setTimeout(function(){
        $('.success').fadeOut('400');
    }, 2000);

    var opts = {
        on: {
          load: function(e, file) {
            var fileDiv = $('#box_img');
              var img = new Image();
              img.onload = function() {
                fileDiv.html(img);
              };
            img.src = e.target.result;
          }
        }
    };
    FileReaderJS.setupInput(document.getElementById('image'), opts);

    var opts_bg = {
        on: {
          load: function(e, file) {
            var fileDiv_bg = $('#box_img_bg');
              var img_bg = new Image();
              img_bg.onload = function() {
                fileDiv_bg.html(img_bg);
              };
            img_bg.src = e.target.result;
          }
        }
    };
    FileReaderJS.setupInput(document.getElementById('image_bg'), opts_bg);

    var opts_fv = {
        on: {
          load: function(e, file) {
            var fileDiv_fv = $('#box_img_fv');
              var img_fv = new Image();
              img_fv.onload = function() {
                fileDiv_fv.html(img_fv);
              };
            img_fv.src = e.target.result;
          }
        }
    };
    FileReaderJS.setupInput(document.getElementById('favicon'), opts_fv);

});