<form action="#" method="post" enctype="multipart/form-data">
    <div style="margin: 20px 10px;">
        <label for="videos">Upload MP4 Videos</label>
        <input type="file" name="videos[]" id="videos" accept="video/mp4" multiple>
        <br >
    </div>
    
    <div style="margin: 20px 10px;">
        <label for="compress">Compress the GIFs?</label>
        <input type="checkbox" name="compress" id="compress" value="yes">
        <br >
    </div>

    <input type="submit" style="margin:20px 10px" name="submit" value="Submit">
</form>

<?php
if (isset($_POST['submit'])) {

    try {
        $FILES = $_FILES['videos'] ?? null;
        $compress = isset($_POST['compress']) && $_POST['compress'] === 'yes'; // Check if compression is selected

        if (!$FILES) {
            throw new Exception("No files uploaded", 400);
        }

        // Create the target directory for GIFs
        $target_dir = __DIR__ . "/gifs/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Loop through each uploaded file
        foreach ($FILES['tmp_name'] as $index => $tmp_name) {
            $fileName = $FILES['name'][$index];
            $fileError = $FILES['error'][$index];
            $fileTmp = $FILES['tmp_name'][$index];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            if ($fileError != UPLOAD_ERR_OK) {
                echo "Error uploading $fileName<br>";
                continue;
            }

            // Ensure the uploaded file is an MP4
            if ($fileType !== 'mp4') {
                echo "Only MP4 files are allowed for $fileName<br>";
                continue;
            }

            // Define the input and output file paths
            $name = pathinfo($fileName, PATHINFO_FILENAME);
            $outputFile = $target_dir . $name . ".gif";

            // ffmpeg command for MP4 to GIF conversion
            $command = "ffmpeg -i " . escapeshellarg($fileTmp) . " -vf \"fps=10,scale=iw:ih:flags=lanczos\" " . escapeshellarg($outputFile);

            // Execute the ffmpeg command
            exec($command, $output, $return_var);

            if ($return_var === 0) {
                echo "Video $fileName converted successfully to GIF and saved to $outputFile<br>";

                // If compression is selected, compress the GIF
                if ($compress) {
                    $compressedOutputFile = $target_dir . $name . "_compressed.gif";
                    // Command for compressing the GIF
                    $compressCommand = "ffmpeg -i " . escapeshellarg($outputFile) . " -vf \"scale=iw/2:-1\" -y " . escapeshellarg($compressedOutputFile);

                    exec($compressCommand, $compressOutput, $compressReturn);

                    if ($compressReturn === 0) {
                        echo "GIF $fileName compressed successfully and saved to $compressedOutputFile<br>";
                    } else {
                        echo "Failed to compress GIF $fileName<br>";
                    }
                }

            } else {
                echo "Failed to convert $fileName to GIF<br>";
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
