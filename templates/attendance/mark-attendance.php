<?php
/**
 * Template for displaying checkout form
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */
if (!defined('ABSPATH')) {
    exit;
}

learn_press_print_notices();

do_action('learn_press_before_mark_attendance');
echo "<pre>";
print_r($courses);
echo "</pre>";
?>
<h3>Select a course to mark attendance for</h3>
<form name="attendanceForm" class="attendanceForm" action="#">
    <input type="hidden" name="current_user" value="<?php get_current_user_id() ?>" />
    <select name="select_course" id="select_course">
        <option value="">Select Course</option>
        <?php
        foreach ($courses as $course) {
            ?>
            <option value ="<?php echo $course['course_id'] ?>"><?php echo $course['coursename'] ?></option>
            <?php
        }
        ?>

    </select>
    
    <div class="attendance_table">
        
        
    </div>


</form>
