# Agenda

## 1 - Requirements
- Doker compose (https://docs.docker.com/compose/install/) 
- Git (https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

## 2 - Clone project
`` git clone https://github.com/kleberfranco/agenda.git ``  

## 3 - Run docker
- cd local clone project

`` docker-compose up -d --build app``

## 4 - Dependencies project backend
`` docker-compose exec app bash ``<br />
`` cd /var/www/agenda``<br />
`` composer install --no-interaction --optimize-autoloader ``<br />

## 5 - Dependencies project frontend
`` docker-compose exec node bash ``<br />
`` cd /var/www/agenda``<br />
`` bower install --allow-root ``<br />

## 6 - Access
- 1 - Set hosts 127.0.0.1 agenda.dev

- 2 - Acess: http://agenda.dev/
- API: http://agenda.dev/doc

# Create database (If docker does not create)
`` docker-compose exec db bash ``<br />
`` mysql --user=user --password=password ``<br />
`` CREATE DATABASE phonebook; ``<br />
`` USE phonebook; ``<br />
`` CREATE TABLE `contacts` (
     `contactid` int(11) NOT NULL AUTO_INCREMENT,
     `name` varchar(250) NOT NULL,
     `phone` varchar(15) NOT NULL,
     `email` varchar(250) NOT NULL,
     `status` tinyint NOT NULL,
     `createdAt` datetime DEFAULT NULL,
     `updateAt` datetime DEFAULT NULL,
     PRIMARY KEY (`contactid`)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1; ``