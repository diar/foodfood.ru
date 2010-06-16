; Настройки базы данных
base.host 	= 88.82.75.4
base.login 	= z-mode
base.password   = 150878
base.dbase 	= foodfood
base.bd 	= mysql
base.prefix 	= kazan

; Настройка путей приложения
path.plugins	= /engine/plugins/
path.libs	= /engine/libs/
path.core       = /engine/core/
path.models	= /models/
path.upload	= /upload/
path.cache	= /cache/
path.layouts	= /tpl/layouts/
path.pages	= /pages/
path.tpl	= /tpl/
path.tmp	= /tmp/

; Настройки роутинга
route.offset = 0
route.default_city = kazan
route.default_page = index
route.default_action = index

; Настройки сессии
session.name    = PHPSESSID
session.timeout    = null
session.use_cache = false
session.table = session

; Настройки куков
cookie.host = null ; хост для установки куков
cookie.path = / ; путь для установки куков

; Настройки авторизации
user.backend = ls
user.table_ls = user

; Настройка отладки
debug.enable = true

; Настройки отображения
view.engine = xslt

; Настройка кэша
cache.use       = false
; Вид кеширования file : files, memory : memcach
cache.type      = file
cache.prefix    = kazan