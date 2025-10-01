<?php
// index.php
session_start();

// Redirection si non connecté
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
$isAdmin = isset($user['login']) && $user['login'] === 'admin';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Accueil — Bulma Only</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <style>
        /* Parallax simple sans lib externe */
        .parallax {
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            color: #fff;
        }
        .parallax::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(10,10,10,.45);
        }
        .parallax > .container,
        .parallax > .hero-body > .container {
            position: relative;
            z-index: 1;
        }
        .section-divider {
            height: 3px;
            width: 80px;
            background: linear-gradient(90deg, #485fc7, #00d1b2);
            border-radius: 999px;
            margin: 1rem 0 2rem;
        }
        .card-elevate { transition: transform .2s ease, box-shadow .2s ease; border-radius: 14px; }
        .card-elevate:hover { transform: translateY(-4px); box-shadow: 0 18px 30px rgba(0,0,0,.10), 0 10px 12px rgba(0,0,0,.06); }
        .footer { background: #0f1226; color: #cdd1ff; }
        .footer a { color: #a7b0ff; }
    </style>
</head>
<body>

<!-- NAVBAR (Bulma pur) -->
<nav class="navbar is-spaced is-dark" role="navigation" aria-label="navigation principale">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php"><strong>Mon Site Bulma</strong></a>

        <!-- Burger -->
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navMain">
            <span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navMain" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="#about">À propos</a>
            <a class="navbar-item" href="#services">Services</a>
            <a class="navbar-item" href="#contact">Contact</a>
            <?php if ($isAdmin): ?>
                <a class="navbar-item has-text-warning" href="profile.php">Profil admin</a>
            <?php endif; ?>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <span class="tag is-info is-light">Bonjour, <?= htmlspecialchars($user['prenom'] ?? $user['login'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="navbar-item">
                <a class="button is-light" href="logout.php">Se déconnecter</a>
            </div>
        </div>
    </div>
</nav>

<!-- HERO Parallax -->
<section class="hero is-fullheight parallax" style="background-image:url('https://images.unsplash.com/photo-1517249361621-f11084eb8e28?q=80&w=1920&auto=format&fit=crop');">
    <div class="hero-body">
        <div class="container">
            <?php if ($isAdmin): ?>
                <div class="notification is-primary" style="border-radius: 14px;">
                    <strong>Section Administrateur</strong><br>
                    Gérer le site, accéder au profil, consulter les utilisateurs…
                    <div class="mt-3">
                        <a class="button is-link is-light" href="profile.php">Aller au profil</a>
                    </div>
                </div>
            <?php endif; ?>

            <h1 class="title is-1 has-text-white">Hello Bulma Parallax</h1>
            <div class="section-divider"></div>
            <h2 class="subtitle has-text-white-bis">
                Un template élégant 100% Bulma, sans dépendances d’icônes.
            </h2>
            <div class="buttons">
                <a href="#about" class="button is-link is-medium">En savoir plus</a>
                <a href="#services" class="button is-light is-medium is-outlined">Nos services</a>
            </div>
        </div>
    </div>
</section>

<!-- À PROPOS -->
<section id="about" class="section">
    <div class="container">
        <h2 class="title is-2">À propos</h2>
        <div class="section-divider"></div>
        <div class="columns is-vcentered">
            <div class="column is-6">
                <p class="is-size-5">
                    Nous créons des interfaces web rapides, accessibles et soignées.
                    Ce modèle Bulma met l’accent sur la clarté, la lisibilité et un layout moderne.
                </p>
                <div class="columns mt-5">
                    <div class="column">
                        <div class="box card-elevate">
                            <h3 class="title is-5">Rapide</h3>
                            <p>Code épuré, design léger, chargements rapides.</p>
                        </div>
                    </div>
                    <div class="column">
                        <div class="box card-elevate">
                            <h3 class="title is-5">Responsive</h3>
                            <p>Grille Bulma, mobile-first, adaptatif sur tous écrans.</p>
                        </div>
                    </div>
                    <div class="column">
                        <div class="box card-elevate">
                            <h3 class="title is-5">Accessible</h3>
                            <p>Contrastes lisibles, sémantique propre, ARIA de base.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-6">
                <div class="box card-elevate">
                    <h3 class="title is-5">Points forts</h3>
                    <ul class="content">
                        <li>Navbar responsive (burger)</li>
                        <li>Hero pleine hauteur en parallax</li>
                        <li>Sections “À propos”, “Services”, “Contact”</li>
                        <li>Bloc Admin conditionnel</li>
                        <li>Footer stylé</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES (Parallax 2) -->
<section id="services" class="section parallax" style="background-image:url('https://images.unsplash.com/photo-1487017159836-4e23ece2e4cf?q=80&w=1920&auto=format&fit=crop');">
    <div class="container">
        <h2 class="title is-2 has-text-white">Services</h2>
        <div class="section-divider"></div>
        <div class="columns">
            <div class="column">
                <div class="box card-elevate">
                    <h3 class="title is-5">Conseil</h3>
                    <p>Accompagnement sur mesure, audit et recommandations.</p>
                </div>
            </div>
            <div class="column">
                <div class="box card-elevate">
                    <h3 class="title is-5">Développement</h3>
                    <p>Applications web performantes, sécurité, bonnes pratiques.</p>
                </div>
            </div>
            <div class="column">
                <div class="box card-elevate">
                    <h3 class="title is-5">Design</h3>
                    <p>UI/UX soignée, cohérence visuelle et expérience fluide.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section">
    <div class="container">
        <h2 class="title is-2">Contact</h2>
        <div class="section-divider"></div>
        <div class="columns">
            <div class="column is-6">
                <form class="box card-elevate" onsubmit="event.preventDefault(); alert('Formulaire de démo.');">
                    <div class="field">
                        <label class="label">Nom</label>
                        <div class="control">
                            <input class="input" type="text" placeholder="Votre nom">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" placeholder="vous@exemple.com">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Message</label>
                        <div class="control">
                            <textarea class="textarea" placeholder="Votre message"></textarea>
                        </div>
                    </div>
                    <div class="field is-grouped is-right">
                        <div class="control">
                            <button class="button is-link">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="column is-6">
                <div class="box card-elevate">
                    <h3 class="title is-5">Infos</h3>
                    <p>Adresse fictive, 123 Rue de Bulma, 75000 Paris</p>
                    <p>Tél : 01 23 45 67 89</p>
                    <p>Mail : contact@monsitebulma.test</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="content has-text-centered">
        <p>
            <strong>Bulma Only</strong> — gabarit léger et moderne. Code sous licence
            <a href="http://opensource.org/licenses/mit-license.php">MIT</a>.
        </p>
    </div>
</footer>

<!-- JS: burger Bulma -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const burgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
        burgers.forEach(el => {
            el.addEventListener('click', () => {
                const target = el.dataset.target;
                const menu = document.getElementById(target);
                el.classList.toggle('is-active');
                menu.classList.toggle('is-active');
            });
        });
    });
</script>

</body>
</html>
