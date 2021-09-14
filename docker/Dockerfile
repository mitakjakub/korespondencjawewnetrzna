FROM php:5.6.12-apache as kw_php_base
RUN rm /etc/apache2/mods-available/php5.load && DEBIAN_FRONTEND=noninteractive apt update && DEBIAN_FRONTEND=noninteractive apt install php5-mysqlnd php5-mysqlnd-ms libapache2-mod-php5 -y && php5enmod mysqli && apt remove binutils cpp-4.9 g++-4.9 gcc-4.9 libasan1 libatomic1 libcilkrts5 libcloog-isl4 libgcc-4.9-dev libgomp1 libisl10 libitm1 liblsan0 libmpc3 libmpfr4 libquadmath0 libsigsegv2 libstdc++-4.9-dev libtsan0 libubsan0 m4 g++ gcc autoconf cpp make -y && apt-get clean && rm -rf /var/lib/{apt,dpkg,cache,log}/
FROM kw_php_base as kw_php
COPY KW/ /var/www/html/
