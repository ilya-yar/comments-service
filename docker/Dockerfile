# Базовый образ с nginx и php. TODO php и nginx лучше разнести в разные контейнеры
FROM richarvey/nginx-php-fpm

# Приложение
ADD app /var/www/app

# Удаляем конфиги сайтов которые там есть
RUN rm -Rf /etc/nginx/sites-enabled/*

# Добавляем наш конфиг
ADD docker/conf/nginx/site.conf /etc/nginx/sites-available/site.conf

# The /run/nginx directory does not exist on the latest alpine containers.
RUN mkdir -p /run/nginx
# Create logs directory
RUN mkdir /var/www/app/log
RUN touch /var/www/app/log/frontend-access.log

# Включаем его
RUN ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf
