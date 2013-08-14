
Module clone guide:
To make a clone
Step #1: set the value for $GLOBALS["MOD_DB_PREFIX"], for say, "pdb" (required)
Step #2: edit /sql/mysql.sql, change all table prefix to the specified value "pdb". For example, change "CREATE TABLE `planet_article`" to "CREATE TABLE `pdb_article`" (required)
         Note: leave field names as they are
Step #3: change all template name prefix to the new module dirname, including all templates in /templates/ and /templates/blocks/. For example, change planet_index.html to newmodule_index.html (required)
Step #4: install the cloned module as regular
