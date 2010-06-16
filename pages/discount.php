<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница получения скидок
 */
class discount_Page extends View {

    /*
     * Инициализация страницы
    */
    public static function initController ($action) {
        // Получаем список настроений
        $moods=MD_Mood::getMoods();
        // Получаем список тэгов
        $tags=MD_Mood::getTags();

        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['site']['title'] = "Скидки Казань";
        self::$page['site']['keywords'] = "скидки казань, акции Казань, распродажи Казань";
        self::$page['site']['description'] = '';
        self::$page['content']['moods']=$moods;
        self::$page['content']['tags']=$tags;
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /*
     * Показ страницы скидок
    */
    public static function indexAction ($uri) {

        self::$page['site']['page'] = 'Скидки';
        self::$page['content']['discounts'] = MD_Discount::getDiscounts();

        self::showXSLT('pages/discount/index');
    }

    /*
     * Редактирования информации о ресторане
    */
    public static function editAction ($id) {
        $auth=Session::get('is_auth');
        $id=Session::get('rest_id');
        if (!$auth) {
            Router::setPage('/'.CityPlugin::getCity().'/discount/');
        }

        $restaurant = MD_Discount::getPartnerById($id);
        if (!empty($_POST)) {
            $data=$_POST;
            if (DB::getCount('beta_rest_info','rest_id='.DB::quote($id))>0) {
                DB::update('beta_rest_info', $data,'rest_id='.DB::quote($id));
            } else {
                $data['rest_id']=$id;
                DB::insert('beta_rest_info', $data);
            }
            self::$page['content']['info']=$_POST;
        } else {
            self::$page['content']['info']=DB::getRecord('beta_rest_info','rest_id='.DB::quote($id));
        }

        File::saveMultiFile('file/restaurant/'.$id,true,array(
                'upload_photo' => 'photo',
                'upload_description' =>  'description',
                'upload_menu' =>  'menu',
                'default' => 'file'
        ));

        self::$page['content']['restaurant'] = $restaurant;
        // Показываем страницу
        self::showXSLT('pages/discount/edit');

    }

    /*
     * Ajax действие получения скидки
    */
    public static function getAjaxAction ($id) {
        // Получаем данные из POST
        echo MD_Discount::getDiscount($_POST['phone'],$_POST['email'],$_POST['name'],$id);
        if (!empty($_POST['registration'])) {
            MD_Auth::registration($_POST['name'],$_POST['mail'],$_POST['phone']);
        }
    }

    /*
     * Ajax действие получения приглашение ресторана
    */
    public static function inviteAjaxAction ($id) {
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $name=$_POST['name'];
        $rest=$_POST['rest'];
        DB::insert('beta_invite', array(
                'name'=>$name,'email'=>$email,'phone'=>$phone,'title_rest'=>$rest
        ));
        echo "Заявка принята";
    }

    /*
     * Ajax действие авторизации
    */
    public static function authAjaxAction ($id) {
        $login=DB::quote($_POST['login']);
        $password=DB::quote($_POST['password']);
        if (DB::getCount('beta_users','login='.$login.' AND password='.$password)>0) {
            $rest=DB::getValue('beta_users', 'beta_restaurant_id','login='.$login.' AND password='.$password);
            Session::set('is_auth', true);
            Session::set('rest_id', $rest);
            echo "OK";
        }
        else echo "NOTFOUND";
    }

    /*
     * Ajax действие выхода из страницы редактирования ресторана
    */
    public static function logoutAction ($id) {
        Session::drop('is_auth');
        Session::drop('rest_id');
        Router::setPage('/'.CityPlugin::getCity().'/discount/');
    }
}