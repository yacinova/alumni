<?php
// Ajouter le menu dans l'administration WordPress
function ajouter_menu_adhesions() {
    add_menu_page(
        'Gestion des Adhésions', // Titre de la page
        'Adhésions', // Texte du menu
        'manage_options', // Capacité requise
        'gestion-adhesions', // Slug du menu
        'afficher_page_adhesions', // Fonction qui affiche la page
        'dashicons-groups', // Icône
        30 // Position dans le menu
    );
}
add_action('admin_menu', 'ajouter_menu_adhesions');

// Fonction pour créer la table des adhésions lors de l'activation du thème
function creer_table_adhesions() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'adhesions';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nom varchar(100) NOT NULL,
        prenom varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        telephone varchar(20) NOT NULL,
        adresse text NOT NULL,
        profession varchar(100),
        entreprise varchar(100),
        categorie varchar(50) NOT NULL,
        date_inscription datetime DEFAULT CURRENT_TIMESTAMP,
        statut varchar(20) DEFAULT 'en_attente',
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'creer_table_adhesions');

// Fonction pour afficher la page d'administration
function afficher_page_adhesions() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'adhesions';
    
    // Traitement des actions (validation, rejet, suppression)
    if (isset($_POST['action']) && isset($_POST['adhesion_id'])) {
        $adhesion_id = intval($_POST['adhesion_id']);
        
        switch ($_POST['action']) {
            case 'valider':
                $wpdb->update(
                    $table_name,
                    array('statut' => 'valide'),
                    array('id' => $adhesion_id)
                );
                break;
            case 'rejeter':
                $wpdb->update(
                    $table_name,
                    array('statut' => 'rejete'),
                    array('id' => $adhesion_id)
                );
                break;
            case 'supprimer':
                $wpdb->delete($table_name, array('id' => $adhesion_id));
                break;
        }
    }

    // Récupération des adhésions
    $adhesions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_inscription DESC");
    ?>
    <div class="wrap">
        <h1>Gestion des Adhésions</h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <select name="filter_statut">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="valide">Validées</option>
                    <option value="rejete">Rejetées</option>
                </select>
                <input type="submit" class="button" value="Filtrer">
            </div>
        </div>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Catégorie</th>
                    <th>Date d'inscription</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($adhesions as $adhesion): ?>
                    <tr>
                        <td><?php echo esc_html($adhesion->id); ?></td>
                        <td><?php echo esc_html($adhesion->nom); ?></td>
                        <td><?php echo esc_html($adhesion->prenom); ?></td>
                        <td><?php echo esc_html($adhesion->email); ?></td>
                        <td><?php echo esc_html($adhesion->telephone); ?></td>
                        <td><?php echo esc_html($adhesion->categorie); ?></td>
                        <td><?php echo esc_html($adhesion->date_inscription); ?></td>
                        <td>
                            <span class="statut-<?php echo esc_attr($adhesion->statut); ?>">
                                <?php 
                                switch($adhesion->statut) {
                                    case 'en_attente':
                                        echo 'En attente';
                                        break;
                                    case 'valide':
                                        echo 'Validée';
                                        break;
                                    case 'rejete':
                                        echo 'Rejetée';
                                        break;
                                }
                                ?>
                            </span>
                        </td>
                        <td>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="adhesion_id" value="<?php echo esc_attr($adhesion->id); ?>">
                                <?php if ($adhesion->statut == 'en_attente'): ?>
                                    <button type="submit" name="action" value="valider" class="button button-small button-primary">Valider</button>
                                    <button type="submit" name="action" value="rejeter" class="button button-small">Rejeter</button>
                                <?php endif; ?>
                                <button type="submit" name="action" value="supprimer" class="button button-small button-link-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette adhésion ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <style>
        .statut-en_attente {
            color: #f0ad4e;
            font-weight: bold;
        }
        .statut-valide {
            color: #5cb85c;
            font-weight: bold;
        }
        .statut-rejete {
            color: #d9534f;
            font-weight: bold;
        }
        .button-small {
            margin-right: 5px;
        }
    </style>
    <?php
}

// Fonction pour enregistrer une nouvelle adhésion
function enregistrer_adhesion($donnees) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'adhesions';
    
    return $wpdb->insert(
        $table_name,
        array(
            'nom' => $donnees['nom'],
            'prenom' => $donnees['prenom'],
            'email' => $donnees['email'],
            'telephone' => $donnees['telephone'],
            'adresse' => $donnees['adresse'],
            'profession' => $donnees['profession'],
            'entreprise' => $donnees['entreprise'],
            'categorie' => $donnees['categorie'],
            'statut' => 'en_attente'
        )
    );
}
?> 