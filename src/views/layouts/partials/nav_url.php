<?php
    if(array_key_exists('activeOn', $args)){
        $args['class'] = (array_key_exists('class', $args)) ? $args['class'].' '.isActiveUrl($args['activeOn']['seg'],$args['activeOn']['string']):isActiveUrl($args['activeOn']['seg'],$args['activeOn']['string']);
    }
?>
<li <?php  echo ( array_key_exists('class', $args) ) ? 'class="'.$args['class'].'"':''; ?> >
    <a href="<?php  echo ( array_key_exists('route', $args) ) ? \URL::route($args['route']):URL::to($args['url']); ?>" >
        <?php  echo (array_key_exists('icon', $args))  ? '<i class="fa fa-'.$args['icon'].'"></i>':''; ?>
        <?php  echo $title; ?>
    </a>
</li>