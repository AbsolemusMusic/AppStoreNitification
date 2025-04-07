FROM php:8.2-apache

# Копируем файлы в контейнер
COPY . /var/www/html/

# Включаем модуль Apache для rewrite (если нужен)
RUN a2enmod rewrite

# Открываем порт 80
EXPOSE 80
