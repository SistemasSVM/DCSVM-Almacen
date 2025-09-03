<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DCSVM - Iniciar Sesión</title>
  <style>
    /* --- General Styles --- */
    body, html {
      height: 100%;
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background-color: #f4f6f9;
    }

    /* --- Main Container --- */
    .login-container {
      display: flex;
      height: 100vh;
      width: 100%;
    }

    /* --- Image Panel (Left Side) --- */
    .image-panel {
      flex: 1 1 55%;
      background-image: url('./vistas/img/plantilla/SVM-BG.png'); /* <-- Asegúrate que la ruta a tu imagen sea correcta */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    /* --- Form Panel (Right Side) --- */
    .form-panel {
      flex: 1 1 45%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
      background-color: #ffffff;
    }

    .login-box-wrapper {
      width: 100%;
      max-width: 700px;
    }

    /* --- Logo and Titles --- */
    .login-logo h1 {
      font-size: 4.5rem;
      font-weight: 700;
      color: #005940; /* Verde oscuro del logo */
      margin: 0 0 10px 0;
      text-align: left;
    }

    .login-box-msg {
      font-size: 3rem;
      margin-bottom: 2rem;
      text-align: left;
      font-weight: 500;
      color: #333;
    }

    /* --- Form Elements --- */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: #555;
    }

    .form-control {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ced4da;
      border-radius: 8px;
      background-color: #f1f3f5;
      font-size: 2rem;
      box-sizing: border-box; /* Important for padding and width */
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    /* --- Button --- */
    .btn-primary {
      width: 100%;
      padding: 12px;
      font-size: 2rem;
      font-weight: 600;
      color: #fff;
      background-color: #007bff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* --- Footer Text --- */
    .footer-links {
      margin-top: 2rem;
      text-align: center;
      font-size: 2rem;
      color: #6c757d;
    }

    .footer-links a {
      color: #007bff;
      text-decoration: none;
    }

    .footer-links a:hover {
      text-decoration: underline;
    }

    .footer-copyright {
      margin-top: 1.5rem;
      text-align: center;
      font-size: 2rem;
      color: #6c757d;
    }
    .login_img{
        width: 70%;
    }
    .font-size-text{
        font-size: 20px;
    }
    
    /* --- Responsive Design --- */
    @media (max-width: 768px) {
      .image-panel {
        display: none; /* Oculta la imagen en pantallas pequeñas */
      }
      .form-panel {
        flex: 1 1 100%;
      }
    }

  </style>
</head>
<body>

  <div class="login-container">
    
    <!-- Panel de la Imagen (Izquierda) -->
    <div class="image-panel"></div>

    <!-- Panel del Formulario (Derecha) -->
    <div class="form-panel">
      
      <div class="login-box-wrapper">
        
        <img src="./vistas/img/plantilla/DCSVM.png" alt="Logo DCSVM" class="login_img">

        <p class="login-box-msg">Inicia sesión</p>

        <form method="post">

          <div class="form-group">
            <label for="ingUsuario" class="font-size-text">Usuario</label>
            <input type="text" id="ingUsuario" class="form-control" placeholder="Ingresa tu usuario" name="ingUsuario" required>
          </div>

          <div class="form-group">
            <label for="ingPassword" class="font-size-text">Contraseña</label>
            <input type="password" id="ingPassword" class="form-control" placeholder="Ingresa tu contraseña" name="ingPassword" required>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block" class="font-size-text">Ingresar</button>
            </div>
          </div>

          <?php
            // Lógica de PHP para el controlador de usuarios se mantiene intacta
            $login = new ControladorUsuarios();
            $login -> ctrIngresoUsuario();
          ?>

        </form>

        <div class="footer-links">
          ¿Necesitas una cuenta? <a href="#">Solicítala aquí.</a>
        </div>

        <div class="footer-copyright">
          © 2025 Grupo SVM - Todos los derechos reservados.
        </div>

      </div>
      
    </div>

  </div>

</body>
</html>
