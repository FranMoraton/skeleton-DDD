FROM nginx
RUN rm /etc/nginx/conf.d/default.conf \
    && mkdir /etc/nginx/includes \
    && mkdir /usr/local/www
COPY ./docker/nginx/nginx-http.conf /etc/nginx/conf.d/
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80