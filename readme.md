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

This project is open-source and free to use. Contributions are welcome!

---

Feel free to suggest improvements or report issues. Happy coding!
