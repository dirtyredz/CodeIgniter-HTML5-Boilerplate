# CodeIgniter-HTML5-Boilerplate
Boilerplate for Codeigniter



    ./var/www/html                      # Server Web Directory (apache, nginx)
    ├── /CodeIgniter                    # Code Igniter sytem Root directory 
    ├── /Example.com                    # Website directory keep multiple virtual websites organized
    |    ├── /Application               # Codeigniters Application Folder
    |    └── /WWW                       # Your websites Root directory (Public Folder)
    |        ├── /css                   # public Css directory
    |        ├── /img                   # public Images directory
    |        ├── /js                    # public Javascript directory
    |        └── index.php              # Codeigniter index.php file
    |
    └── AnotherWebsite.com            # Anothe websites directory showing how multiple websites can share codeigniters system files
    
I seperate the Codeigniter system folder from the application so that I can have multipl websites using the same codeigniter system files.

Having the application folder outside of the Websites root directory is by design for security reasons.

