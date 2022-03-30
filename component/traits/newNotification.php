<?php 

use app\models\Notification;

trait newNotification {
    function createNotification($model,$title,$type) {
        
        $notification = new Notification();
        $notification->username = $model->username;
        $notification->title = $title;
        $notification->type_id = $type;
        $notification->state_id = Notification::STATE_UNREAD;
        $notification->model_id = get_class($model);
        $notification->created_on = date('Y-m-d H:i:s');
        $notification->created_by_id = '1';
        $notification->save(false);
    }
}

?>