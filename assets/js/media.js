/*==============================                
 : old crop i.e. recropping on clicking on image container
================================*/

$(document).on("click",".c img",function(){
    var ps = $(this).data('preset');
    elem = $(this);
    i = $(this).attr('src');
    $img = $(document).find("#modal .img-container img");
    $img.attr('src',i);
    re_crop(i,ps,elem);
});

function re_crop(img,ps,elem){
    var cropBoxData;
    var canvasData;
    var crop_data;
    var cropper;
  $('#modal').modal("show");
    $.ajax({
            url:'requests.php/get_settings/'+ps,
            type:'post',
            dataType:'json',
            success:function(response){
              console.log(response);
              var dir = response.directory;
              var w = response.size['0'];
              var h = response.size['1'];
            $('#modal').on('shown.bs.modal', function () {
              if(response.ps =='default'){
                cropper = new Cropper(image, {
                    checkCrossOrigin:false,
                    autoCropArea: 0.9,
                    zoomable:false,
                    ready: function () {
                      $(document).find('img').each(function(){
                        $(this).attr('crossOrigin','anonymous');
                      });
                      cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                      cropBoxData = cropper.getCropBoxData();
                      canvasData = cropper.getCanvasData();
                    },
                    crop: function(e) {
                      cropBoxData = cropper.getCropBoxData();
                      canvasData = cropper.getCanvasData();
                    },
                });
              }else{
                  cropper = new Cropper(image, {
                    checkCrossOrigin:false,
                    width:w,
                    height:h,
                    aspectRatio:w/h,
                    autoCropArea: 0.9,
                    zoomable:false,
                    ready: function () {
                      $(document).find('img').each(function(){
                        $(this).attr('crossOrigin','anonymous');
                      });
                      cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                      cropBoxData = cropper.getCropBoxData();
                      canvasData = cropper.getCanvasData();
                    },
                    crop: function(e) {
                      cropBoxData = cropper.getCropBoxData();
                      canvasData = cropper.getCanvasData();
                    },
                });
            }
          });
            }
      });

  $(document).on('click', '#cropBtn', function () {
      var url     = 'requests.php/upload';
      var id      = elem.data('id');
      var ps      = elem.data('preset');
      var cropedimage = cropper.getCroppedCanvas().toDataURL('image/jpeg');
      var cs      =  cropedimage.substring(11,20);
        $.ajax(url,{
            data:{id:id, preset:ps, ftype:cs},
            type:'post',
            dataType:'json',
            beforeSend:function(){
              $('#modal').modal('hide');
              elem.attr('src',cropedimage);
            },
            success:function(response){
              uploadSuccess(response,cropedimage);
              secondRequest(cropedimage,response.upload_id,response.path);
            },                    
            error:function(response){
              Notifier.error("Access or Extension Error !");
            }
        });
        cropper.destroy();
    });
}

function secondRequest(image,upload_id,path){
    $.ajax({
          url:'requests.php/moreProcessing',
          type:'post',
          data:{id:upload_id,path:path,image:image},
          success:function(){
            Notifier.success("success");
        }
    });
}

/*==============================                
 : selecting and cropping and uploading new image
================================*/

$(document).on("change",".new_crop_js",function(){
  elem      = $(this);
  var ps      = $(this).data('preset');
  var reader    = new FileReader();
    var img     = document.getElementById("image");
    reader.onload   = function (e) {
      document.getElementById("image").src = e.target.result;
      $('#modal').modal('show');
    }
    reader.readAsDataURL(this.files[0]);
    re_crop(img.src,ps,elem);
});
$(document).ready(function(){
  $(document).on('load','img',function () {
    $(this).attr('crossOrigin','anonymous');
  });
})

/*==============================                
 : load gallery list
================================*/

$(document).on('click','.load_list',function(){
  var offset  = $(this).data('offset');
  var url   = base_url+'list/'+offset;
  $.ajax({
    url:url,
    type:'post',
    dataType:'json',
    success:function(response){
      $(document).find('#gallery-list-modal ');
    }
  })
})

/*==============================                
 : copy to clipboard
================================*/
$(document).on('click','.copy_clip',function(){
  var parent = $(this).parent();
  var dir = parent.data('directory');
  var title = parent.data('title');
  var id = parent.data('id');
  var txt = $(this).data('txt');
  var message ='';
  if(txt=='url'){
    message = "{{key-site_url-key}}"+dir+'/'+title;
    $('#url').val(message);
  }else{
    message = '<div><img src="{{key-site_url-key}}cropper/get_image/'+title+'/'+id+'" alt="img"></div>';
    $('#url').val(message);
  }
    elem = $(document).find('#url');
    elem.select();
    if(document.execCommand('copy')){
      Notifier.success('Copied value \n'+message);
      return false;
    }  
})


/*==============================                
 : pagination next page gallery
================================*/
$(document).on('click','.npg_js',function(){
  var last_id = $(this).data('last_id');
  var preset = $(this).data('preset');
  var url = base_url+'cropper/next/'+last_id;
  $.ajax({
    url:url,
    type:'post',
    dataType:'html',
    data:{last_id:last_id, direction:'next', preset:preset},
    success:function(res){
      $(document).find('.gallery-page .gallery-grid').html(res);
    }
  })
})

/*==============================                
 : pagination previous page gallery
================================*/
$(document).on('click','.ppg_js',function(){
  var last_id = $(this).data('last_id');
  var preset = $(this).data('preset');
  var url = base_url+'cropper/previous/'+last_id;
  $.ajax({
    url:url,
    type:'post',
    dataType:'html',
    data:{last_id:last_id, direction:'previous', preset:preset},
    success:function(res){
      $(document).find('.gallery-page .gallery-grid').html(res);
    }
  })
})


/*==============================                
 : show thumbnail as soon as the file is uploaded
================================*/

function uploadSuccess(response,cropedimage){
  $.ajax({
    url:'requests.php/preview',
    type:'post',
    data:{id:response.upload_id,img:cropedimage},
    dataType:'html',
    success:function(re){
      $(document).find('.gallery-page .gallery-grid').prepend(re);
    }
  })

}


/*==============================                
 : toggle gallery images on clicking on .toggle_gallery_js class
================================*/
$(document).on('click','.toggle_gallery_js',function(){
  $(document).find('.gallery-page-outer').toggle('show');
})


/*==============================                
 : remove media
================================*/
$(document).on('click','.delete_media',function(){
  var parent = $(this).parent();
  var id=$(this).data('id');
  $.ajax({
    url:base_url+'cropper/delete/',
    type:'post',
    dataType:'json',
    data:{id:id},
    success:function(response){
      parent.toggle('show');
      Notifier.success('Removed Successfully');
    }
    
  })

})