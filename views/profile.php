<?php
if (!isset($_SESSION['username'])) {
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="cat">

<head>
    <title>Perfil</title>
    
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <a href="/">
                    <img src="images/favicon.png" alt="Logotip de la pàgina">
                </a>
            </div>
            <?php if (isset($_SESSION['username'])): ?>
                <div>
                    <a href="#" id="showAllArticles" >Inici</a>
                </div>
                <div>
                    <a href="#" id="showMyArticles" >My Articles</a>
                </div>
                <div class="add-article">
                    <button onclick="addArticle()">Añadir Artículo</button>
                </div>
                <?php endif; ?>
        </div>

        <div class="content">
            <h1>Perfil de Usuario</h1>
            <?php if (!empty($mostrar)) {echo $mostrar;}?>
            <div class="profile-section">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input id="name" placeholder="" type="text" value="<?php echo $user['username'] ?>" />
                    <small>
                        Este es tu username con el cual inicias sesion.
                    </small>
                </div>
                <div class="profile-picture">
                    <img id="profile-image" alt="Foto de perfil" height="100" src="<?php echo $profileImage; ?>" />
                    <div class="edit-button" onclick="document.getElementById('file-input').click()">
                        <i class="fas fa-pencil-alt"></i>Edit 🖋️
                    </div>
                </div>
                
            </div>
            <form id="upload-form" action="index.php?pagina=SubirImagen" method="post" enctype="multipart/form-data">
                <input type="file" id="file-input" name="profile_image" accept="image/*" onchange="previewImage(event)">
                <button type="submit" style="display: none;"></button> <!-- Botón oculto para activar la carga -->
            </form>
            <div class="form-group">
                <label for="public-email">Your email</label>
                <input id="email" placeholder="" type="email" readonly value="<?php echo $user['email']; ?>" />
                <small>
                    Este es tu email con el que te has registrado.
                </small>
            </div>
            <div class="form-group">
                    <label for="public-email">Your password</label>
                        <!-- Botón para abrir el modal -->
                        
                        <button class="open" id="openModal">Cambiar Contraseña</button>

                        <!-- El modal -->
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <div class="header-modal">
                                    <h2>Cambiar Contraseña</h2>
                                    <span class="close" id="closeModal">&times;</span>
                                </div>
                                <form id="changePasswordForm" action="index.php?pagina=CambiarContra" method="POST">
                                    <div class="password-container">
                                        <label for="old_password">Contraseña Actual:</label>
                                        <input type="password" id="old_password" name="old_password" value="<?php echo isset($contraAntigua)? $contraAntigua:"" ?>" ><br><br>
                                        <input hidden type="checkbox" id="showPassword" onclick="togglePassword('old_password','icono')">
                                        <label for="showPassword" id="icono" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                    </div>
                                    
                                    <div class="password-container">
                                    <label for="new_password">Nueva Contraseña:</label>
                                    <input type="password" id="new_password" name="new_password" value="<?php echo isset($contraNueva)? $contraNueva:""?>"><br><br>
                                        <input hidden type="checkbox" id="showPassword2" onclick="togglePassword('new_password','icono1')">
                                        <label for="showPassword2" id="icono1" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                    </div>

                                    <div class="password-container">
                                    <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                    <input type="password" id="confirm_password" name="confirm_password" value="<?php echo isset($contraNueva2)? $contraNueva2:"" ?>"><br><br>
                                        <input hidden type="checkbox" id="showPassword3" onclick="togglePassword('confirm_password','icono2')">
                                        <label for="showPassword3" id="icono2" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                    </div>

                                    <?php if (!empty($errores)) {echo $errores;}?>
                                    <button class="btn" type="submit">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                        
                    <small>
                        Aqui puedes cambiar tu contraseña
                    </small>
            </div>
            <div class="form-group">
                <label for="bio">
                    Bio
                </label>
                <textarea id="bio" placeholder="Explica un poco sobre ti"></textarea>
                <small>
                    Aqui puedes escribir sobre ti.
                </small>
            </div>
            <button class="button logout"><a href="index.php?pagina=MostrarInici">Cerrrar Sesion</a></button>
            <!-- Input oculto para cargar la imagen -->
            <input  type="file" id="file-input" accept="image/*" onchange="loadImage(event)">
        </div>
    </div>
    <script>
        // Obtener el modal
        var modal = document.getElementById("myModal");

        // Obtener el botón que abre el modal
        var btn = document.getElementById("openModal");

        // Obtener el elemento <span> que cierra el modal
        var span = document.getElementById("closeModal");

        // Cuando el usuario hace clic en el botón, abrir el modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Cuando el usuario hace clic en <span> (x), cerrar el modal
        span.onclick = function() {
            modal.style.display = "none";
        }


        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($errores)): ?>
                // Abre el modal automáticamente si hay errores de validación
                modal.style.display = "block";
            <?php endif; ?>
        });

        function togglePassword(tipo,cos) {
            const passwordField = document.getElementById(tipo);
            const icono = document.getElementById(cos);
            // Cambia el tipo del campo entre "password" y "text"
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icono.innerHTML = '<i class="fi fi-rr-eye-crossed"></i>';
            } else {
                passwordField.type = "password";
                icono.innerHTML = '<i class="fi fi-rr-eye"></i>';
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const profileImage = document.getElementById('profile-image');
            profileImage.src = file;
            document.getElementById('upload-form').submit();
            
        }
    </script>
    <script src="js/main.js"></script>
</body>

</html>