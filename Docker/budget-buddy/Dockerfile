FROM ubuntu:latest
ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /var/budget-buddy
RUN apt update
RUN apt upgrade -y
RUN apt install -y apache2
RUN apt install -y php libapache2-mod-php php-mysql
RUN apt install -y nano git net-tools
RUN apt-get install php-curl
RUN rm -rf /var/www/html
COPY ./data/ .
RUN chmod +x /var/budget-buddy/main.sh
VOLUME ["/var/www/html"]
CMD /var/budget-buddy/main.sh
