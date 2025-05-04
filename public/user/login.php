<?php
require_once __DIR__ . '/../../config/init.php';

$page_title = "E-Souk Tounsi - Artisanat Tunisien";
$description = "Découvrez l'artisanat tunisien de qualité, des produits faits main par nos artisans locaux.";

// Process login form submission
if (isset($_POST['login_submit'])) {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $remember = isset($_POST['remember']);
  
  // Validate inputs
  if (empty($email) || empty($password)) {
    $error = "Veuillez remplir tous les champs.";
  } else {
    try {
      // Updated table name from "users" to "user"
      $sql = "SELECT id_user, name, email, password, role, address, phone FROM user WHERE email = ?";
      $stmt = $db->prepare($sql);
      $stmt->execute([$email]);
      $user = $stmt->fetch();
      
      // Verify user exists and password is correct
      if ($user && password_verify($password, $user['password'])) {
        // Login successful - store all relevant user data
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_address'] = $user['address'];
        $_SESSION['user_phone'] = $user['phone'];
        $_SESSION['user'] = true;
        // Set remember me cookie if requested
        if ($remember) {
          $token = bin2hex(random_bytes(16));
          $expires = time() + 30 * 24 * 60 * 60; // 30 days
          setcookie('remember_token', $token, $expires, '/');
          
          // You might want to store this token in the database for verification later
        }
        
        // Redirect to dashboard or home page
        header("Location: " . ROOT_URL . "public/user/profile.php");
        exit();
      } else {
        $error = "Email ou mot de passe incorrect.";
      }
    } catch (PDOException $e) {
      // Log the error and show a user-friendly message
      error_log("Database error: " . $e->getMessage());
      $error = "Une erreur s'est produite lors de la connexion. Veuillez réessayer plus tard.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include ROOT_PATH . '/public/templates/header.php'; ?>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
  /* E-Souk Tounsi Login Page Styles */

/* Main color variables */
:root {
  --primary-color: #2b3684;
  --primary-light: rgba(43, 54, 132, 0.05);
  --primary-hover: #232b6a;
  --primary-active: #1c2355;
  --light-gray: #f9f9f9;
  --white: #ffffff;
  --text-dark: #333333;
  --text-light: #666666;
  --border-color: #e0e0e0;
  --shadow-color: rgba(43, 54, 132, 0.1);
}

/* Global styles */
body {
  background-color: #f9f9f9;
  background-image: linear-gradient(
      rgba(43, 54, 132, 0.05) 1px,
      transparent 1px
    ),
    linear-gradient(90deg, rgba(43, 54, 132, 0.05) 1px, transparent 1px);
  background-size: 20px 20px;
  color: var(--text-dark);
  font-family: "Poppins", sans-serif;
}



.card {
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: none !important;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px var(--shadow-color) !important;
}

.card-body {
  padding: 2rem !important;
}

/* Text and heading styles */
h2.text-primary {
  color: var(--primary-color) !important;
  font-weight: 600;
  margin-bottom: 1.5rem !important;
  position: relative;
}

h2.text-primary:after {
  content: "";
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 50px;
  height: 3px;
  background-color: var(--primary-color);
  border-radius: 3px;
}

/* Form elements */
.form-control {
  border: 1px solid var(--border-color);
  border-radius: 5px;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 0.25rem rgba(43, 54, 132, 0.25);
}

.form-label {
  color: var(--text-light);
  font-weight: 500;
  margin-bottom: 0.5rem;
}

/* Buttons */
.btn-primary {
  background-color: var(--primary-color) !important;
  border-color: var(--primary-color) !important;
  border-radius: 5px;
  padding: 0.75rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 6px rgba(43, 54, 132, 0.2);
}

.btn-primary:hover {
  background-color: var(--primary-hover) !important;
  border-color: var(--primary-hover) !important;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(43, 54, 132, 0.3);
}

.btn-primary:active {
  background-color: var(--primary-active) !important;
  border-color: var(--primary-active) !important;
  transform: translateY(0);
}

/* Checkbox style */
.form-check-input {
  width: 1.1em;
  height: 1.1em;
  margin-top: 0.25em;
  border-color: var(--primary-color);
}

.form-check-input:checked {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.form-check-label {
  color: var(--text-light);
}

/* Links */
a {
  color: var(--primary-color);
  text-decoration: none;
  transition: color 0.3s ease;
}

a:hover {
  color: var(--primary-hover);
  text-decoration: underline;
}

/* Alert messages */
.alert-danger {
  background-color: #fff0f0;
  color: #d32f2f;
  border-color: #ffcdd2;
  border-left: 4px solid #d32f2f;
  padding: 1rem;
  border-radius: 5px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .card-body {
    padding: 1.5rem !important;
  }

  
}

/* Add a subtle animation to the form */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

form {
  animation: fadeIn 0.5s ease-out forwards;
}

  </style>
</head>
<body class="login-page">
    
    <!-- Navbar -->
    <?php include ROOT_PATH . '/public/templates/navbar.php'; ?>

    <!-- Login Section -->
    <section class="container my-5 py-5">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
              <h2 class="mb-4 text-center text-primary">Connexion</h2>
              
              <?php
              // Display error message if any
              if (isset($error)) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
              }
              ?>

              <form action="<?php echo htmlspecialchars(ROOT_URL . 'public/user/login.php'); ?>" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Adresse Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="nom@exemple.com"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Mot de passe</label>
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="********"
                    required
                  />
                </div>
                <div class="mb-3 form-check">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="remember"
                    name="remember"
                  />
                  <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="login_submit">
                  Se connecter
                </button>
              </form>

              <div class="text-center mt-3">
                <a href="<?php echo ROOT_URL; ?>public/user/reset_password.php">Mot de passe oublié ?</a>
              </div>
              <div class="text-center mt-2">
                <span>Vous n'avez pas de compte ?
                <a href="<?php echo ROOT_URL; ?>public/user/register.php">Créer un compte</a> </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php include '../templates/footer.php'; ?>
  </body>
</html>
