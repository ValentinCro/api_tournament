FROM php:5.6.23-cli
MAINTAINER Saagie

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/bin/composer

# Install php-mongo
RUN apt-get update && \
    apt-get install php5-mongo -y

# Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_4.x | bash -
RUN apt-get install nodejs -y

# Make
RUN apt-get install make -y
RUN apt-get install g++ -y

# NPM Install
RUN npm install -g bower --unsafe-perm
RUN npm install --global gulp --unsafe-perm
RUN npm install -g karma --unsafe-perm

# Install NPM dependencies
RUN apt-get install -y libfreetype6 libfontconfig1

# Install Git (for Composer) & bzip2 (for NPM)
RUN apt-get install -y git bzip2

# Fix PHP.ini
RUN echo 'memory_limit=1024M\n\
date.timezone=Europe/Paris\n\
extension=/usr/lib/php5/20131226/mongo.so\n'\
>> /usr/local/etc/php/php.ini

# Add entrypoint
ADD execute.sh /execute.sh
RUN chmod 755 /execute.sh
ENTRYPOINT /execute.sh
