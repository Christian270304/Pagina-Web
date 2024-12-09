<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <button onclick="loadPage(<?php echo $i; ?>, <?php echo $articlesPerPage; ?>,<?php echo isset($_GET['all']) ? (bool)$_GET['all'] : false; ?>)"><?php echo $i; ?></button>
    <?php endfor; ?>
</div>