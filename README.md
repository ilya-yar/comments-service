# Сервис комментариев

## Задание

1. Сделать сервис предназначенный для добавления комментариев к неким сущностям, набор которых будет меняться.
2. Сущность к которой прикрепляется комментарий идентифицируется двумя полями:
    - subject - вид сущности (к примеру 'product')
    - subject_id - идентификатор сущности
3. Каждая сущность может иметь много комментариев.
4. Комментарии оставляю пользователи на веб-страничке. Авторизация не требуется.
5. Поля формы (первые два чисто технические):
    - subject    (required)
    - subject_id (required)
    - username
    - comment    (required)
6. При сохранении комментария необходимо также сохранять IP, user agent, дату создания.
7. предусмотреть статус для комментария. создаваться он будет в статусе New и может быть модерирован (модерация в задание не входит).  Стастусы могут быть:
    - New
    - Approved
    - Rejected
8. Страницы которые должны быть:
    - создание комментария (см п 4)
    - список комментариев
        - с фильтрами по:
            - subject
            - subject_id
            - username
            - дате создания
        - колонки грида
            - subject
            - subject_id
            - username
            - дата создания
            - комментарий (первые 150 символов)
            - actions - линк на открытие деталей комментария
        - страница деталей комментария, где все вышеперечмсленные поля можно менять
9. Точки апи:
    - создание комментария (см п 4)
    - список комментариев - параметры фильтрации и поля как у грида
    - получение комментария по id
10. Заполнить коменты отзывами с yandex.market - парсинг нескольких штук.
11. Создание структуры базы предполагается самостоятельное.
12. Если знаком с docker, swagger то их применение приветсвуется.

## Развертывание проекта

1. Склонировать проект: git clone https://github.com/ilya-yar/comments-service.git
2. Перейти в директорию проекта: cd comments-service/.
3. Запустить окружение: docker-compose -f docker/docker-compose.yml up -d
4. Перейти в папку приложения: cd app.
5. Установить нужные пакеты: composer install
6. Инициализировать проект ../app/init --env=Development --overwrite=All
7. Отредактировать файл app/common/config/main-local.php и заполнить данные для подключения к БД:  
   POSTGRES_DB: yii-template-db  
   POSTGRES_USER: "root"  
   POSTGRES_PASSWORD: "root"  
   host=db.  
   port=5432.  
8. Подключиться к контейнеру docker exec -it docker_app_1 bash 
9. Выполнить команду миграции БД php /var/www/app/yii migrate
10. Заполнить таблицу comment тестовыми данными: php /var/www/app/yii fixture/load Comment
11. Добавить локальные домены в /etc/hosts:  
   127.0.0.1       testtask.loc  
   127.0.0.1       api.testtask.loc  

## Получение комментариев из Яндкекс маркет

В контейнере app выполнить команду: 
php /var/www/app/yii parser/yandex https://market.yandex.ru/product--smartfon-realme-10/1772726467/reviews?cpa=1
В параметре нужно передать ссылку на страницу "Отзывы" для любого товара.
