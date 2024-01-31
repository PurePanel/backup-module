# backup-module

### Pre-requisites Before Adding Server/Jobs
 - Install the relevant PostgreSQL version inside the server you connected for PostgreSQL backups;
   -     sudo apt-get install -y postgresql-client-14
 - Configure the database auth information using .pgpass or .my.cnf. This configuration allows you to take backups without a password.
   - For MySQL (name your file the same as the relevant job slug):
     
         echo "[client]" > ~/.job-slug.cnf
         echo "user=zoho_zoho" >> ~/.job-slug.cnf
         echo "password=your_password" >> ~/.{job-slug}.cnf
         chmod 600 ~/.job-slug.cnf
   
   - For PostgreSQL:
         
         echo "{host}:{port}:{database_name}:{username}:{password}" >> ~/.pgpass && chmod 600 ~/.pgpass

 - Granting access to StorageBox. This access allows password-free transfers to your StorageBox.
   -     cat ~/.ssh/id_rsa.pub | ssh -p23 uXXXXX@uXXXXX.your-storagebox.de install-ssh-key
