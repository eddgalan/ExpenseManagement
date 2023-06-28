FROM debian:11.3
WORKDIR /var/www/html
COPY dependences.sh /var/www/html/dependences.sh
RUN sh dependences.sh
CMD apachectl -DFOREGROUND
# CMD php spark serve -port 8080
# CMD php spark serve --host 0.0.0.0 --port 8081
