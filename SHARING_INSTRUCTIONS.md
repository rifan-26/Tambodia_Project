# Media Sharing Instructions

To ensure media files uploaded by one user appear in all users' dashboards, follow these steps:

## 1. Set Up Shared Database
All users must connect to the same MySQL database:
- Update your `.env` file with the same database credentials
- Ensure the database server is accessible from all user machines

## 2. Configure APP_URL
All users must use the same APP_URL in their `.env` files:
```
APP_URL=http://YOUR_LOCAL_IP:8000
```
Replace `YOUR_LOCAL_IP` with the actual IP address of the machine running the server.

## 3. Storage Configuration
Media files are stored in `storage/app/public/media` and served via a symbolic link.

### Create the symbolic link:
```bash
php artisan storage:link
```

If the command fails, manually create the symbolic link:
```bash
# On Windows (run as administrator)
mklink /D "public\storage" "..\storage\app\public"

# On Linux/Mac
ln -s ../storage/app/public public/storage
```

## 4. File Path Storage
When storing media files, only save the relative path:
```php
$path = $request->file('file')->store('media', 'public');
$media->path = $path; // e.g., "media/filename.jpg"
```

## 5. Displaying Media Files
Use the Laravel asset helper to generate URLs:
```php
<img src="{{ asset('storage/' . $media->path) }}" alt="{{ $media->name }}">
```

In JavaScript:
```javascript
const url = `/storage/${filePath}`;
```

## 6. Running the Application
Each user should run the Laravel development server:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

This allows other users on the network to access the application.

## 7. Network Access
Ensure your firewall allows connections on port 8000, and that all users are on the same network.

## Troubleshooting
1. If media doesn't appear:
   - Check that the symbolic link exists (`public/storage` should point to `storage/app/public`)
   - Verify all users have the same APP_URL in their `.env` files
   - Confirm all users are connected to the same database

2. If files don't load:
   - Check that the file exists in `storage/app/public/media`
   - Verify the web server has read permissions for the storage directory

3. If statistics are inconsistent:
   - Ensure all users are querying the same database
   - Check that database connections are properly configured