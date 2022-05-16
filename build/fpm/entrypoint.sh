#!/usr/bin/env bash

# update default values of PAM environment variables (used by CRON scripts)
env | while read -r line; do  # read STDIN by line
    # split LINE by "="
    IFS="=" read var val <<< ${line}
    # remove existing definition of environment variable, ignoring exit code
    sed --in-place "/^${var}[[:blank:]=]/d" /etc/security/pam_env.conf || true
    # append new default value of environment variable
    echo "${var} DEFAULT=\"${val}\"" >> /etc/security/pam_env.conf
done

su -c '/www/app/bin/console doctrine:database:create --if-not-exists --env=dev --no-interaction' -s /bin/bash
su -c '/www/app/bin/console doctrine:migrations:migrate --env=dev --no-interaction' -s /bin/bash
su -c '/www/app/bin/console doctrine:fixtures:load --env=dev --no-interaction' -s /bin/bash
su -c '/www/app/bin/console cache:clear --env=dev' -s /bin/bash

php-fpm
