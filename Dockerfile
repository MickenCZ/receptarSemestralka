FROM php:8.2.4-cli
WORKDIR /var/www/html
COPY . /var/www/html
EXPOSE 80
CMD ["php", "-S", "3.75.158.163:80"]
