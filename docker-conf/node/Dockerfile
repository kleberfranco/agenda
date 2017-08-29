FROM node:latest
RUN apt-get -yq update && apt-get -yq install git bzip2 automake build-essential

RUN npm install -g bower grunt-cli
WORKDIR /var/www/agenda
#RUN bower install --allow-root
#RUN bower install bootstrap --allow-root

CMD ["bash"]