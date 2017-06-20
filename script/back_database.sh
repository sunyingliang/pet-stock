#!/bin/bash
host={host}
username={username}
password={password}
database={database}
export_file='/opt/backups/database/{database}_'$(date +%Y%m%d%H%M%S)

command='mysqldump --host=${host} --username=${username} --password=${password} --databases ${database} --opt > ${export_file}';

eval ${command} || { echo 'backup database {'${database}'} failed'; exit 1; }
