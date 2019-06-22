FROM debian:stretch-slim as extension_builder

RUN apt-get update && \
    apt-get -y install apt-transport-https curl gnupg2 lsb-release ca-certificates && \
    curl https://packages.sury.org/php/apt.gpg | apt-key add - && \
    sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' && \
    apt-get update && \
    apt-get install -y php-pear php7.1-dev && \
    pecl install mongodb && \
    pecl install xdebug

FROM debian:stretch-slim

RUN apt-get update && \
    apt-get -y install apt-transport-https curl gnupg2 lsb-release ca-certificates sudo && \
    curl https://packages.sury.org/php/apt.gpg | apt-key add - && \
    sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' && \
    apt-get update

RUN apt-get install -y bash-completion && \
    echo 'if [ -f /etc/bash_completion ]; then source /etc/bash_completion; fi' >> /etc/bash.bashrc
 
RUN apt-get install -y \
    php7.1 \
    php7.1-apcu \
    php7.1-apcu-bc \
    php7.1-bz2 \
    php7.1-common \
    php7.1-gd \
    php7.1-imagick \
    php7.1-json \
    php7.1-redis \
    php-pear \
    php7.1-ssh2 \
    php7.1-bcmath \
    php7.1-cli \
    php7.1-curl \
    php7.1-fpm \
    php7.1-intl \
    php7.1-mbstring \
    php7.1-opcache \
    php7.1-pgsql \
    php7.1-soap \
    php7.1-xml \
    php7.1-zip \
    php7.1-mcrypt \
    php7.1-mysqli

COPY --from=extension_builder /usr/lib/php/20160303/mongodb.so /usr/lib/php/20160303/mongodb.so
COPY --from=extension_builder /usr/lib/php/20160303/xdebug.so /usr/lib/php/20160303/xdebug.so

RUN sh -c 'echo "extension=mongodb.so" >> /etc/php/7.1/mods-available/mongodb.ini' && \
    ln -s /etc/php/7.1/mods-available/mongodb.ini /etc/php/7.1/fpm/conf.d/20-mongodb.ini && \
    ln -s /etc/php/7.1/mods-available/mongodb.ini /etc/php/7.1/cli/conf.d/20-mongodb.ini && \
    sh -c 'echo "zend_extension=/usr/lib/php/20160303/xdebug.so" >> /etc/php/7.1/mods-available/xdebug.ini' && \
    sh -c 'echo "xdebug.default_enable=1" >> /etc/php/7.1/mods-available/xdebug.ini' && \
    sh -c 'echo "xdebug.remote_enable=1" >> /etc/php/7.1/mods-available/xdebug.ini' && \
    sh -c 'echo "xdebug.remote_autostart=1" >> /etc/php/7.1/mods-available/xdebug.ini' && \
    ln -s /etc/php/7.1/mods-available/xdebug.ini /etc/php/7.1/fpm/conf.d/00-xdebug.ini && \
    ln -s /etc/php/7.1/mods-available/xdebug.ini /etc/php/7.1/cli/conf.d/00-xdebug.ini && \
    ln -s /usr/sbin/php-fpm7.1 /usr/sbin/php-fpm && \
    sh -c 'mkdir /run/php /run/sshd'

RUN apt-get install -y \
    openssh-client \
    vim-tiny \
    htop \
    git

ARG APP_USER_ID=1001
ARG APP_USERGROUP_ID=1001

RUN if [ $(grep ${APP_USERGROUP_ID} /etc/group) ]; then \
        OLD_NAME=$(grep ${APP_USERGROUP_ID} /etc/group | cut -d ':' -f1); \
        groupmod -n apps $(grep ${APP_USERGROUP_ID} /etc/group | cut -d ':' -f1); \
        echo "group $OLD_NAME renamed"; \
    else \
        groupadd -g ${APP_USERGROUP_ID} apps; \
    fi

RUN useradd -m -g ${APP_USERGROUP_ID} -s /bin/bash -u ${APP_USER_ID} apps && \
    usermod -aG apps www-data && \
    usermod -aG www-data apps && \
    echo "apps:123" | chpasswd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    sh -c 'sudo -u apps composer global require "hirak/prestissimo" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative  --no-interaction'

RUN curl http://gordalina.github.io/cachetool/downloads/cachetool.phar -o /usr/local/bin/cachetool && \
    chmod +x /usr/local/bin/cachetool

WORKDIR /home/apps

RUN echo "AllowUsers apps" >> /etc/ssh/sshd_config \
    && echo "export VISIBLE=now" >> /etc/profile \
    && /usr/bin/ssh-keygen -A \
    && mkdir /home/apps/.ssh \
    && chown -R apps:apps /home/apps/.ssh \
    && mkdir /var/log/php-fpm \
    && chown -R apps:apps /var/log/php-fpm \
    && mkdir /home/apps/files \
    && chown -R apps:apps /home/apps/files

EXPOSE 9000

CMD [ "sh", "-c", "php-fpm -F" ]