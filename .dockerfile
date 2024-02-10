FROM php:8.2.4-cli
WORKDIR /var/www/html
COPY . /var/www/html
EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80"]