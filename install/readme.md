## Installation

1. Point virtual host to this root directory. An example would be as follows

```nginx
server {
    listen 80;
    server_name ehba-local.com www.ehba-local.com;

    root /epiclabs23/ehba;
    index index.php index.html;

    # Access and error logs
    access_log /var/log/nginx/ehba-local.com.access.log;
    error_log /var/log/nginx/ehba-local.com.error.log;

    # Handle Laravel pretty URLs
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM configuration
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security and performance
    location ~ /\.ht {
        deny all;
    }

    client_max_body_size 100M;
    sendfile on;
    keepalive_timeout 65;
}
```

2. Allow PHP write permission:

- Allow PHP write permission To the core directory `sudo chown -R nhd:www-data core/ -R` . to make sure the installer can create `.env` file.
- Allow PHP write permission to the `assets/images` directory `sudo chown -R nhd:www-data assets/images -R`
- Allow PHP write permission to the `assets/admin/images` directory `sudo chown -R nhd:www-data assets/admin/images -R`
- Allow PHP write permission to the `storage` directory `sudo chown -R nhd:www-data storage/ -R`

3. Create the database
4. Hit the `<base_url>/install` url in your browser
5. Fill out the form. use db server along with port like `localhost:3306`
6. Increase `max_execution_time` and `max_input_time` in `php.ini` file to make sure it keeps alive until the response of the remote servers' response is received

## Administration

Admin URL: `<base_url>/admin`

Use the admin login credentials used during installation

### Settings

Cron Setup:

```bash
crontab -e

# Run every minute
* * * * * curl -s http://epic-hosting-business-automation.com/cron
```

Go to `System Settings` and complete rest of the settings
