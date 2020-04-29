set -o allexport
[[ -f .env ]] && source .env
set +o allexport

docker exec "$1" /usr/bin/mysqldump -u "${DB_USERNAME}" --password="${DB_PASSWORD}" "${DB_DATABASE}" > docker exec -i "$2" /usr/bin/mysql -u "${DB_USERNAME}" --password="${DB_PASSWORD}" "${DB_DATABASE}"
