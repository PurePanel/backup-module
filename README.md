# backup-module

### What to do before backing up sites on the active server.

- You need to connect the StorageBox before activating it from the settings.

        cat ~/.ssh/id_rsa.pub | ssh -p23 uXXXXX@uXXXXX.your-storagebox.de install-ssh-key

- You can then turn on the site backup setting in the settings so that the backup process is performed automatically on a daily basis.
### Pre-requisites Before Adding Server/Jobs
 - Install the relevant PostgreSQL version inside the server you connected for PostgreSQL backups;
   -     sudo apt-get install -y postgresql-client-14
 - Configure the database auth information using .pgpass or .my.cnf. This configuration allows you to take backups without a password.
   - For MySQL (name your file the same as the relevant job slug):
     
         echo "[client]" > ~/.{database_name}.cnf
         echo "user=zoho_zoho" >> ~/.{database_name}.cnf
         echo "password=your_password" >> ~/.{database_name}.cnf
         chmod 600 ~/.{database_name}.cnf
   
   - For PostgreSQL:
         
         echo "{host}:{port}:{database_name}:{username}:{password}" >> ~/.pgpass && chmod 600 ~/.pgpass

 - Granting access to StorageBox. This access allows password-free transfers to your StorageBox.
   -     cat ~/.ssh/id_rsa.pub | ssh -p23 uXXXXX@uXXXXX.your-storagebox.de install-ssh-key
