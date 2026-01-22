<div class="container">
    <h1>Bild hochladen</h1>
    <form action="<?php echo Config::get('URL'); ?>gallery/upload_action" method="post" enctype="multipart/form-data">
        <label for="gallery_file">Bild auswählen (jpg, png, gif):</label><br>
        <input type="file" name="gallery_file" id="gallery_file" required accept="image/jpeg,image/png,image/gif"><br><br>
        <button type="submit">Hochladen</button>
    </form>
    <br>
    <a href="<?php echo Config::get('URL'); ?>gallery/index">Zurück zur Galerie</a>
</div>
