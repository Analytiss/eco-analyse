DOCKER_COMPOSE = docker-compose
EXEC_APP = $(DOCKER_COMPOSE) exec -it app
CONNECT_APP = $(DOCKER_COMPOSE) exec -it app /bin/bash

dependencies:
	$(EXEC_APP) composer install
	$(EXEC_APP) npm install
	$(EXEC_APP) symfony console d:d:c --if-not-exists
	$(EXEC_APP) symfony console d:m:m --no-interaction
	$(EXEC_APP) npm run dev
	$(EXEC_APP) chmod -R 777 var/

upgrade:
	$(DOCKER_COMPOSE) stop
	$(DOCKER_COMPOSE) build
	$(DOCKER_COMPOSE) up -d

boot:
	$(DOCKER_COMPOSE) up -d

connect:
	$(CONNECT_APP)

start: boot dependencies

stop:
	$(DOCKER_COMPOSE) stop

restart: stop start