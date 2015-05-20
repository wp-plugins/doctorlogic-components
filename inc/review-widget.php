<?php
class drlogicReviewSummary extends WP_Widget 
{
  function drlogicReviewSummary()
  {
    $widget_ops = array('classname' => 'drlogicReviewSummary', 'description' => 'DoctorLogic Review Summary' );
    $this->WP_Widget('drlogicReviewSummary', 'DoctorLogic Review Summary', $widget_ops);
  }
 
  function form($instance)
  {
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    return $instance;
  }
 
  function widget($args, $instance)
  {
    echo $before_widget;
    echo do_shortcode('[DoctorLogicReviewSummary]');
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("drlogicReviewSummary");') );
?>