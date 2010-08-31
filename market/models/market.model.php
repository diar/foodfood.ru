<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Market extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        
    }

    /**
     * Получить список районов
     * @return array
     */
    public static function getLocations() {
        return DB::getRecords(self::getPrefix() . 'list_location');
    }

    /**
     * Оформление заказа
     * @return array
     */
    public static function order($name, $phone, $address, $trash) {
        // Проверяем номер телефона
        if (!$phone = String::toPhone($phone))
            $error = "Введите номер телефона в правильном формате";

        if (empty($_SESSION['trash']) || sizeof($_SESSION['trash'])==0)
            $error = "Вы должны добавить в корзину хотя бы 1 блюдо";

        if (!empty($error))
            return $error;

        $trash = $_SESSION['trash'];

        // Отправляем сообщение администраторам
        $partners = array();
        foreach ($trash as $item) {
            if (empty($partners[$item['rest_id']])) {
                $partners[$item['rest_id']] = array();
            }
            array_push($partners[$item['rest_id']], array('title' => $item['title'], 'portions' => $item['items']));
        }
        foreach ($partners as $rest_id => $partner) {
            $dishes = array();
            foreach ($partner as $dish) {
                $portions_text = '';
                foreach ($dish['portions'] as $portion) {
                    $portions_text.=$portion['portion'] . ' гр. - ' . $portion['count'] . ' шт.; ';
                }
                $dishes[] = $dish['title'] . ' (' . $portions_text . ') ';
            }
            $dishes_text = implode(', ', $dishes);

            // Добавляем заказ в логи
            DB::insert(Model::getPrefix() . 'market_orders', array(
                        'rest_id'=>DB::quote($rest_id),
                        'text'=>DB::quote($dishes_text),
                        'status'=>DB::quote('Принят'),
                        'start_time'=>'NOW()',
                        'address'=>DB::quote($address),
                        'phone'=>DB::quote($phone)
                    ),false);

            $admin = DB::getRecord(Model::getPrefix() . 'market_partner', 'rest_id=' . DB::quote($rest_id));
            $text = 'Заказ пользователя ' . $name . ' на номер ' . $phone . ' по адресу ' . $address . ': ' . $dishes_text;
            $sms_text = 'Заказ на номер ' . $phone . ':' . $dishes_text;
            if (!empty($admin['partner_email'])) {
                $mail = Mail::newMail($text, $admin['partner_email'], 'foodfood.ru');
                $mail->Send();
            }
            if (!empty($admin['partner_phones'])) {
                $phones = explode(',', $admin['partner_phones']);
                foreach ($phones as $admin_phone) {
                    MD_Sms::sendSms($admin_phone, $sms_text);
                }
            }
        }

        // Если все верно оформляем заказ
        $sms_user_text = 'Ваш заказ принят. Скоро вам позвонит менеджер ресторана';
        MD_Sms::sendSms($phone, $sms_user_text);

        return '<span style="color:green">Ваш заказ принят</span>';
    }

}