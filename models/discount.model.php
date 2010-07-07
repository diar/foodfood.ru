<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления скидками
 */
class MD_Discount extends Model {

    /** Инициализация модели
     * @return string
     */
    public static function initModel () {
        self::setModelTable('rest_discount');
        self::setJoinTable(
                Array('join'=>'rest','left'=>'rest_id','right'=>'id')
        );
        self::disableCache();
    }

    /** Получить блок скидок (для главной)
     * @return array
     */
    public static function getDiscountBlock ($params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        $discounts=self::getAll(
                'discount_count>0','discount_percent DESC LIMIT 0,'.$count,
                array('select'=>'rest_id,rest_uri,discount_count,rest_title,discount_percent,discount_description')
        );
        return $discounts;
    }

    /** Получить все скидки
     * @return array
     */
    public static function getDiscounts ($params=null) {
        $discounts=self::getAll(
                'discount_count>0','discount_percent DESC',
                array('select'=>'rest_id,rest_uri,discount_count,rest_title,discount_percent,discount_description')
        );
        return $discounts;
    }

    /** Получить партнера по uri
     * @return string
     */
    public static function getPartnerByUri ($uri) {
        $partner = self::get('rest_uri='.DB::quote($uri),'discount_percent DESC');
        return $partner;
    }

    /** Получить партнера по id
     * @return string
     */
    public static function getPartnerById ($id) {
        $partner = self::get('rest_id='.DB::quote($id),'discount_percent DESC');
        return $partner;
    }

    /** Получить случайного партнера
     * @return string
     */
    public static function getPartner () {
        $partner = self::get();
        return $partner;
    }

    /** Получить количество скидок у партнера
     * @return string
     */
    public static function getPartnerDiscountCount ($rest_id) {
        $partner = self::value('discount_count', 'rest_id='.self::quote($rest_id));
        return $partner;
    }

    /** Получить партнеров, у которых есть в наличие скидки
     * @return string
     */
    public static function getPartnersActive () {
        $partners = self::getAll('discount_count>0');
        return $partners;
    }

    /** Получить отправленные скидки ресторана
     * @return null
     */
    public static function getPartnerDiscounts ($rest_id) {
        self::getAll('rest_id='.$rest_id, 'send_date DESC',array('table'=>'discount_send'));
    }

    /** Получить скидку
     * @return null
     */
    public static function getDiscount ($phone,$email,$name,$rest_id) {
        $partner = self::getPartnerById($rest_id);
        $date=date('Y-m-d H:i:s',time()-60*60*36);
        // Проверяем e-mail
        if (!String::isEmail($email))
            $error="Введите e-mail в правильном формате";
        // Проверяем номер телефона
        if (!$phone=String::toPhone($phone))
            $error="Введите номер телефона в правильном формате";
        // Проверяем не получил ли пользователь уже скидку
        $send_date = self::value('send_date',
                'phone='.DB::quote($phone).' AND partner_id='.
                DB::quote($partner['rest_discount_id']).' ORDER BY id DESC',
                array('table'=>'discount_send')
        );
        if ($send_date>$date) {
            $error="Вы уже получали скидку. Дождитесь пока пройдет 24 часа после получения предыдущей скидки";
        }
        // Проверяем остались ли скидки у ресторана
        if (self::getPartnerDiscountCount($rest_id)<1) {
            $error="У данного ресторана закончились скидки";
        }

        if (!empty($error)) return $error;
        // Если все верно выдаем скидку
        $sms_code = self::get('discount_activated=0 AND discount_id='.$partner['rest_discount_id'],null,Array(
                'table'=>'discount_list','join'=>'rest_discount','left'=>'discount_id','right'=>'id'
        ));
        $code = substr($sms_code['discount_secret'], 2, 3);

        $partner_uri = !empty($partner['rest_sms_uri']) ? $partner['rest_sms_uri'] : $partner['rest_title'];
        self::add(
                array(
                'name'=>DB::quote($name),
                'email'=>DB::quote($email),
                'phone'=>DB::quote($phone),
                'partner_id'=>DB::quote($partner['rest_discount_id']),
                'ident' => DB::quote($code),
                'send_date'=>'NOW()'
                ),false,array('table'=>'discount_send')
        );

        self::upd(array('discount_count' => 'discount_count-1'),'rest_id='.DB::quote($rest_id),false);

        $sms_text = $partner_uri.', скидка '.$partner['discount_percent'].'%. До '.
                date('d.m.Y',time()+60*60*24).'. № '.$sms_code['discount_counter'].' код '.$code;
        $result=MD_Sms::sendSms($phone, $sms_text);

        if ($result) {
            DB::update(
                    Model::getPrefix().'discount_list', Array('discount_activated'=>1), 
                    'id='.$sms_code['discount_list_id']
            );
            // Отправляем оповещение ресторатору
            $admin=DB::getRecord('admin_group_table', 'restaurant_id='.DB::quote($rest_id),null,
                    Array('join'=>'admin_table','left'=>'id','right'=>'group_id'));

            if (!empty($admin['email']) && $admin['send_log_email']==1) {
                $text = 'Отправлена скидка с id='.$ident.' пользователю с именем '.$name;
                $mail = Mail::newMail($text,$admin['email'],'foodfood.ru');
                $mail->Send();
            }

            return '<span style="color:green">SMS-скидка отправлена на номер '.$phone.'</span>';
        }
        else {
            return "Ошибка при отправке SMS-скидки. Попробуйте еще раз.";
        }
    }

}