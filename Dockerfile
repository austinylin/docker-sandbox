FROM tutum/apache-php:latest
RUN rm -fr /app
VOLUME '/app'
EXPOSE 80
CMD "/run.sh"
