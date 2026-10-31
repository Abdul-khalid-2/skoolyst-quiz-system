<?php
/**
 * Topic description as a simple left/right slider (about 8-9 lines per slide).
 * Expects $html: description HTML that has ALREADY been through rich_text_html() / sanitize_rich_text().
 * Without JavaScript the full text is simply shown as normal paragraphs.
 */
?>
<div class="sk-desc" data-desc-slider>
    <div class="sk-desc-viewport" tabindex="0" role="region" aria-label="Topic description">
        <div class="sk-desc-content"><?= $html ?></div>
    </div>
    <div class="sk-desc-controls" hidden>
        <button type="button" class="sk-desc-btn" data-desc-prev aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
        <span class="sk-desc-count" aria-live="polite"></span>
        <button type="button" class="sk-desc-btn" data-desc-next aria-label="Next"><i class="bi bi-chevron-right"></i></button>
    </div>
</div>
