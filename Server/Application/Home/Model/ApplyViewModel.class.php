<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2017/2/5
 * Time: 15:17
 */

namespace Home\Model;
use Think\Model\ViewModel;


/*报名视图模型
   模型列: id, user_id, user_name, user_realname, activity_id, activity_name, time, rate, ispass
*/
class ApplyViewModel extends ViewModel {
    public $viewFields = array(
        'apply'=>array('id', 'userid'=>'user_id', 'activityid'=>'activity_id', 'time', 'rate', 'isjoin'),
        'volunteer'=>array('username'=>'user_name', 'realname'=>'user_realname', '_on'=>'apply.userid=volunteer.id'),
        'activity'=>array('name'=>'activity_name', '_on'=>'apply.activityid=activity.id')
    );
}