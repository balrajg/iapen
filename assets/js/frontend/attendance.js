;(function ($) {
    "use strict";
    function _ready() {
        
        $('#select_course').change(function () {
          var courseId= $(this).val();
          if(courseId != ""){
              alert($('input[name="_wp_http_referer"]').val());
              $.ajax({
                url: '?lp-ajax=get-all-students-for-course',
                data: $(".attendanceForm").serialize(),
                error: function () {
                    //$button.removeClass('loading');
                },
                dataType: 'json',
                success: function (response) {
                   console.log(response);
                  
                }
            });
          }else{
              
          }
          
            
            return false;
        });
    }

    $(document).ready(_ready);
})(jQuery);