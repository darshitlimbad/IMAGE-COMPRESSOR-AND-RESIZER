## Project Name: Image Compressor and Resizer

---

# Image Compressor and Resizer

Hello everyone!

This is a small project to compress any image into any MIME type and to change the dimensions of the image.

### Steps:

1. **Install**: Download and extract this entire directory to your server.
2. **Open Index File**: Open `index.php` in any text editor.
3. **Set Dimensions**: 
   - Go to line 17.
   - Adjust the `$imgDimensions` variable.
   - If you don't want to change the dimensions, set them to `null`.
4. **Set Quality**: 
   - Go to line 23.
   - Set the `$quality` value between 10 to 100.
5. **Start Apache Server**: Start your Apache server and open `index.php` in your browser.
6. **Upload Image**: 
   - Upload the image you want to compress and click submit.
   - If everything goes well, you will see a success message.
   - The compressed image will be located in the `__DIR__/compressed_image` folder with your image name postfixed `_compressed`.

### Features

- Supports JPEG, PNG, and WebP image formats.
- Allows custom image dimensions.
- Adjustable image quality from 10 (lowest) to 100 (highest).
- Easy to set up and use.

### Requirements

- PHP 7.0 or higher
- Apache server

### Usage

1. **Setting Dimensions**:
   ```php
   $imgDimensions = [
       'height' => 800, // Set desired height
       'width' => 600   // Set desired width
   ];
   ```
   If you don't want to change the dimensions, set both values to `null`:
   ```php
   $imgDimensions = [
       'height' => null,
       'width' => null
   ];
   ```

2. **Setting Quality**:
   ```php
   $quality = 80; // Set quality between 10 and 100
   ```

3. **Start Apache Server**:
   Open terminal or command prompt and start Apache server:
   ```sh
   sudo service apache2 start
   ```
   Or use XAMPP/WAMP if you're on Windows.

4. **Upload Image**:
   - Open the project in your browser (e.g., `http://localhost/your_project_directory/index.php`).
   - Select the image file to upload.
   - Click the submit button.
   - Check the `compressed_image` folder for the output.

### License

   IMAGE COMPRESSOR AND RESIZER - PHP based project
   Copyright (C) 2024  Darshit Limbad

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <https://www.gnu.org/licenses/>.


Feel free to suggest improvements or report issues. Happy coding!

### Contact

For further information or support, please reach out at:

- Email: darshitlimbad+git@example.com
- LinkedIn: [DarshitLimbad](https://www.linkedin.com/in/darshit-limbad/)