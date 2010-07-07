<?php /* Smarty version 2.6.19, created on 2010-07-02 17:10:18
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'footer.tpl', 76, false),)), $this); ?>
		</div>
		<!-- /Content -->
		<?php if (! $this->_tpl_vars['bNoSidebar']): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'sidebar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
	</div>

        <div id="auth_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть"></img>
                <div class="clear"></div>
                <img class="form_loader" id="auth_loader" src="/public/images/loader.gif" alt="загрузка.."></img>
                <div class="title">Войти на кухню</div>
                <div class="message" id="auth_message"></div>
                <div id="auth_form" class="ajax_form form_dialog">
                    <div class="label">e-mail (номер мобильного телефона):</div>
                    <input type="text" name="login" id="auth_login" class="form_input rounded" />
                    <div class="label">пароль:</div>
                    <input type="password" name="password" id="auth_password" class="form_input rounded" />
                    <span id="remain_me" >Помни меня</span>
                    <input id="remain_me_check" name="remember" type="checkbox" />
                    <div class="clear"></div>
                    <input type="button" id="auth_submit" value="Войти" />
                    <div style="margin-top:10px;">
                        <a href="#" class="passwd">Вспомнить пароль</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="passwd_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть"></img>
                <div class="clear"></div>
                <img class="form_loader" id="passwd_loader" src="/public/images/loader.gif" alt="загрузка.."></img>
                <div class="title">Восстановить пароль</div>
                <div class="message" id="passwd_message"></div>
                <div id="passwd_form" class="ajax_form form_dialog">
                    <div class="label">e-mail (номер мобильного телефона):</div>
                    <input type="text" name="login" id="passwd_login" class="form_input rounded" />
                    <div class="clear"></div>
                    <input type="button" id="passwd_submit" value="Выслать пароль" />
                </div>
            </div>
        </div>

        <div id="registration_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть" />
                <div class="clear"></div>
                <img class="form_loader" id="reg_loader" src="/public/images/loader.gif" alt="загрузка.." />
                <div class="title">Регистрация нового гурмана</div>
                <div class="message" id="reg_message"></div>
                <div id="registration_form" class="ajax_form form_dialog">
                    <div class="label">имя:</div>
                    <input type="text" class="form_input rounded" name="reg_name" id="reg_name" />
                    <div class="label">номер мобильного телефона:</div>
                    <input type="text" class="form_input rounded" name="reg_phone" id="reg_phone" />
                    <div class="label">e-mail:</div>
                    <input type="text" class="form_input rounded" name="reg_mail" id="reg_mail" />
                    <div style="padding:15px 0">
                        <input type="checkbox" id="reg_rules" />
                        <span >ознакомлен с </span><a href="/kazan/content/rules">правилами</a>
                    </div>
                    <input type="button" id="registration_submit" value="Я — гурман!" />
                </div>
                <img src="/public/images/dorozhka.png" style="margin-top:-3px;" alt="дорожка" />
            </div>
        </div>
	<!-- Footer -->
	<div id="footer">
		
	<!-- /Footer -->

</div>
<?php echo smarty_function_hook(array('run' => 'body_end'), $this);?>

</body>
</html>