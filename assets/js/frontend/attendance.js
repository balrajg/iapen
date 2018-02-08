;(function ($) {
    "use strict";
    function _ready() {
        
        $('#select_course').change(function () {
          var courseId= $(this).val();
          if(courseId != ""){
              $.ajax({
                url: '?lp-ajax=get-all-students-for-course',
                data: $(".attendanceForm").serialize(),
                error: function () {
                   
                },
                dataType: 'json',
                success: function (response) {
                   if(response.length){
                       $.each(response, function(k,v){
                           var html = "<tr><td>"+v.user_nicename+" </td><td><input type='checkbox' value='"+v.user +"' name='attendance_"+v.course_id +"' /> </td> </tr>"
                           $(".attendance_table table").append(html);
                       })
                   }
                  
                }
            });
          }else{
              alert("Please select valid option")
          }
          
            
            return false;
        });
    }

    $(document).ready(_ready);
})(jQuery);