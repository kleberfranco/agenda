# Agenda

## 1 - Requirements
- Doker compose (https://docs.docker.com/compose/install/) 
- Git (https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

## 2 - Clone project
`` git clone https://github.com/kleberfranco/agenda.git ``  

## 3 - Run docker
- cd local clone project

`` docker-compose up -d --build``

## 4 - Dependencies project backend
`` docker-compose exec app bash ``<br />
`` cd /var/www/agenda``<br />
`` composer install``<br />

## 5 - Dependencies project frontend
`` docker-compose exec app bash ``<br />
`` cd /var/www/agenda``<br />
`` bower install --allow-root ``<br />

## 6 - Access
- Acess: http://localhost/
- API: http://localhost/doc

# Create database 
`` docker-compose exec db bash ``<br />
`` mysql --user=user --password=password``<br />
`` CREATE DATABASE phonebook; ``<br />
`` USE phonebook; ``<br />
`` CREATE TABLE `contacts` (
     `contactid` int(11) NOT NULL AUTO_INCREMENT,
     `name` varchar(250) NOT NULL,
     `phone` varchar(15) NOT NULL,
     `email` varchar(250) NOT NULL,
     `status` tinyint NOT NULL,
     `dt_cad` datetime DEFAULT NULL,
     `dt_alt` datetime DEFAULT NULL,
     PRIMARY KEY (`contactid`)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1; ``