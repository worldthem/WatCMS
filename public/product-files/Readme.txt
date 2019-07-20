Protect this directory:
1) create .htaccess 
2)add text in this file (.htaccess):  

# Deny access to .htaccess

<Files .htaccess>

Order allow, 
deny
Deny from all

</Files>

3) create index.php with no content in 

4) not nececary but check with your hosting to close the access to empty folder

POINTS 1),2),3) ARE REQUAIRED