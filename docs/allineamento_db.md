

1. export del crm su alpha


su alpha (infoalberghi2) il checkout viene fatto su alpha.info-alberghi.com/public/


database: alpha
username: alpha
pwd: env.PWD_ALPHA_DB


> mysqldump -ualpha -p alpha > alpha_crm_080321.sql



lo copio in locale

> scp alpha-te.com:/var/www/html/alpha.info-alberghi.com/alpha_crm_080321.sql ./


il dump di alpha deve alimentare il DB crm_ia della VM homestead

lo copio nella cartella condivisa con la VM

> cp alpha_crm_080321.sql /home/luigi/VirtualDB/


- da dentro la VM mi collego al db e 

> use crm_ia;
> source alpha_crm_080321.sql;



- da dentro /home/vagrant/VirtualProjects/crm_lara6 rilancio le migrazioni che sono legate ai seeder che importano i dati da crm_ia

