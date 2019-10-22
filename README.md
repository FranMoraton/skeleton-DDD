# skeleton-DDD

~~~~Docker~~~~
#creamos nuestra infraestructura
docker-compose build && docker-compose up -d

docker exec -it skeleton_api bash

~~~~Gestion de Paquetes y dependencias~~~~
composer install

~~~~crear y actualizar BBDD~~~~
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force

~~~~RabbitMQ.Local~~~~
#crear las disntintas queues
php bin/console rabbitmq:setup-fabric

#consumir mensajes de la cola en local -m numero de mensajes
php bin/console rabbitmq:setup-fabric rabbit:consumer example
php bin/console rabbitmq:setup-fabric rabbit:consumer -m 1 example

exit from docker
