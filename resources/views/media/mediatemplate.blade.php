<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">

    <style type="text/css">
      .container {
        max-width: 100% !important;
      }
    </style>
  </head>
  <body>
    <div class="container" id="mediaContainer">
        <form method="post" action="{{route('media.upload')}}" enctype="multipart/form-data"
              class="dropzone" id="dropzone">
            @csrf
        </form>

       <div id="the-progress-div">
          <span class="the-progress-text"></span>
        </div>

        <div class="row">
          <div class="col-lg-12">
              <div class="projects-list">
                  <div id="media_data">
                    <p style="color: green;">Fetching media...</p>
                  </div>
              </div>
          </div><!--end .col -->
        </div>
    </div>

    <input type="hidden" id="option_select" value="{{$options['select']}}">
    <input type="hidden" id="option_select_type" value="{{$options['select_type']}}">
    <input type="hidden" id="option_delete" value="{{$options['delete']}}">
    <input type="hidden" id="input_name" value="{{$options['input_name']}}">

    <div id="overlay">
         <p style="color: green;">Loading...</p>
    </div>
    <script type="text/javascript">
        window.parent.$('#mediaiFrameLoading').hide();
        $(window).load(function(){
           $('#overlay').fadeOut();
        });
        Dropzone.options.dropzone = {
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
            maxFilesize: 10,
            timeout: 60000,
            init : function() {
              $("#the-progress-div").width(0 + '%').hide();
              $(".the-progress-text").text(0 + '%');
                this.on("addedfile", function(file) { console.log('New file added'); });
                //this.on("thumbnail", function(file,fileurl) { console.log('Thumbnail added'); });
                this.on("removedfile", function(file) { console.log('Files removed from dropzone'); });
                this.on("totaluploadprogress", function(progress) {
                    $("#the-progress-div").width(progress.toFixed(2) + '%').show();
                    $(".the-progress-text").text(progress.toFixed(2) + '%');
                 });
                this.on("queuecomplete", function() { 
                    fetch_data();
                });
                this.on("error", function(file, response) { 
                    console.log(response);
                     $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.msg)
                });
                this.on("success", function(file) {
                });
            },
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
        }
        fetch_data();
        function fetch_data(){
            $('#media_data').find('table').addClass('loading');
              var page = $('#hidden_page').val();
              var select = $('#option_select').val();
              var select_type = $('#option_select_type').val();
              var option_delete = $('#option_delete').val();
              var params = {
                page,select,select_type,delete: option_delete
              };
              $.ajax({
                type: 'GET',
                url: "{!! route('media.data.search') !!}",
               data: params,
               success:function(data){
                    $('#media_data').html('').html(data);
                    $('#media_data').find('table').removeClass('loading');
                    return false;
               }, error: function(e){
                    $('#media_data').find('table').removeClass('loading');
                    alert(e.responseText);
                    return false;
               }
              });
              return false;
        }

        $(document).on('click', '.media_pagination a', function(event){
            event.preventDefault();
            if($(this).hasClass('disabled')){
                return false;
            }
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            fetch_data();
        });

        $(document).on('click', '.chooseImage', function(event){
           event.preventDefault();
           var img_url = $(this).attr('data-url');
           var img_id = $(this).attr('data-id');
           var input_name = $('#input_name').val();
           var parent = window.parent;
           if($('#option_select_type').val() == 'single') {
              parent.$('.'+input_name).html(`<div><img src="${img_url}" height="100px;" width="100px;">
                            <input type="hidden" class="image-holder-input" name="${input_name}" value="${img_id}"></div>`);
              parent.$('#mediaModal').modal('hide');
           }else{
             parent.$('.'+input_name).append(`<div><img src="${img_url}" height="100px;" width="100px;">
                            <input type="hidden" class="image-holder-input" name="${input_name}[]" value="${img_id}"></div>`);
           }
           parent.success_msg('Image selected');
        });

        $(document).on('click', '.copyMediaLink', function(event){
            copyToClipboard($(this).attr('data-url'));
        });

        $(document).on('click', '.copyMediaId', function(event){
            copyToClipboard($(this).attr('data-id'));
        });

        function copyToClipboard(element) {
          var $temp = $("<input>");
          $("body").append($temp);
          $temp.val(element).select();
          document.execCommand("copy");
          $temp.remove();
          parent.success_msg('Copied');
        }

        

    </script>
  </body>
</html>