<div class="content">
    <?php foreach ($articles as $article): ?>
        <div class="<?php echo (isset($_SESSION['username'])) ? 'user-article' : 'card'; ?>">
            <img src="<?php echo $article['ruta_imagen']; ?>" alt="Imagen del artículo">
            <h4><?php echo $article['titol']; ?></h4>
            <p><?php echo $article['cos']; ?></p>
            <?php if (isset($_SESSION['username'])): ?>
                <div class="card-actions">
                    <button onclick="readArticle(<?php echo $article['id']; ?>)">Leer</button>
                    <button onclick="editArticle(<?php echo $article['id']; ?>)">Editar</button>
                    <button onclick="deleteArticle(<?php echo $article['id']; ?>)">Eliminar</button>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>