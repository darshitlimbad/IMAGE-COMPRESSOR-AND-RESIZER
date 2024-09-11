<form action="#" method="post" enctype="multipart/form-data">
    <label for="video">Upload MP4 Video</label>
    <input type="file" name="video" id="video" accept="video/mp4">
    <input type="submit" name="submit" value="Submit">
</form>

<?php
if (isset($_POST['submit'])) {

    try {
        $FILE = $_FILES['video'] ?? null;

        if (!$FILE || $FILE['error'] != UPLOAD_ERR_OK) {
            throw new Exception("File upload error", 400);
        }

        // Ensure the uploaded file is an MP4
        $ext = pathinfo($FILE['name'], PATHINFO_EXTENSION);
        if ($ext !== 'mp4') {
            throw new Exception("Only MP4 videos are allowed", 415);
        }

        // Set the target directory for the GIF file
        $target_dir = __DIR__ . "/gifs/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Define the input and output file paths
        $name = pathinfo($FILE['name'], PATHINFO_FILENAME);
        $inputFile = $FILE['tmp_name'];
        $outputFile = $target_dir . $name . ".gif";

        // Use ffmpeg to convert the MP4 to GIF
        $command = "ffmpeg -i " . escapeshellarg($inputFile) . " -vf \"fps=10,scale=iw:ih:flags=lanczos\" " . escapeshellarg($outputFile);

        // Execute the ffmpeg command
        exec($command, $output, $return_var);

        if ($return_var === 0) {
            echo "Video converted successfully to GIF and saved to $outputFile";
        } else {
            throw new Exception("Failed to convert video to GIF", 500);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
