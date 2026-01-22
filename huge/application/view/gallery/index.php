<div class="container">
    <h1>Meine Galerie</h1>
    <a href="<?php echo Config::get('URL'); ?>gallery/upload" class="btn">Bild hochladen</a>
    <div class="gallery-list">
        <?php if (empty($images)): ?>
            <p>Keine Bilder vorhanden.</p>
        <?php else: ?>
            <?php foreach ($images as $img): ?>
                <div class="gallery-thumb" style="display:inline-block;margin:8px;">
                    <img src="<?php echo Config::get('URL').'gallery/serve/'.urlencode($img); ?>" style="max-width:120px;max-height:120px;border:1px solid #ccc;" alt="Bild">
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
