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
        <a class="navbar-item" href="index.php"><strong>Mon Site stephane</strong></a>

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
<section class="hero is-fullheight parallax" style="background-image:url('https://images.unsplash.com/photo-1599507593499-a3f7d7d97667?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
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

            <h1 class="title is-1 has-text-white">Hello  <?= htmlspecialchars($user['prenom'] ?? $user['login'], ENT_QUOTES, 'UTF-8') ?></h1>
            <div class="section-divider"></div>
            <h2 class="subtitle has-text-white-bis">
               BIENVENUE SUR MON SITE WEB APPRENTISSAGE PHP
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
        <h2 class="title is-2">À propos de mon apprentissage PHP</h2>
        <div class="section-divider"></div>
        <div class="columns is-vcentered">
            <div class="column is-6">
                <p class="is-size-5">
                    J’apprends à développer en PHP pour créer des applications dynamiques et interactives.
                    Ce langage me permet de gérer la logique serveur, les formulaires, et les bases de données.
                </p>
                <div class="columns mt-5">
                    <div class="column">
                        <div class="box card-elevate">
                            <h3 class="title is-5">Syntaxe simple</h3>
                            <p>Un langage facile à lire, proche du C et du JavaScript.</p>
                        </div>
                    </div>
                    <div class="column">
                        <div class="box card-elevate">
                            <h3 class="title is-5">Connexion BDD</h3>
                            <p>Intégration avec MySQL, PDO et gestion des données.</p>
                        </div>
                    </div>
                    <div class="column">
                        <div class="box card-elevate">
                            <h3 class="title is-5">Web dynamique</h3>
                            <p>Permet de générer du HTML dynamique et d’interagir avec l’utilisateur.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-6">
                <div class="box card-elevate">
                    <h3 class="title is-5">Points forts de PHP</h3>
                    <ul class="content">
                        <li>Facile à apprendre et à utiliser</li>
                        <li>Très utilisé dans le web (WordPress, Laravel...)</li>
                        <li>Compatible avec la plupart des serveurs</li>
                        <li>Grande communauté et documentation riche</li>
                        <li>Idéal pour les projets web dynamiques</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- SERVICES (Parallax 2) -->
<section id="services" class="section parallax" style="background-image:url('https://media.istockphoto.com/id/873075750/fr/photo/code-de-programmation-informatique.webp?s=2048x2048&w=is&k=20&c=o9x84B8X1y6wddmgevwy6c08GVPNs9SpIqDq-XfdY7o=');">
    <div class="container">
        <h2 class="title is-2 has-text-white">PHP – Ce que j’apprends</h2>
        <div class="section-divider"></div>
        <div class="columns">
            <div class="column">
                <div class="box card-elevate">
                    <h3 class="title is-5">Bases du langage</h3>
                    <p>Variables, conditions, boucles, fonctions : comprendre la syntaxe PHP.</p>
                </div>
            </div>
            <div class="column">
                <div class="box card-elevate">
                    <h3 class="title is-5">Formulaires & Sessions</h3>
                    <p>Traitement des formulaires HTML, gestion des sessions et cookies.</p>
                </div>
            </div>
            <div class="column">
                <div class="box card-elevate">
                    <h3 class="title is-5">Bases de données</h3>
                    <p>Connexion avec MySQL via PDO, requêtes SQL et sécurité des données.</p>
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
                            <label>
                                <input class="input" type="text" placeholder="Votre nom">
                            </label>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <label>
                                <input class="input" type="email" placeholder="vous@exemple.com">
                            </label>
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
