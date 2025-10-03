<?php
// hash_verify.php — exemple minimal

// mot de passe clair (simule l'inscription)
$plainPassword = 'stephane';

// on hache (PASSWORD_DEFAULT choisit l'algo sécurisé actuel)
$hash = password_hash($plainPassword, PASSWORD_DEFAULT);

// affichage du hash (juste pour démonstration)
echo "Hash généré : $hash\n\n";

// --- Vérification (simule la saisie utilisateur)
$entered = 'azerty'; // change pour tester un mot de passe incorrect

if (password_verify($entered, $hash)) {
    echo "Mot de passe correct ✅\n";
} else {
    echo "Mot de passe incorrect ❌\n";
}

echo password_verify($entered,'');