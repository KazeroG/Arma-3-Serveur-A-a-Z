<?php

class Notification
{
    public $id;
    public $title;
    public $picto;
    public $text;
    public $datetime;
    public $link;

    public function __construct($donnees = null)
    {
        if (is_array($donnees)) $this->constructArray($donnees);
    }

    /**
     * @param array $donnees
     */
    public function constructArray(array $donnees = []){
        foreach ($donnees as $key => $value) {
            $this->$key = $value;
        }
    }

    public function toArray(){
        $infosArray = [];
        foreach($this as $k => $v){
            $infosArray[$k] = $v;
        }
        return $infosArray;
    }

    public function add(){
        if($infoArray = $this->toArray()) {
            $id = DB::insert(NOTIFICATION_TABLE, $infoArray);
            return $id;
        }else{
            return false;
        }
    }

    public static function addStaffOnNotif($notif_id,$admin_id){
        $check2 = DB::insert(NOTIFICATION_BYADMIN_TABLE,array('notification_id'=>$notif_id,'admin_id'=>$admin_id,'status'=>1));
        if(isset($check2)) return true;
        else return false;
    }

    public static function byId($id){
        $sql = "SELECT notification.id, notification.title, notification.text, notification.picto, notification.link, notification.datetime, notification_by_admin.status
                FROM notification LEFT JOIN notification_by_admin ON notification.id=notification_by_admin.notification_id
                WHERE notification.id = $id";
        $res = DB::get()->query($sql);
        $res = $res->fetch();
        return new Notification($res);
    }

    public function setStatus($status){
        DB::update(NOTIFICATION_BYADMIN_TABLE,array('status'=>$status),array('notification_id'=>$this->id));
        return true;
    }

    public static function newNotifs($admin_id){
        $sql = "SELECT COUNT(notification.id) as count FROM notification LEFT JOIN notification_by_admin ON notification.id=notification_by_admin.notification_id
                WHERE notification_by_admin.admin_id = $admin_id AND notification_by_admin.status = 1";
        $res = DB::get()->query($sql);
        $res = $res->fetch();
        return $res['count'];
    }

    public static function getNotifs($admin_id){
        $sql = "SELECT notification.id, notification.title, notification.text, notification.picto, notification.link, notification.datetime, notification_by_admin.status
                FROM notification LEFT JOIN notification_by_admin ON notification.id=notification_by_admin.notification_id
                WHERE notification_by_admin.admin_id = $admin_id ORDER BY notification.datetime DESC";
        $res = DB::get()->query($sql);
        $res = $res->fetchAll();
        $return = [];
        foreach($res as $n){
            $return[] = new Notification($n);
        }
        return $return;
    }

    public function sendAll(){
        $admins = Admin::getAll();
        foreach($admins as $a){
            self::addStaffOnNotif($this->id,$a->id);
        }
    }

    public function sendAdmins(){
        $admins = Admin::getAdmins();
        foreach($admins as $a){
            self::addStaffOnNotif($this->id,$a->id);
        }
    }

    public static function newTicketNotif(){
        $notif = new Notification();
        $notif->title = "Nouveau Ticket";
        $notif->text = "Un nouveau ticket à été ouvert";
        $notif->datetime = date("Y-m-d H:i:s",time());
        $notif->link = "ticket.php";
        $notif->picto = "fa-ticket";
        $notif->id = $notif->add();
        return $notif;
    }

    public static function newSponsorCeilingNotif($ceil,$pid){
        $notif = new Notification();
        $notif->title = "Nouveau parrain lvl : $ceil";
        $notif->text = "Nouveau parrain lvl $ceil : $pid";
        $notif->datetime = date("Y-m-d H:i:s",time());
        $notif->link = "player.php?playerid=$pid";
        $notif->picto = "fa-user-plus";
        $notif->id = $notif->add();
        return $notif;
    }
}