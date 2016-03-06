#!/bin/sh
rm -rf tsoha &&
git clone https://github.com/tuureilmarinen/tsoha.git &&
echo "Downloaded application" &&
psql < sql/drop_tables.sql &&
psql < sql/create_tables.sql &&
echo "Initalized database" &&
echo "insert into users values(DEFAULT,'admin','aR//VSL//j5Q6',now(),now(),true);" | psql &&
echo "Created first user: admin password: admin\nRemember to destroy this user when it is not needed anymore" &&
chmod -R 755 tsoha &&
cd tsoha &&
php composer.phar dump-autoload &&
chmod -R 755 *