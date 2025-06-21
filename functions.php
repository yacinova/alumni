<?php

/**
 * Alumni ESG - Theme Functions
 * 
 * Ce fichier contient toutes les fonctionnalités personnalisées pour le site Alumni ESG
 * avec une structure unifiée où les taxonomies et les champs ACF partagent les mêmes noms.
 * 
 * @package AlumniESG
 * @version 1.0
 */

// Sécurité - Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) exit;

/**
 * SECTION 1: CHARGEMENT DES STYLES
 */
add_action('wp_enqueue_scripts', function () {
    // Enqueue parent theme style first
    wp_enqueue_style(
        'hello-elementor-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme('hello-elementor')->get('Version')
    );

    // Enqueue child theme style
    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_uri(),
        ['hello-elementor-style'], // Depend on parent style
        wp_get_theme()->get('Version')
    );

    // Conditionally enqueue header/footer styles
    if (is_user_logged_in() && current_user_can('etudiant')) {
        // Logged-in student styles
        wp_enqueue_style(
            'alumni-header-etudiant',
            get_stylesheet_directory_uri() . '/css/header-etudiant.css',
            ['hello-elementor-child-style'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'alumni-footer-etudiant',
            get_stylesheet_directory_uri() . '/css/footer-etudiant.css',
            ['hello-elementor-child-style'],
            wp_get_theme()->get('Version')
        );
    } else {
        // Public/logged-out styles
        wp_enqueue_style(
            'alumni-header-public',
            get_stylesheet_directory_uri() . '/css/header-public.css',
            ['hello-elementor-child-style'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'alumni-footer-public',
            get_stylesheet_directory_uri() . '/css/footer-public.css',
            ['hello-elementor-child-style'],
            wp_get_theme()->get('Version')
        );
    }
}, 20); // Priority 20 to ensure it runs after parent theme styles

/**
 * SECTION 2: CONFIGURATION DES TYPES DE CONTENU ET TAXONOMIES
 */

// Configuration des types de contenu personnalisés
$custom_post_types = [
    'membres' => [
        'title_from' => ['prenom', 'nom'],
        'columns' => [
            'prenom' => 'Prénom',
            'nom' => 'Nom',
            'email' => 'Email',
            'categories_membre' => 'Catégories',
            'localisations' => 'Localisations',
            'created_at' => 'Créé le',
            'updated_at' => 'Modifié le'
        ],
        'taxonomies' => ['categories_membre', 'localisations'],
        'labels' => [
            'name' => 'Membres',
            'singular_name' => 'Membre',
            'menu_name' => 'Membres'
        ]
    ],
    'entreprises' => [
        'title_from' => ['nom_entreprise'],
        'columns' => [
            'nom_entreprise' => 'Entreprise',
            'secteurs_activite' => 'Secteurs d\'activité',
            'created_at' => 'Créé le',
            'updated_at' => 'Modifié le'
        ],
        'taxonomies' => ['secteurs_activite', 'localisations'],
        'labels' => [
            'name' => 'Entreprises',
            'singular_name' => 'Entreprise',
            'menu_name' => 'Entreprises'
        ]
    ],
    'offres_emploi' => [
        'title_from' => ['intitule_poste'],
        'columns' => [
            'intitule_poste' => 'Poste',
            'entreprise_associee' => 'Entreprise',
            'created_at' => 'Créé le',
            'updated_at' => 'Modifié le'
        ],
        'labels' => [
            'name' => 'Offres d\'emploi',
            'singular_name' => 'Offre d\'emploi',
            'menu_name' => 'Offres d\'emploi'
        ]
    ],
    'evenements' => [
        'title_from' => ['titre_evenement'],
        'columns' => [
            'titre_evenement' => 'Nom de l\'événement',
            'date_evenement' => 'Date',
            'types_evenement' => 'Type',
            'localisations' => 'Localisation',
            'created_at' => 'Créé le',
            'updated_at' => 'Modifié le'
        ],
        'taxonomies' => ['types_evenement', 'localisations'],
        'date_field' => 'date_evenement',
        'labels' => [
            'name' => 'Événements',
            'singular_name' => 'Événement',
            'menu_name' => 'Événements'
        ],
        'submenu' => [
            'inscrits' => 'Inscrits'
        ]
    ],
    'documents' => [
        'title_from' => ['titre_document'],
        'columns' => [
            'titre_document' => 'Titre',
            'types_documents' => 'Catégorie',
            'created_at' => 'Créé le',
            'updated_at' => 'Modifié le'
        ],
        'taxonomies' => ['types_documents'],
        'labels' => [
            'name' => 'Documents',
            'singular_name' => 'Document',
            'menu_name' => 'Documents'
        ]
    ],
];

// Enregistrement des types de contenu personnalisés
add_action('init', function () use ($custom_post_types) {
    // Enregistrer les CPTs
    foreach ($custom_post_types as $slug => $settings) {
        register_post_type($slug, [
            'label' => $settings['labels']['name'],
            'labels' => array_merge($settings['labels'], [
                'archives' => 'Archives ' . $settings['labels']['name'],
                'not_found_in_trash' => 'Aucun ' . strtolower($settings['labels']['singular_name']) . ' trouvé dans la corbeille',
            ]),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_rest' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => true, // Modifié: Permet l'accès aux pages individuelles
            'has_archive' => true,
            'rewrite' => ['slug' => $slug], // Modifié: Définit la structure d'URL
            'supports' => ['title'],
            'menu_icon' => 'dashicons-admin-post',
            'taxonomies' => $settings['taxonomies'] ?? [],
            'capabilities' => [
                'create_posts' => 'edit_posts',
                'edit_post' => 'edit_posts',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'delete_posts' => 'delete_posts',
                'publish_posts' => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
            ]
        ]);
    }

    // Enregistrer les taxonomies
    register_taxonomy('categories_membre', ['membres'], [
        'label' => 'Catégories de membres',
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true
    ]);

    register_taxonomy('secteurs_activite', ['entreprises', 'offres_emploi'], [
        'label' => 'Secteurs d\'activité',
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true
    ]);

    register_taxonomy('types_evenement', ['evenements'], [
        'label' => 'Types d\'événements',
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true
    ]);

    register_taxonomy('localisations', ['evenements', 'membres', 'entreprises'], [
        'label' => 'Localisations',
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true
    ]);

    register_taxonomy('types_documents', ['documents'], [
        'label' => 'Types de documents',
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true
    ]);

    register_post_type('candidatures', [
        'label' => 'Candidatures',
        'labels' => [
            'name' => 'Candidatures',
            'singular_name' => 'Candidature',
            'menu_name' => 'Candidatures',
            'archives' => 'Archives Candidatures',
            'not_found_in_trash' => 'Aucune candidature trouvée dans la corbeille',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=offres_emploi', // This makes it appear as a submenu
        'exclude_from_search' => true,
        'publicly_queryable' => false, // Disable single pages
        'has_archive' => false,
        'supports' => ['title'],
        'capabilities' => [
            'create_posts' => 'edit_posts',
            'edit_post' => 'edit_posts',
            'edit_posts' => 'edit_posts',
            'edit_others_posts' => 'edit_others_posts',
            'delete_posts' => 'delete_posts',
            'publish_posts' => 'publish_posts',
            'read_private_posts' => 'read_private_posts',
        ]
    ]);
}, 10);

function display_timestamp_column($column, $post_id)
{
    switch ($column) {
        case 'created_at':
            $date = get_post_time('Y-m-d H:i:s', true, $post_id);
            break;
        case 'updated_at':
            $date = get_post_modified_time('Y-m-d H:i:s', true, $post_id);
            break;
        default:
            $date = false;
    }

    if ($date) {
        $timestamp = strtotime($date);
        $date_format = get_option('date_format') . ' ' . get_option('time_format');
        echo date_i18n($date_format, $timestamp);
    } else {
        echo '<span style="opacity:0.6">—</span>';
    }
}

/**
 * SECTION 3: PERSONNALISATION DE L'INTERFACE D'ADMINISTRATION
 */

// Configuration des colonnes d'administration
add_action('admin_init', function () use ($custom_post_types) {
    foreach ($custom_post_types as $cpt => $conf) {
        // Définir les colonnes
        add_filter("manage_edit-{$cpt}_columns", function ($columns) use ($conf) {
            $new = ['cb' => $columns['cb'] ?? ''];

            foreach ($conf['columns'] as $field => $label) {
                $new[$field] = $label;
            }

            if (isset($conf['date_field']) && !isset($new[$conf['date_field']])) {
                $new['date_field'] = 'Date';
            }

            return $new;
        });

        // Remplir les colonnes
        add_action("manage_{$cpt}_posts_custom_column", function ($column, $post_id) use ($conf, $cpt) {
            // Colonnes de timestamp
            if (in_array($column, ['created_at', 'updated_at'])) {
                display_timestamp_column($column, $post_id);
                return;
            }
            // Colonnes de taxonomie
            if (in_array($column, $conf['taxonomies'] ?? [])) {
                display_taxonomy_column($column, $post_id);
            }
            // Colonnes de champs standard
            elseif (isset($conf['columns'][$column]) && $column !== 'date_field') {
                display_standard_field_column($column, $post_id);
            }
            // Colonne de date
            elseif ($column === 'date_field' && isset($conf['date_field'])) {
                display_date_column($conf['date_field'], $post_id);
            }
        }, 10, 2);
    }
});

// Ajouter la colonne d'actions et de statut
add_filter('manage_posts_columns', function ($columns) use ($custom_post_types) {
    global $typenow;

    if (!isset($custom_post_types[$typenow])) return $columns;

    $columns['status'] = 'Statut';
    $columns['actions'] = 'Actions';
    return $columns;
}, 20);

// Remplir les colonnes d'actions et de statut
add_action('manage_posts_custom_column', function ($column_name, $post_id) use ($custom_post_types) {
    if (!isset($custom_post_types[get_post_type($post_id)])) return;

    if ($column_name === 'status') {
        $is_archived = get_post_meta($post_id, 'archive_status', true) === 'archived';
        echo '<span class="archive-status ' . ($is_archived ? 'archived' : 'current') . '">';
        echo $is_archived ? 'Archivé' : 'En cours';
        echo '</span>';
    }

    if ($column_name === 'actions') {
        $is_archived = get_post_meta($post_id, 'archive_status', true) === 'archived';
        $actions = [];

        if ($is_archived) {
            $actions[] = sprintf(
                '<span class="unarchive"><a href="#" data-id="%s" data-action="current" class="toggle-archive">Désarchiver</a></span>',
                $post_id
            );
        } else {
            $actions[] = sprintf(
                '<span class="archive"><a href="#" data-id="%s" data-action="archived" class="toggle-archive">Archiver</a></span>',
                $post_id
            );
        }

        $actions[] = sprintf(
            '<span class="trash"><a href="%s">Mettre à la corbeille</a></span>',
            get_delete_post_link($post_id)
        );

        echo '<div class="row-actions">' . implode(' | ', $actions) . '</div>';
    }
}, 10, 2);

// Nombre d'éléments par page par défaut
add_filter('edit_posts_per_page', function ($per_page, $post_type) use ($custom_post_types) {
    if (array_key_exists($post_type, $custom_post_types)) {
        return 20; // Afficher 20 éléments par page par défaut
    }
    return $per_page;
}, 10, 2);

/**
 * SECTION 4: FONCTIONS D'AFFICHAGE DES COLONNES
 */

// Affichage des taxonomies (simplifiée)
function display_taxonomy_column($taxonomy, $post_id)
{
    global $wpdb;

    // 1. Tenter de récupérer directement depuis ACF
    $acf_value = get_field($taxonomy, $post_id);

    // 2. Si pas de résultat via ACF, chercher dans wp_postmeta directement
    if (empty($acf_value)) {
        $acf_meta = $wpdb->get_var($wpdb->prepare(
            "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s LIMIT 1",
            $post_id,
            $taxonomy
        ));

        if (!empty($acf_meta)) {
            if (is_serialized($acf_meta)) {
                $term_ids = maybe_unserialize($acf_meta);
            } else if (is_numeric($acf_meta)) {
                $term_ids = [$acf_meta];
            }
        }
    } else {
        // L'API ACF a retourné une valeur
        $term_ids = is_array($acf_value) ? $acf_value : [$acf_value];
    }

    // 3. Si toujours pas de résultat, utiliser l'API WordPress standard
    if (empty($term_ids)) {
        $wp_terms = wp_get_post_terms($post_id, $taxonomy, ['hide_empty' => false]);
        if (!empty($wp_terms) && !is_wp_error($wp_terms)) {
            $term_ids = wp_list_pluck($wp_terms, 'term_id');
        }
    }

    // 4. Si toujours vide, afficher un tiret
    if (empty($term_ids)) {
        echo '<span style="opacity:0.6">—</span>';
        return;
    }

    // 5. Afficher les noms des termes
    $term_names = [];
    if (is_array($term_ids)) {
        foreach ($term_ids as $term_id) {
            if (is_numeric($term_id)) {
                $term = get_term($term_id);
                if ($term && !is_wp_error($term)) {
                    $term_names[] = $term->name;
                }
            } elseif (is_string($term_id)) {
                $term_names[] = $term_id;
            }
        }
    }

    echo !empty($term_names) ? implode(', ', $term_names) : '<span style="opacity:0.6">—</span>';
}

// Affichage des champs standards
function display_standard_field_column($column, $post_id)
{
    $value = get_field($column, $post_id);

    // Si c'est une relation de post
    if (is_numeric($value) && get_post_type($value)) {
        $related_post = get_post($value);
        if ($related_post) {
            echo '<a href="' . get_edit_post_link($value) . '">' .
                esc_html($related_post->post_title) . '</a>';
            return;
        }
    }

    // Si c'est un tableau de relations
    if (is_array($value) && !empty($value)) {
        $post_titles = array_map(function ($post_id) {
            $post = get_post($post_id);
            return $post ? '<a href="' . get_edit_post_link($post->ID) . '">' .
                esc_html($post->post_title) . '</a>' : '';
        }, $value);

        $post_titles = array_filter($post_titles);
        if (!empty($post_titles)) {
            echo implode(', ', $post_titles);
            return;
        }
    }

    // Pour les autres types de valeurs (non-relations)
    if ($value === null || $value === false) {
        global $wpdb;
        $value = $wpdb->get_var($wpdb->prepare(
            "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s LIMIT 1",
            $post_id,
            $column
        ));
    }

    echo empty($value)
        ? '<span style="opacity:0.6">—</span>'
        : '<a href="' . get_edit_post_link($post_id) . '">' . esc_html($value) . '</a>';
}

// Affichage des dates
function display_date_column($date_field, $post_id)
{
    $date = get_field($date_field, $post_id);

    if (empty($date)) {
        global $wpdb;
        $date = $wpdb->get_var($wpdb->prepare(
            "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s LIMIT 1",
            $post_id,
            $date_field
        ));
    }

    echo !empty($date) ? date_i18n(get_option('date_format'), strtotime($date)) : '—';
}

/**
 * SECTION 5: INTERFACE UTILISATEUR SIMPLIFIÉE
 */

// CSS pour simplifier l'interface
add_action('admin_head', function () use ($custom_post_types) {
    $screen = get_current_screen();
    if (isset($screen->post_type) && array_key_exists($screen->post_type, $custom_post_types)) {
        echo '<style>
            /* CSS Variables */
            :root {
                /* Colors */
                --alumni-text-primary: #1d2327;
                --alumni-text-secondary: #50575e;
                --alumni-border: #c3c4c7;
                --alumni-border-hover: #8c8f94;
                --alumni-bg-primary: #ffffff;
                --alumni-bg-secondary: #f6f7f7;
                --alumni-bg-hover: #f0f0f1;
                --alumni-box-shadow: rgba(0, 0, 0, 0.04);
                
                /* Spacing */
                --alumni-spacing-xs: 4px;
                --alumni-spacing-sm: 8px;
                --alumni-spacing-md: 15px;
                --alumni-spacing-lg: 20px;
                
                /* Typography */
                --alumni-font-size-sm: 13px;
                --alumni-font-size-base: 14px;
                --alumni-font-size-lg: 23px;
                --alumni-line-height: 1.4;
                
                /* Layout */
                --alumni-border-radius: 3px;
                --alumni-input-height: 30px;
            }

            /* Page Title */
            .wp-heading-inline,
            .wrap > h1 {
                display: block !important;
                margin: 0 0 var(--alumni-spacing-lg) !important;
                padding: var(--alumni-spacing-xs) 0 !important;
                font-size: var(--alumni-font-size-lg) !important;
                font-weight: 400 !important;
                line-height: var(--alumni-line-height) !important;
                color: var(--alumni-text-primary) !important;
            }

            /* Hide unnecessary elements */
            #titlediv,
            #postdivrich, 
            #normal-sortables > div:not(.acf-postbox),
            #advanced-sortables > div:not(.acf-postbox),
            #side-sortables > div:not(#submitdiv):not(.acf-postbox),
            #screen-options-link-wrap,
            #contextual-help-link-wrap,
            .page-title-action,
            .subsubsub,
            /* Hide bulk actions but NOT filter button */
            .alignleft.actions.bulkactions,
            #doaction,
            #doaction2,
            /* Hide preview button */
            #post-preview,
            .preview.button {
                display: none !important;
            }

            /* Show filter button */
            #post-query-submit {
                display: inline-block !important;
                margin-left: 4px !important;
                height: 32px;
                line-height: 30px;
                padding: 0 12px;
                background: var(--alumni-bg-primary);
                border: 1px solid var(--alumni-border);
                border-radius: var(--alumni-border-radius);
                cursor: pointer;
            }

            #post-query-submit:hover {
                background: var(--alumni-bg-hover);
                border-color: var(--alumni-border-hover);
            }

            /* Filters & Search Layout */
            .search-box {
                float: right !important;
                margin: 0 0 10px !important;
            }

            .search-box input[type="search"] {
                height: 32px;
                margin: 0;
                padding: 0 8px;
                font-size: 14px;
            }

            .search-box input[type="submit"] {
                height: 32px;
                margin-left: 4px;
            }

            .tablenav-pages {
                float: right !important;
                margin: 0 10px !important;
            }

            /* Main filters bar */
            .tablenav {
                clear: both;
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                padding: 8px;
                margin: 8px 0 16px;
                background: var(--alumni-bg-primary);
                border: 1px solid var(--alumni-border);
                border-radius: var(--alumni-border-radius);
            }

            .tablenav select {
                height: 32px;
                margin: 0 4px;
                padding: 0 24px 0 8px;
                font-size: 14px;
                border: 1px solid var(--alumni-border);
                border-radius: var(--alumni-border-radius);
                background-color: #fff;
                background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%206l5%205%205-5%202%201-7%207-7-7%202-1z%22%20fill%3D%22%23555%22%2F%3E%3C%2Fsvg%3E");
                background-position: right 5px center;
                background-repeat: no-repeat;
                background-size: 16px;
                cursor: pointer;
            }

            /* Specific pagination styles */
            .tablenav-pages {
                display: flex !important;
                align-items: center;
                margin-left: auto !important;
            }

            .tablenav-pages .displaying-num {
                margin-right: 8px;
                color: var(--alumni-text-secondary);
            }

            .tablenav-pages .pagination-links {
                display: inline-flex;
                align-items: center;
                gap: 4px;
            }

            .tablenav-pages .pagination-links a,
            .tablenav-pages .pagination-links .current {
                min-width: 28px;
                height: 28px;
                padding: 0 4px;
                margin: 0;
                text-align: center;
                line-height: 26px;
                color: var(--alumni-text-primary);
                border: 1px solid var(--alumni-border);
                border-radius: var(--alumni-border-radius);
                background: var(--alumni-bg-primary);
            }

            .tablenav-pages .pagination-links .current {
                font-weight: 600;
                background: var(--alumni-bg-secondary);
            }

            /* Responsive adjustments */
            @media screen and (max-width: 782px) {
                .tablenav {
                    flex-direction: column;
                    gap: 8px;
                }

                .tablenav select {
                    width: 100%;
                    max-width: none;
                }

                .search-box {
                    width: 100%;
                    float: none !important;
                    text-align: center;
                }

                .tablenav-pages {
                    width: 100%;
                    justify-content: center;
                    margin: 8px 0 !important;
                }
            }

            /* Archive Status */
            .archive-status {
                padding: 3px 7px;
                border-radius: 3px;
                font-size: 12px;
                font-weight: 500;
            }
            .archive-status.archived {
                background: #f1f1f1;
                color: #666;
            }
            .archive-status.current {
                background: #e7f5e9;
                color: #1e8a37;
            }

            /* Actions Column */
            .column-actions {
                width: 120px;
            }
            .row-actions {
                display: flex;
                gap: 8px;
                color: #666;
            }
            .row-actions span {
                padding: 0;
            }
            .row-actions .archive {
                color: #666;
            }
            .row-actions .unarchive {
                color: #2271b1;
            }
            .row-actions .trash {
                color: #b32d2e;
            }

            /* Archive Info in Publish Box */
            #misc-publishing-actions .archive-info {
                padding-top: 10px;
            }
            .archive-toggle {
                margin-top: 8px;
                display: none;
            }
            .archive-toggle label {
                margin-left: 4px;
            }
            .archive-toggle-buttons {
                margin-top: 8px;
            }
            .archive-status-display {
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            /* Form Controls */
            input[type="search"],
            select {
                min-height: var(--alumni-input-height);
                padding: 0 var(--alumni-spacing-sm);
                border: 1px solid var(--alumni-border);
                border-radius: var(--alumni-border-radius);
                background-color: var(--alumni-bg-primary);
                color: var(--alumni-text-primary);
                font-size: var(--alumni-font-size-sm);
            }

            /* Table Filters */
            .tablenav select {
                max-width: 200px;
                margin-right: var(--alumni-spacing-xs);
                padding-right: 24px;
                background: var(--alumni-bg-primary) url(data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%206l5%205%205-5%202%201-7%207-7-7%202-1z%22%20fill%3D%22%23555%22%2F%3E%3C%2Fsvg%3E) no-repeat right 5px top 55%;
                background-size: 16px 16px;
                cursor: pointer;
            }

            /* Search Box */
            .search-box {
                float: right;
                margin: 0 var(--alumni-spacing-sm) var(--alumni-spacing-sm);
                display: block !important;
            }

            /* ACF Fields */
            .acf-postbox, 
            .acf-field[data-type="taxonomy"],
            .acf-taxonomy-field,
            .acf-field-select,
            .select2-container {
                display: block !important;
            }

            /* Select2 Fixes */
            .select2-container--open,
            .select2-dropdown {
                z-index: 999999 !important;
            }

            .select2-results {
                max-height: 300px !important;
            }

            /* Responsive Styles */
            @media screen and (max-width: 782px) {
                :root {
                    --alumni-input-height: 40px;
                }

                .tablenav select {
                    display: block;
                    width: 100%;
                    max-width: none;
                    margin-bottom: var(--alumni-spacing-sm);
                }

                .tablenav-pages {
                    width: 100%;
                    text-align: center;
                    margin: var(--alumni-spacing-sm) 0;
                }

                input[type="search"] {
                    width: 100%;
                    max-width: none;
                }

                .tablenav .actions {
                    width: 100%;
                    padding: var(--alumni-spacing-sm) 0;
                }
            }
        </style>';
    }
});

// Désactiver la saisie du titre
add_filter('enter_title_here', function ($title, $post) use ($custom_post_types) {
    if (isset($post->post_type) && array_key_exists($post->post_type, $custom_post_types)) {
        return 'Titre généré automatiquement';
    }
    return $title;
}, 10, 2);

/**
 * SECTION 6: GÉNÉRATION AUTOMATIQUE DES TITRES
 */

// Génération du titre lors de l'enregistrement
add_filter('wp_insert_post_data', function ($data, $postarr) use ($custom_post_types) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $data;

    $post_type = $data['post_type'];
    $post_id = $postarr['ID'] ?? null;
    if (!$post_id || !isset($custom_post_types[$post_type])) return $data;

    $fields = $custom_post_types[$post_type]['title_from'];
    $values = [];

    foreach ($fields as $field) {
        $value = get_field($field, $post_id);

        if ($value === null || $value === false) {
            global $wpdb;
            $value = $wpdb->get_var($wpdb->prepare(
                "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s LIMIT 1",
                $post_id,
                $field
            ));
        }

        if (!empty($value)) {
            $values[] = $value;
        }
    }

    $title = implode(' ', $values);

    if (!empty(trim($title))) {
        $data['post_title'] = trim($title);
    }

    return $data;
}, 10, 2);

// Mise à jour du titre après sauvegarde ACF
add_action('acf/save_post', function ($post_id) use ($custom_post_types) {
    if (!wp_is_post_revision($post_id)) {
        $post_type = get_post_type($post_id);
        if (!isset($custom_post_types[$post_type])) return;

        // Programmation différée pour s'assurer que les champs sont enregistrés
        wp_schedule_single_event(time() + 1, 'alumni_update_post_title', array($post_id));
    }
}, 20);

// Action pour mise à jour du titre
add_action('alumni_update_post_title', function ($post_id) use ($custom_post_types) {
    $post_type = get_post_type($post_id);
    if (!isset($custom_post_types[$post_type])) return;

    $post = get_post($post_id);
    $fields = $custom_post_types[$post_type]['title_from'];
    $values = [];

    foreach ($fields as $field) {
        $value = get_field($field, $post_id);

        if ($value === null || $value === false) {
            global $wpdb;
            $value = $wpdb->get_var($wpdb->prepare(
                "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s LIMIT 1",
                $post_id,
                $field
            ));
        }

        if (!empty($value)) {
            $values[] = $value;
        }
    }

    $title = implode(' ', $values);

    if (!empty(trim($title)) && $title != $post->post_title) {
        wp_update_post(array(
            'ID' => $post_id,
            'post_title' => trim($title)
        ));
    }
});

// Activer les options d'écran
add_filter('screen_options_show_screen', '__return_true');

// Définir les options de pagination
add_filter('set_screen_option_edit_per_page', function ($status, $option, $value) {
    return (int) $value;
}, 10, 3);


/**
 * SECTION 7: AMÉLIORATION DE LA RECHERCHE
 */

// Étendre la recherche aux champs email et autres champs personnalisés
add_filter('posts_search', function ($search, $wp_query) use ($custom_post_types) {
    global $wpdb;

    // Seulement procéder si nous sommes dans l'admin et qu'il y a une recherche
    if (!is_admin() || empty($search) || !$wp_query->is_search) {
        return $search;
    }

    // Récupérer le terme de recherche
    $search_term = $wp_query->get('s');
    if (empty($search_term)) {
        return $search;
    }

    // Vérifier le type de post en cours
    $post_type = $wp_query->get('post_type');
    if (empty($post_type) || !isset($custom_post_types[$post_type])) {
        return $search;
    }

    // Définir les champs à rechercher pour chaque type de contenu
    $searchable_fields = [];
    switch ($post_type) {
        case 'membres':
            $searchable_fields = ['email', 'prenom', 'nom', 'telephone'];
            break;
        case 'entreprises':
            $searchable_fields = ['nom_entreprise', 'email_contact', 'site_web'];
            break;
        case 'evenements':
            $searchable_fields = ['titre_evenement', 'description_evenement'];
            break;
        case 'documents':
            $searchable_fields = ['titre_document', 'description_document'];
            break;
        case 'offres_emploi':
            $searchable_fields = ['intitule_poste', 'description_poste'];
            break;
    }

    // Si aucun champ à rechercher, retourner la recherche standard
    if (empty($searchable_fields)) {
        return $search;
    }

    // Construire la clause SQL pour les champs personnalisés
    $like = '%' . $wpdb->esc_like($search_term) . '%';
    $meta_query_parts = [];

    foreach ($searchable_fields as $field) {
        $meta_query_parts[] = $wpdb->prepare("(pm.meta_key = %s AND pm.meta_value LIKE %s)", $field, $like);
    }

    if (empty($meta_query_parts)) {
        return $search;
    }

    // Ajouter la clause OR pour les meta_values
    $search = str_replace(
        "AND ((({$wpdb->posts}.post_title",
        "AND ( (pm.post_id = {$wpdb->posts}.ID AND (" . implode(' OR ', $meta_query_parts) . ")) OR (({$wpdb->posts}.post_title",
        $search
    );

    // Ajouter la jointure avec la table postmeta
    add_filter('posts_join', function ($join) use ($wpdb) {
        return $join . " LEFT JOIN {$wpdb->postmeta} pm ON pm.post_id = {$wpdb->posts}.ID ";
    });

    // Ajouter une clause DISTINCT pour éviter les doublons
    add_filter('posts_distinct', function ($distinct) {
        return "DISTINCT";
    });

    return $search;
}, 10, 2);

add_action('restrict_manage_posts', function () use ($custom_post_types) {
    global $typenow;

    if (!isset($custom_post_types[$typenow])) return;

    $taxonomies = $custom_post_types[$typenow]['taxonomies'] ?? [];

    foreach ($taxonomies as $taxonomy) {
        $taxonomy_obj = get_taxonomy($taxonomy);
        if (!$taxonomy_obj) continue;

        $selected = $_GET[$taxonomy] ?? '';

        wp_dropdown_categories([
            'show_option_all' => sprintf(__('Toutes les %s', 'alumni-esg'), $taxonomy_obj->label),
            'taxonomy'        => $taxonomy,
            'name'            => $taxonomy,
            'orderby'         => 'name',
            'selected'        => $selected,
            'hierarchical'    => true,
            'depth'           => 2,
            'show_count'      => false,
            'hide_empty'      => false,
            'value_field'     => 'slug', // 🔑 Important pour ACF compatibility
        ]);
    }
});

add_filter('parse_query', function ($query) use ($custom_post_types) {
    global $pagenow;

    if (!is_admin() || $pagenow !== 'edit.php') return;

    $post_type = $query->query['post_type'] ?? '';
    if (!isset($custom_post_types[$post_type])) return;

    $taxonomies = $custom_post_types[$post_type]['taxonomies'] ?? [];

    foreach ($taxonomies as $taxonomy) {
        if (!empty($_GET[$taxonomy])) {
            $term = get_term_by('slug', sanitize_text_field($_GET[$taxonomy]), $taxonomy);
            if ($term) {
                $query->query_vars[$taxonomy] = $term->slug;
            }
        }
    }

    // Si un filtre d'archive est explicitement demandé
    if (isset($_GET['archive_status'])) {
        $archive_status = $_GET['archive_status'];

        if ($archive_status === 'archived') {
            $query->query_vars['meta_query'][] = [
                'key' => 'archive_status',
                'value' => 'archived',
                'compare' => '='
            ];
        } elseif ($archive_status === 'current') {
            $query->query_vars['meta_query'][] = [
                'relation' => 'OR',
                [
                    'key' => 'archive_status',
                    'value' => 'archived',
                    'compare' => '!='
                ],
                [
                    'key' => 'archive_status',
                    'compare' => 'NOT EXISTS'
                ]
            ];
        }
    }
    // Par défaut (pas de filtre), montrer uniquement les éléments actifs
    else {
        $query->query_vars['meta_query'][] = [
            'relation' => 'OR',
            [
                'key' => 'archive_status',
                'value' => 'archived',
                'compare' => '!='
            ],
            [
                'key' => 'archive_status',
                'compare' => 'NOT EXISTS'
            ]
        ];
    }
});

add_action('acf/save_post', function ($post_id) use ($custom_post_types) {
    // Ignore ACF options and autosaves
    if ($post_id === 'options' || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    $post_type = get_post_type($post_id);
    if (!isset($custom_post_types[$post_type])) {
        return;
    }

    $taxonomies = $custom_post_types[$post_type]['taxonomies'] ?? [];
    if (empty($taxonomies)) return;

    foreach ($taxonomies as $taxonomy) {
        $acf_value = get_field($taxonomy, $post_id);

        // Ignore empty values
        if (empty($acf_value)) continue;

        // Support single value or array of terms
        $terms = is_array($acf_value) ? $acf_value : [$acf_value];

        // Convert term names/IDs to term IDs
        $term_ids = [];
        foreach ($terms as $term) {
            if (is_numeric($term)) {
                $term_ids[] = (int) $term;
            } elseif (is_string($term)) {
                $term_obj = get_term_by('slug', $term, $taxonomy) ?: get_term_by('name', $term, $taxonomy);
                if ($term_obj && !is_wp_error($term_obj)) {
                    $term_ids[] = (int) $term_obj->term_id;
                }
            }
        }

        // Assign terms to post in WordPress
        if (!empty($term_ids)) {
            wp_set_object_terms($post_id, $term_ids, $taxonomy, false); // replace terms
        }
    }
}, 20); // run after ACF fields have been saved


add_action('init', function () {
    if (!get_role('etudiant')) {
        add_role('etudiant', 'Étudiant', [
            'read' => true,              // Peut accéder au tableau de bord
            'edit_posts' => false,       // Ne peut pas écrire d'articles
            'delete_posts' => false,
        ]);
    }
});


add_action('acf/save_post', function ($post_id) {
    // Sécurité : ignorer révisions, autosaves et options
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) || $post_id === 'options') return;

    // Vérifie que c'est bien un post du CPT "membres"
    if (get_post_type($post_id) !== 'membres') return;

    // Vérifie si un utilisateur est déjà lié
    $linked_user_id = get_field('compte_associe', $post_id);
    if (!empty($linked_user_id)) return;

    // Récupération des champs ACF nécessaires
    $email  = get_field('email', $post_id);
    $prenom = get_field('prenom', $post_id);
    $nom    = get_field('nom', $post_id);

    if (empty($email) || empty($prenom) || empty($nom)) return;

    // Vérifie si un user existe déjà avec cet email
    if (email_exists($email)) {
        $user = get_user_by('email', $email);
        update_field('compte_associe', $user->ID, $post_id); // Associer au membre
        return;
    }

    // Génération d'un username unique basé sur prénom.nom
    $base_username = sanitize_user($prenom . '.' . $nom, true);
    $username = $base_username;
    $counter = 1;

    while (username_exists($username)) {
        $username = $base_username . $counter;
        $counter++;
    }

    // Génération d'un mot de passe sécurisé
    $password = wp_generate_password(12, true, true);

    // Création du compte utilisateur
    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) return;

    // Mise à jour du profil utilisateur
    wp_update_user([
        'ID' => $user_id,
        'first_name' => $prenom,
        'last_name'  => $nom,
        'role' => 'etudiant',
    ]);

    // Lier l'utilisateur au membre (champ ACF de type "Utilisateur")
    update_field('compte_associe', $user_id, $post_id);

    // (Optionnel) Envoyer un email avec les infos de connexion
    wp_mail(
        $email,
        'Votre accès Alumni ESG',
        "
        Bonjour $prenom,

        Votre compte étudiant a été créé sur le portail Alumni ESG.

        Identifiant : $username
        Mot de passe : $password

        Lien de connexion : " . wp_login_url()
    );
}, 20); // Priorité : après que ACF ait sauvegardé les champs




add_action('wp_login_failed', function () {
    $referrer = wp_get_referer();
    if (!empty($referrer) && !str_contains($referrer, 'wp-login') && !str_contains($referrer, 'wp-admin')) {
        wp_redirect(add_query_arg('login', 'failed', $referrer));
        exit;
    }
});

add_filter('login_redirect', function ($redirect_to, $request, $user) {
    if (isset($user->roles) && in_array('etudiant', $user->roles)) {
        return site_url('/dashboard-etudiant');
    }
    return $redirect_to;
}, 10, 3);


add_shortcode('logout_etudiant', function () {
    // Redirection vers la page de connexion après déconnexion
    $logout_url = wp_logout_url(site_url('/connexion-etudiant'));

    return '<a href="' . esc_url($logout_url) . '" class="btn-logout" style="display:inline-block;padding:10px 20px;background:#ff6d70;color:white;border:none;border-radius:5px;text-decoration:none;">
        🚪 Se déconnecter
    </a>';
});

add_action('admin_init', function () {
    // Vérifie que l'utilisateur est connecté et a le rôle "etudiant"
    if (current_user_can('etudiant') && !defined('DOING_AJAX')) {
        wp_redirect(site_url('/dashboard-etudiant'));
        exit;
    }
});

add_action('after_setup_theme', function () {
    if (current_user_can('etudiant')) {
        show_admin_bar(false);
    }
});

add_filter('template_include', function ($template) {
    // For dashboard page, use the dedicated dashboard template
    if (is_page('dashboard-etudiant')) {
        $dashboard_template = get_stylesheet_directory() . '/dashboard-etudiant-template.php';
        if (file_exists($dashboard_template)) {
            return $dashboard_template;
        }
    }

    // For profile page, use the dedicated profile template
    if (is_page('mon-profil-etudiant')) {
        $profile_template = get_stylesheet_directory() . '/profil-etudiant-template.php';
        if (file_exists($profile_template)) {
            return $profile_template;
        }
    }

    // For login page, use the dedicated login template
    if (is_page('connexion-etudiant')) {
        $login_template = get_stylesheet_directory() . '/page-login-template.php';
        if (file_exists($login_template)) {
            return $login_template;
        }
    }

    // For events list page, use the dedicated events template
    if (is_page('liste-des-evenements')) {
        $events_template = get_stylesheet_directory() . '/evenements-template.php';
        if (file_exists($events_template)) {
            return $events_template;
        }
    }

    // For jobs list page, use the dedicated jobs template
    if (is_page('offres-emploi')) {
        $jobs_template = get_stylesheet_directory() . '/offres-emploi-template.php';
        if (file_exists($jobs_template)) {
            return $jobs_template;
        }
    }

    // For companies list page, use the dedicated companies template
    if (is_page('entreprises-partenaires')) {
        $companies_template = get_stylesheet_directory() . '/entreprises-template.php';
        if (file_exists($companies_template)) {
            return $companies_template;
        }
    }

    if (is_page('home-alumni-esg')) {
        $companies_template = get_stylesheet_directory() . '/landing-page-template.php';
        if (file_exists($companies_template)) {
            return $companies_template;
        }
    }

    if (is_page('inscription-laureat')) {
        $companies_template = get_stylesheet_directory() . '/page-registration.php';
        if (file_exists($companies_template)) {
            return $companies_template;
        }
    }

    if (is_page('qui-sommes-nous')) {
        $companies_template = get_stylesheet_directory() . '/page-qui-sommes-nous.php';
        if (file_exists($companies_template)) {
            return $companies_template;
        }
    }
    if (is_page('actualites')) {
        $companies_template = get_stylesheet_directory() . '/page-actualites.php';
        if (file_exists($companies_template)) {
            return $companies_template;
        }
    }
    if (is_page('nos-leaders')) {
        $companies_template = get_stylesheet_directory() . '/page-nos-leaders.php';
        if (file_exists($companies_template)) {
            return $companies_template;
        }
    }
    return $template;
});

add_shortcode('liste_offres', function () {
    ob_start();
    $offres = new WP_Query([
        'post_type' => 'offres_emploi',
        'posts_per_page' => 5,
        'post_status' => 'publish'
    ]);
    if ($offres->have_posts()) {
        echo "<h3>Offres d'emploi</h3><ul>";
        while ($offres->have_posts()) {
            $offres->the_post();
            echo "<li><a href='" . get_permalink() . "'>" . get_field('intitule_poste') . "</a></li>";
        }
        echo "</ul>";
    }
    wp_reset_postdata();
    return ob_get_clean();
});

add_shortcode('liste_evenements', function () {
    ob_start();
    $events = new WP_Query([
        'post_type' => 'evenements',
        'posts_per_page' => 5,
        'post_status' => 'publish'
    ]);
    if ($events->have_posts()) {
        echo "<h3>Événements à venir</h3><ul>";
        while ($events->have_posts()) {
            $events->the_post();
            echo "<li><a href='" . get_permalink() . "'>" . get_field('titre_evenement') . "</a></li>";
        }
        echo "</ul>";
    }
    wp_reset_postdata();
    return ob_get_clean();
});

add_shortcode('liste_entreprises', function () {
    ob_start();
    $entreprises = new WP_Query([
        'post_type' => 'entreprises',
        'posts_per_page' => 5,
        'post_status' => 'publish'
    ]);
    if ($entreprises->have_posts()) {
        echo "<h3>Entreprises partenaires</h3><ul>";
        while ($entreprises->have_posts()) {
            $entreprises->the_post();
            echo "<li><a href='" . get_permalink() . "'>" . get_field('nom_entreprise') . "</a></li>";
        }
        echo "</ul>";
    }
    wp_reset_postdata();
    return ob_get_clean();
});

// Ajout du filtre d'archives dans l'interface d'administration
add_action('restrict_manage_posts', function () use ($custom_post_types) {
    global $typenow;

    if (!isset($custom_post_types[$typenow])) return;

    $status = isset($_GET['archive_status']) ? $_GET['archive_status'] : '';
?>
    <select name="archive_status" id="filter-by-archive">
        <option value="">Tous les statuts</option>
        <option value="current" <?php selected($status, 'current'); ?>>En cours</option>
        <option value="archived" <?php selected($status, 'archived'); ?>>Archivés</option>
    </select>
<?php
});

// Modification de la requête pour le filtre d'archives
add_filter('parse_query', function ($query) use ($custom_post_types) {
    global $pagenow;

    if (!is_admin() || $pagenow !== 'edit.php') return;

    $post_type = $query->query['post_type'] ?? '';
    if (!isset($custom_post_types[$post_type])) return;

    // Si un filtre d'archive est explicitement demandé
    if (isset($_GET['archive_status'])) {
        $archive_status = $_GET['archive_status'];

        if ($archive_status === 'archived') {
            $query->query_vars['meta_query'][] = [
                'key' => 'archive_status',
                'value' => 'archived',
                'compare' => '='
            ];
        } elseif ($archive_status === 'current') {
            $query->query_vars['meta_query'][] = [
                'relation' => 'OR',
                [
                    'key' => 'archive_status',
                    'value' => 'archived',
                    'compare' => '!='
                ],
                [
                    'key' => 'archive_status',
                    'compare' => 'NOT EXISTS'
                ]
            ];
        }
    }
    // Par défaut (pas de filtre), montrer uniquement les éléments actifs
    else {
        $query->query_vars['meta_query'][] = [
            'relation' => 'OR',
            [
                'key' => 'archive_status',
                'value' => 'archived',
                'compare' => '!='
            ],
            [
                'key' => 'archive_status',
                'compare' => 'NOT EXISTS'
            ]
        ];
    }
});

// Ajout du bouton d'archivage dans la page d'édition
add_action('post_submitbox_misc_actions', function () use ($custom_post_types) {
    global $post;

    if (!isset($custom_post_types[$post->post_type])) return;

    $is_archived = get_post_meta($post->ID, 'archive_status', true) === 'archived';
?>
    <div class="misc-pub-section archive-info">
        <span class="dashicons dashicons-archive" style="color:#82878c;"></span>
        Status :
        <strong><?php echo $is_archived ? 'Archivé' : 'En cours'; ?></strong>
        <a href="#" class="edit-archive-status hide-if-no-js" role="button">
            <span aria-hidden="true">Modifier</span>
        </a>
        <div class="archive-select hide-if-js">
            <input type="radio" name="archive_status" id="archive_status_current" value="current" <?php checked(!$is_archived); ?>>
            <label for="archive_status_current">En cours</label><br>
            <input type="radio" name="archive_status" id="archive_status_archived" value="archived" <?php checked($is_archived); ?>>
            <label for="archive_status_archived">Archivé</label><br>
            <p>
                <a href="#" class="save-archive-status hide-if-no-js button">OK</a>
                <a href="#" class="cancel-archive-status hide-if-no-js button-cancel">Annuler</a>
            </p>
        </div>
    </div>
    <style>
        .archive-select {
            margin-top: 8px;
        }

        .archive-select label {
            margin-left: 4px;
        }

        .archive-select p {
            margin: 8px 0 0;
        }

        .archive-info .dashicons {
            margin-right: 5px;
        }
    </style>
    <script>
        jQuery(document).ready(function($) {
            $('.edit-archive-status').click(function(e) {
                e.preventDefault();
                $('.archive-select').slideDown();
                $(this).hide();
            });

            $('.cancel-archive-status').click(function(e) {
                e.preventDefault();
                $('.archive-select').slideUp();
                $('.edit-archive-status').show();
            });

            $('.save-archive-status').click(function(e) {
                e.preventDefault();
                var status = $('input[name="archive_status"]:checked').val();

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'update_archive_status',
                        post_id: $('#post_ID').val(),
                        status: status,
                        nonce: '<?php echo wp_create_nonce('update_archive_status'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.archive-info strong').text(status === 'archived' ? 'Archivé' : 'En cours');
                            $('.archive-select').slideUp();
                            $('.edit-archive-status').show();
                        }
                    }
                });
            });
        });
    </script>
<?php
});

// Gestionnaire AJAX pour la mise à jour du statut d'archive
add_action('wp_ajax_update_archive_status', function () {
    // Vérification des permissions
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permissions insuffisantes');
    }

    if (!isset($_POST['post_id']) || !isset($_POST['status']) || !isset($_POST['nonce'])) {
        wp_send_json_error('Paramètres manquants');
    }

    if (!wp_verify_nonce($_POST['nonce'], 'update_archive_status')) {
        wp_send_json_error('Nonce invalide');
    }

    $post_id = intval($_POST['post_id']);

    // Vérifier que l'utilisateur peut éditer ce post spécifique
    if (!current_user_can('edit_post', $post_id)) {
        wp_send_json_error('Permissions insuffisantes pour ce contenu');
    }

    $status = sanitize_text_field($_POST['status']);

    if ($status === 'archived') {
        update_post_meta($post_id, 'archive_status', 'archived');
    } else {
        delete_post_meta($post_id, 'archive_status');
    }

    wp_send_json_success([
        'message' => 'Statut mis à jour avec succès',
        'status' => $status
    ]);
});

// Ajouter le JavaScript pour l'archivage rapide
add_action('admin_footer', function () use ($custom_post_types) {
    $screen = get_current_screen();
    if (!$screen || !isset($custom_post_types[$screen->post_type])) return;
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Gérer les clics sur les liens d'archivage/désarchivage
            $('.toggle-archive').on('click', function(e) {
                e.preventDefault();
                var link = $(this);
                var row = link.closest('tr');
                var postId = link.data('id');
                var action = link.data('action');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'update_archive_status',
                        post_id: postId,
                        status: action,
                        nonce: '<?php echo wp_create_nonce('update_archive_status'); ?>'
                    },
                    beforeSend: function() {
                        row.css('opacity', '0.5');
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            row.css('opacity', '1');
                            alert('Erreur lors de la mise à jour du statut');
                        }
                    },
                    error: function() {
                        row.css('opacity', '1');
                        alert('Erreur lors de la mise à jour du statut');
                    }
                });
            });

            // Ajouter les actions rapides aux lignes
            $('.type-' + '<?php echo $screen->post_type; ?>').each(function() {
                var row = $(this);
                var id = row.attr('id').replace('post-', '');
                var actions = row.find('.row-actions');

                if (actions.length) {
                    var status = row.find('.archive-status').hasClass('archived');
                    var newAction = status ?
                        '<span class="unarchive"><a href="#" data-id="' + id + '" data-action="current" class="toggle-archive">Désarchiver</a> |</span>' :
                        '<span class="archive"><a href="#" data-id="' + id + '" data-action="archived" class="toggle-archive">Archiver</a> |</span>';

                    actions.prepend(newAction);
                }
            });
        });
    </script>
<?php
});

// Add authentication filter to check user activation with ACF support
add_filter('authenticate', function ($user, $username, $password) {
    if ($user instanceof WP_User) {
        // Get associated member post
        $args = array(
            'post_type' => 'membres',
            'meta_query' => array(
                array(
                    'key' => 'compte_associe',
                    'value' => $user->ID,
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1
        );

        $member_query = new WP_Query($args);

        if ($member_query->have_posts()) {
            $member_query->the_post();
            // Use ACF's get_field() to check active status
            $is_active = get_field('active', get_the_ID());
            wp_reset_postdata();

            if (!$is_active) {
                return new WP_Error('account_inactive', 'Votre compte n\'est pas encore activé. Veuillez contacter l\'administration.');
            }
        }

        return $user;
    }

    return $user;
}, 20, 3);

// Redirect root URL to /home-alumni-esg/
add_action('template_redirect', function () {
    if (is_home() && is_front_page() && $_SERVER['REQUEST_URI'] == '/') {
        wp_redirect(home_url('/home-alumni-esg/'), 301);
        exit;
    }
});

/**
 * SECTION 3: GESTION DES INSCRIPTIONS AUX ÉVÉNEMENTS
 */
add_action('template_redirect', 'handle_event_registration');

function handle_event_registration()
{
    // Sortir si ce n'est pas une page d'événement ou si l'utilisateur n'est pas connecté
    if (!is_singular('evenements') || !is_user_logged_in()) {
        return;
    }

    // Vérifier s'il y a une action d'inscription ou désinscription
    if (
        isset($_POST['event_registration_nonce']) &&
        (wp_verify_nonce($_POST['event_registration_nonce'], 'event_registration') ||
            wp_verify_nonce($_POST['event_registration_nonce'], 'register_for_event'))
    ) {

        $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
        $user_id = get_current_user_id();

        if ($event_id > 0) {
            // Trouver le post du membre associé à cet utilisateur
            $args = array(
                'post_type' => 'membres',
                'meta_query' => array(
                    array(
                        'key' => 'compte_associe',
                        'value' => $user_id,
                        'compare' => '='
                    )
                ),
                'posts_per_page' => 1
            );

            $member_query = new WP_Query($args);

            if ($member_query->have_posts()) {
                $member_query->the_post();
                $member_id = get_the_ID();

                // Récupérer les événements liés actuels
                $events_linked = get_field('evenements_lies', $member_id);
                if (!is_array($events_linked)) {
                    $events_linked = array();
                }

                // Vérifier si l'action est de se désinscrire
                if (isset($_POST['action']) && $_POST['action'] === 'unregister') {
                    // Supprimer l'événement des événements liés
                    $key = array_search($event_id, $events_linked);
                    if ($key !== false) {
                        unset($events_linked[$key]);
                        $events_linked = array_values($events_linked); // Réindexer le tableau
                        update_field('evenements_lies', $events_linked, $member_id);
                    }

                    // Rediriger avec message de confirmation
                    wp_redirect(add_query_arg('registration', 'unregistered', get_permalink($event_id)));
                    exit;
                } else {
                    // Ajouter l'événement aux événements liés s'il n'y est pas déjà
                    if (!in_array($event_id, $events_linked)) {
                        $events_linked[] = $event_id;
                        update_field('evenements_lies', $events_linked, $member_id);
                    }

                    // Rediriger avec message de confirmation
                    wp_redirect(add_query_arg('registration', 'success', get_permalink($event_id)));
                    exit;
                }

                wp_reset_postdata();
            }
        }
    }
}

// Ajouter un shortcode pour afficher les événements auxquels l'utilisateur est inscrit
add_shortcode('mes_evenements', 'display_user_registered_events');
function display_user_registered_events($atts)
{
    // Sortir si l'utilisateur n'est pas connecté
    if (!is_user_logged_in()) {
        return '<p>Veuillez vous <a href="' . wp_login_url($_SERVER['REQUEST_URI']) . '">connecter</a> pour voir vos événements.</p>';
    }

    $user_id = get_current_user_id();
    $registered_events = get_user_meta($user_id, 'registered_events', true);

    if (!is_array($registered_events) || empty($registered_events)) {
        return '<p>Vous n\'êtes inscrit(e) à aucun événement pour le moment.</p>';
    }

    $output = '<div class="user-events">';
    $output .= '<h3>Mes événements</h3>';
    $output .= '<ul class="events-list">';

    foreach ($registered_events as $event_id) {
        $event = get_post($event_id);
        if ($event && $event->post_status === 'publish') {
            $date = get_field('date_evenement', $event_id);
            $formatted_date = $date ? date_i18n('j F Y', strtotime($date)) : '—';

            $output .= '<li class="event-item">';
            $output .= '<a href="' . get_permalink($event_id) . '">' . get_the_title($event_id) . '</a>';
            $output .= '<span class="event-date"> - ' . $formatted_date . '</span>';
            $output .= '</li>';
        }
    }

    $output .= '</ul>';
    $output .= '</div>';

    return $output;
}

/**
 * SECTION 8: CRÉATION DE LA PAGE INSCRITS POUR LES ÉVÉNEMENTS
 */

// Ajouter les sous-menus configurés dans les types de contenu personnalisés
add_action('admin_menu', function () use ($custom_post_types) {
    foreach ($custom_post_types as $post_type => $settings) {
        if (isset($settings['submenu']) && is_array($settings['submenu'])) {
            foreach ($settings['submenu'] as $slug => $label) {
                add_submenu_page(
                    'edit.php?post_type=' . $post_type,
                    $label,
                    $label,
                    'edit_posts',
                    $post_type . '-' . $slug,
                    'render_' . $post_type . '_' . $slug . '_page'
                );
            }
        }
    }
});

/**
 * Affiche la page des inscrits aux événements
 */
function render_evenements_inscrits_page()
{
    // Vérifier les permissions
    if (!current_user_can('edit_posts')) {
        wp_die(__('Vous n\'avez pas les permissions suffisantes pour accéder à cette page.', 'alumni-esg'));
    }

    // Récupérer tous les événements
    $events = get_posts([
        'post_type' => 'evenements',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'meta_value',
        'meta_key' => 'date_evenement',
        'order' => 'DESC',
    ]);

    // Filtrer par événement si un ID est spécifié
    $current_event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

?>
    <div class="wrap">
        <h1><?php _e('Inscrits aux événements', 'alumni-esg'); ?></h1>

        <div class="event-filter" style="margin-bottom: 20px; background: #fff; padding: 15px; border: 1px solid #ccd0d4; border-radius: 4px;">
            <form method="get">
                <input type="hidden" name="post_type" value="evenements">
                <input type="hidden" name="page" value="evenements-inscrits">

                <label for="event_id" style="font-weight: 600; margin-right: 10px;">Sélectionner un événement:</label>
                <select name="event_id" id="event_id" style="min-width: 300px;">
                    <option value="">Tous les événements</option>
                    <?php foreach ($events as $event) :
                        $event_date = get_field('date_evenement', $event->ID);
                        $formatted_date = $event_date ? ' (' . date_i18n('d/m/Y', strtotime($event_date)) . ')' : '';
                    ?>
                        <option value="<?php echo $event->ID; ?>" <?php selected($current_event_id, $event->ID); ?>>
                            <?php echo get_field('titre_evenement', $event->ID) . $formatted_date; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="button" style="margin-left: 10px;">Filtrer</button>

                <?php if ($current_event_id) : ?>
                    <a href="<?php echo admin_url('edit.php?post_type=evenements&page=evenements-inscrits'); ?>" class="button" style="margin-left: 10px;">Réinitialiser</a>
                    <a href="<?php echo admin_url('post.php?post=' . $current_event_id . '&action=edit'); ?>" class="button" style="margin-left: 10px;">Voir l'événement</a>
                <?php endif; ?>
            </form>
        </div>

        <?php
        // Si un événement spécifique est sélectionné
        if ($current_event_id) {
            display_event_registrants($current_event_id);
        } else {
            display_all_events_registrants($events);
        }
        ?>
    </div>
<?php
}

/**
 * Affiche les inscrits pour un événement spécifique
 */
function display_event_registrants($event_id)
{
    $event_title = get_field('titre_evenement', $event_id);
    $event_date = get_field('date_evenement', $event_id);
    $formatted_date = $event_date ? date_i18n('d F Y', strtotime($event_date)) : '—';

    echo '<div class="event-details" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-left: 4px solid #2271b1;">';
    echo '<h2>' . esc_html($event_title) . '</h2>';
    echo '<p><strong>Date:</strong> ' . esc_html($formatted_date) . '</p>';
    echo '</div>';

    // Trouver tous les membres inscrits à cet événement
    $members = get_posts([
        'post_type' => 'membres',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'evenements_lies',
                'value' => '"' . $event_id . '"',
                'compare' => 'LIKE'
            ]
        ]
    ]);

    if (empty($members)) {
        echo '<div class="notice notice-info"><p>Aucun inscrit pour cet événement.</p></div>';
        return;
    }

    $count = count($members);
    echo '<div class="tablenav top">';
    echo '<div class="tablenav-pages">';
    echo '<span class="displaying-num">' . $count . ' ' . _n('inscrit', 'inscrits', $count, 'alumni-esg') . '</span>';
    echo '</div>';
    echo '</div>';

?>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th scope="col" class="column-primary">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member) :
                $prenom = get_field('prenom', $member->ID);
                $nom = get_field('nom', $member->ID);
                $email = get_field('email', $member->ID);
                $telephone = get_field('telephone', $member->ID);

                // Récupérer les catégories du membre
                $categories = get_the_terms($member->ID, 'categories_membre');
                $category_names = [];
                if ($categories && !is_wp_error($categories)) {
                    foreach ($categories as $category) {
                        $category_names[] = $category->name;
                    }
                }
                $category_display = !empty($category_names) ? implode(', ', $category_names) : '—';
            ?>
                <tr>
                    <td class="column-primary">
                        <a href="<?php echo get_edit_post_link($member->ID); ?>">
                            <strong><?php echo esc_html($prenom . ' ' . $nom); ?></strong>
                        </a>
                    </td>
                    <td><?php echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—'; ?></td>
                    <td><?php echo esc_html($telephone ?: '—'); ?></td>
                    <td><?php echo $category_display; ?></td>
                    <td>
                        <a href="<?php echo get_edit_post_link($member->ID); ?>" class="button button-small">Voir le profil</a>
                        <button type="button" class="button button-small unregister-member"
                            data-member="<?php echo $member->ID; ?>"
                            data-event="<?php echo $event_id; ?>"
                            data-nonce="<?php echo wp_create_nonce('unregister_member_event'); ?>">
                            Désinscrire
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        jQuery(document).ready(function($) {
            $('.unregister-member').on('click', function() {
                if (!confirm('Êtes-vous sûr de vouloir désinscrire ce membre de l\'événement?')) {
                    return;
                }

                var button = $(this);
                var member_id = button.data('member');
                var event_id = button.data('event');
                var nonce = button.data('nonce');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'unregister_member_from_event',
                        member_id: member_id,
                        event_id: event_id,
                        nonce: nonce
                    },
                    beforeSend: function() {
                        button.prop('disabled', true).text('Désinscription...');
                    },
                    success: function(response) {
                        if (response.success) {
                            button.closest('tr').fadeOut(300, function() {
                                $(this).remove();
                                // Mettre à jour le compteur d'inscrits
                                var count = $('.wp-list-table tbody tr').length;
                                $('.displaying-num').text(count + ' ' + (count > 1 ? 'inscrits' : 'inscrit'));

                                if (count === 0) {
                                    $('.wp-list-table').after('<div class="notice notice-info"><p>Aucun inscrit pour cet événement.</p></div>');
                                }
                            });
                        } else {
                            alert('Erreur: ' + response.data.message);
                            button.prop('disabled', false).text('Désinscrire');
                        }
                    },
                    error: function() {
                        alert('Une erreur s\'est produite. Veuillez réessayer.');
                        button.prop('disabled', false).text('Désinscrire');
                    }
                });
            });
        });
    </script>
<?php
}

/**
 * Affiche un résumé de tous les événements avec leur nombre d'inscrits
 */
function display_all_events_registrants($events)
{
    if (empty($events)) {
        echo '<div class="notice notice-info"><p>Aucun événement trouvé.</p></div>';
        return;
    }

?>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th scope="col" class="column-primary">Événement</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                <th scope="col">Localisation</th>
                <th scope="col">Nombre d'inscrits</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event) :
                $event_title = get_field('titre_evenement', $event->ID);
                $event_date = get_field('date_evenement', $event->ID);
                $formatted_date = $event_date ? date_i18n('d F Y', strtotime($event_date)) : '—';

                // Récupérer le type d'événement
                $types = get_the_terms($event->ID, 'types_evenement');
                $type_names = [];
                if ($types && !is_wp_error($types)) {
                    foreach ($types as $type) {
                        $type_names[] = $type->name;
                    }
                }
                $type_display = !empty($type_names) ? implode(', ', $type_names) : '—';

                // Récupérer la localisation
                $locations = get_the_terms($event->ID, 'localisations');
                $location_names = [];
                if ($locations && !is_wp_error($locations)) {
                    foreach ($locations as $location) {
                        $location_names[] = $location->name;
                    }
                }
                $location_display = !empty($location_names) ? implode(', ', $location_names) : '—';

                // Compter le nombre d'inscrits
                $registrants_count = count_event_registrants($event->ID);
            ?>
                <tr>
                    <td class="column-primary">
                        <a href="<?php echo get_edit_post_link($event->ID); ?>">
                            <strong><?php echo esc_html($event_title); ?></strong>
                        </a>
                    </td>
                    <td><?php echo esc_html($formatted_date); ?></td>
                    <td><?php echo esc_html($type_display); ?></td>
                    <td><?php echo esc_html($location_display); ?></td>
                    <td>
                        <?php if ($registrants_count > 0) : ?>
                            <a href="<?php echo admin_url('edit.php?post_type=evenements&page=evenements-inscrits&event_id=' . $event->ID); ?>">
                                <strong><?php echo $registrants_count; ?></strong>
                            </a>
                        <?php else : ?>
                            <span>0</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo admin_url('edit.php?post_type=evenements&page=evenements-inscrits&event_id=' . $event->ID); ?>" class="button button-small">
                            Voir les inscrits
                        </a>
                        <a href="<?php echo get_edit_post_link($event->ID); ?>" class="button button-small">
                            Modifier l'événement
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}

/**
 * Compte le nombre d'inscrits pour un événement
 */
function count_event_registrants($event_id)
{
    $members_query = new WP_Query([
        'post_type' => 'membres',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => [
            [
                'key' => 'evenements_lies',
                'value' => '"' . $event_id . '"',
                'compare' => 'LIKE'
            ]
        ]
    ]);

    return $members_query->found_posts;
}

/**
 * Gestionnaire AJAX pour désinscrire un membre d'un événement
 */
add_action('wp_ajax_unregister_member_from_event', function () {
    // Vérifier les permissions
    if (!current_user_can('edit_posts')) {
        wp_send_json_error(['message' => 'Permissions insuffisantes']);
    }

    // Vérifier le nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'unregister_member_event')) {
        wp_send_json_error(['message' => 'Vérification de sécurité échouée']);
    }

    // Récupérer les IDs
    $member_id = isset($_POST['member_id']) ? intval($_POST['member_id']) : 0;
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

    if (!$member_id || !$event_id) {
        wp_send_json_error(['message' => 'IDs invalides']);
    }

    // Récupérer les événements liés du membre
    $events_linked = get_field('evenements_lies', $member_id);
    if (!is_array($events_linked)) {
        $events_linked = [];
    }

    // Supprimer l'événement de la liste
    $key = array_search($event_id, $events_linked);
    if ($key !== false) {
        unset($events_linked[$key]);
        $events_linked = array_values($events_linked); // Réindexer le tableau
        update_field('evenements_lies', $events_linked, $member_id);
        wp_send_json_success(['message' => 'Membre désinscrit avec succès']);
    } else {
        wp_send_json_error(['message' => 'Le membre n\'est pas inscrit à cet événement']);
    }
});

/**
 * Filter main queries to exclude archived posts on the frontend for all custom post types
 */
add_action('pre_get_posts', function ($query) {
    // Only modify frontend queries that aren't in the admin area
    if (!is_admin() && ($query->is_main_query() || !$query->is_main_query())) {

        // Get the post type from the query
        $post_type = $query->get('post_type');

        // Custom post types we want to filter
        $custom_types = ['evenements', 'entreprises', 'offres_emploi', 'documents', 'membres'];

        // Check if this is a query for our custom post types
        if (
            in_array($post_type, $custom_types) ||
            (is_page() && (
                is_page('liste-des-evenements') ||
                is_page('entreprises-partenaires') ||
                is_page('offres-emploi')
            ))
        ) {

            // Add meta query to exclude archived posts
            $current_meta_query = $query->get('meta_query');
            if (!is_array($current_meta_query)) {
                $current_meta_query = [];
            }

            // Add our condition to exclude archived posts
            $current_meta_query[] = [
                'relation' => 'OR',
                [
                    'key' => 'archive_status',
                    'value' => 'archived',
                    'compare' => '!='
                ],
                [
                    'key' => 'archive_status',
                    'compare' => 'NOT EXISTS'
                ]
            ];

            $query->set('meta_query', $current_meta_query);
        }
    }
});

/**
 * Check for archived posts and redirect on single post pages
 */
add_action('template_redirect', function () {
    // Custom post types to check for archive status
    $custom_types = ['evenements', 'entreprises', 'offres_emploi', 'documents'];

    // Only check on singular pages of our custom post types
    if (is_singular($custom_types)) {
        $post_id = get_the_ID();
        $post_type = get_post_type();

        // Check if post is archived
        $is_archived = get_post_meta($post_id, 'archive_status', true) === 'archived';

        if ($is_archived) {
            // Redirect based on post type
            switch ($post_type) {
                case 'evenements':
                    $redirect_url = add_query_arg('archive_notice', 'event', site_url('/liste-des-evenements'));
                    break;
                case 'entreprises':
                    $redirect_url = add_query_arg('archive_notice', 'company', site_url('/entreprises-partenaires'));
                    break;
                case 'offres_emploi':
                    $redirect_url = add_query_arg('archive_notice', 'job', site_url('/offres-emploi'));
                    break;
                case 'documents':
                    $redirect_url = add_query_arg('archive_notice', 'document', site_url('/'));
                    break;
                default:
                    $redirect_url = add_query_arg('archive_notice', 'general', site_url('/'));
            }

            wp_redirect($redirect_url);
            exit;
        }
    }
});

/**
 * Display notice when redirected from archived content
 */
add_action('wp_footer', function () {
    if (isset($_GET['archive_notice'])) {
        $notice_type = $_GET['archive_notice'];

        $message = 'Le contenu que vous avez essayé de consulter a été archivé et n\'est plus disponible.';

        switch ($notice_type) {
            case 'event':
                $message = 'L\'événement que vous avez essayé de consulter a été archivé et n\'est plus disponible.';
                break;
            case 'company':
                $message = 'L\'entreprise que vous avez essayé de consulter a été archivée et n\'est plus disponible.';
                break;
            case 'job':
                $message = 'L\'offre d\'emploi que vous avez essayé de consulter a été archivée et n\'est plus disponible.';
                break;
            case 'document':
                $message = 'Le document que vous avez essayé de consulter a été archivé et n\'est plus disponible.';
                break;
        }

        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                const container = document.querySelector("main, .content-area, .site-content");
                if (container) {
                    const notice = document.createElement("div");
                    notice.className = "archived-content-notice";
                    notice.innerHTML = "<p>' . esc_js($message) . '</p>";
                    notice.style.cssText = "background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #f5c6cb;";
                    container.insertBefore(notice, container.firstChild);
                }
            });
        </script>';
    }
});

/**
 * SECTION 9: GESTION DES CANDIDATURES
 */

// Hide "Add New" button and bulk actions for Candidatures post type
add_action('admin_head', function () {
    global $typenow;
    if ($typenow === 'candidatures') {
        echo '<style>
            /* Hide "Add New" button */
            .page-title-action,
            /* Hide bulk actions dropdown and button */
            .tablenav .bulkactions,
            /* Hide screen options and help tabs */
            #screen-options-link-wrap, 
            #contextual-help-link-wrap {
                display: none !important;
            }
        </style>';
    }
});

// Add custom columns to candidatures post type 
add_filter('manage_candidatures_posts_columns', function ($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = 'Candidat';
    $new_columns['offre_associee'] = 'Offre d\'emploi';
    $new_columns['membre_associe'] = 'Profil';
    $new_columns['cv'] = 'Documents';
    $new_columns['status'] = 'Statut';
    $new_columns['date_candidature'] = 'Date de candidature';
    return $new_columns;
});

// Populate custom columns for candidatures
add_action('manage_candidatures_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'offre_associee':
            $job_id = get_field('offre_associee', $post_id);
            if ($job_id) {
                $title = get_field('intitule_poste', $job_id);
                $job_link = get_edit_post_link($job_id);
                $company_id = get_field('entreprise_associee', $job_id);
                $company_name = '';

                if ($company_id) {
                    $company_name = get_field('nom_entreprise', $company_id);
                }

                echo '<a href="' . esc_url($job_link) . '" title="Modifier cette offre"><strong>' . esc_html($title) . '</strong></a>';
                if (!empty($company_name)) {
                    echo '<br><span style="color:#666; font-size:12px;">' . esc_html($company_name) . '</span>';
                }
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;

        case 'membre_associe':
            $member_id = get_field('membre_associe', $post_id);
            if ($member_id) {
                $prenom = get_field('prenom', $member_id);
                $nom = get_field('nom', $member_id);
                $email = get_field('email', $member_id);

                echo '<a href="' . get_edit_post_link($member_id) . '" title="Voir le profil complet">';
                echo '<strong>' . esc_html($prenom . ' ' . $nom) . '</strong>';
                echo '</a>';

                if (!empty($email)) {
                    echo '<br><a href="mailto:' . esc_attr($email) . '" style="color:#666; font-size:12px;">' . esc_html($email) . '</a>';
                }
            } else {
                $post_author = get_post_field('post_author', $post_id);
                $user_data = get_userdata($post_author);

                if ($user_data) {
                    echo '<strong>' . esc_html($user_data->display_name) . '</strong>';
                    echo '<br><a href="mailto:' . esc_attr($user_data->user_email) . '" style="color:#666; font-size:12px;">' . esc_html($user_data->user_email) . '</a>';
                } else {
                    echo '<span style="color:#999;">—</span>';
                }
            }
            break;

        case 'cv':
            $cv = get_field('cv', $post_id);
            $cover_letter = get_field('lettre_motivation', $post_id);
            $output = [];

            if ($cv) {
                // Handle different return formats from ACF
                if (is_array($cv) && isset($cv['url'])) {
                    // Already in array format
                    $cv_url = $cv['url'];
                    $file_ext = isset($cv['filename']) ? pathinfo($cv['filename'], PATHINFO_EXTENSION) : '';
                } else if (is_numeric($cv)) {
                    // Attachment ID format
                    $cv_url = wp_get_attachment_url($cv);
                    $file_ext = pathinfo($cv_url, PATHINFO_EXTENSION);
                } else if (is_string($cv)) {
                    // URL string format
                    $cv_url = $cv;
                    $file_ext = pathinfo($cv_url, PATHINFO_EXTENSION);
                } else {
                    // Unknown format
                    $cv_url = '';
                    $file_ext = '';
                }

                if (!empty($cv_url)) {
                    $icon_class = $file_ext === 'pdf' ? 'pdf' : 'word';
                    $output[] = '<a href="' . esc_url($cv_url) . '" target="_blank" class="button button-small" style="margin-bottom:4px;">';
                    $output[] = '<span class="dashicons dashicons-media-document" style="margin-right:3px; font-size:16px; line-height:1.4;"></span> CV';
                    $output[] = '</a>';
                }
            }

            if ($cover_letter) {
                // Handle different return formats for cover letter
                if (is_array($cover_letter) && isset($cover_letter['url'])) {
                    $letter_url = $cover_letter['url'];
                } else if (is_numeric($cover_letter)) {
                    $letter_url = wp_get_attachment_url($cover_letter);
                } else if (is_string($cover_letter)) {
                    $letter_url = $cover_letter;
                } else {
                    $letter_url = '';
                }

                if (!empty($letter_url)) {
                    $output[] = '<a href="' . esc_url($letter_url) . '" target="_blank" class="button button-small">';
                    $output[] = '<span class="dashicons dashicons-media-text" style="margin-right:3px; font-size:16px; line-height:1.4;"></span> LM';
                    $output[] = '</a>';
                }
            }

            echo !empty($output) ? implode(' ', $output) : '<span style="color:#999;">—</span>';
            break;

        case 'status':
            $application_status = get_field('statut_candidature', $post_id);
            $status_labels = [
                'pending' => 'À traiter',
                'reviewing' => 'En cours d\'examen',
                'interview' => 'Entretien planifié',
                'accepted' => 'Accepté',
                'rejected' => 'Refusé'
            ];

            $status_colors = [
                'pending' => '#646970',
                'reviewing' => '#007cba',
                'interview' => '#b26200',
                'accepted' => '#00a32a',
                'rejected' => '#d63638'
            ];

            $label = isset($status_labels[$application_status]) ? $status_labels[$application_status] : 'À traiter';
            $color = isset($status_colors[$application_status]) ? $status_colors[$application_status] : '#646970';

            // Show status badge
            echo '<div class="status-badge-wrapper">';
            echo '<span class="status-badge" style="display:inline-block; padding:3px 8px; border-radius:3px; background-color:' . $color . '; color:white; font-size:12px; margin-bottom:5px;">' . $label . '</span>';

            // Add status change dropdown
            echo '<div class="quick-status-change">';
            echo '<select class="change-application-status" data-post-id="' . $post_id . '" data-nonce="' . wp_create_nonce('change_application_status_' . $post_id) . '">';
            echo '<option value="">Changer...</option>';

            foreach ($status_labels as $value => $text) {
                if ($value !== $application_status) {
                    echo '<option value="' . $value . '">' . $text . '</option>';
                }
            }

            echo '</select>';
            echo '</div>';
            echo '</div>';
            break;

        case 'date_candidature':
            $date = get_field('date_candidature', $post_id);
            if (empty($date)) {
                $date = get_the_date('Y-m-d H:i:s', $post_id);
            }

            if (!empty($date)) {
                $timestamp = strtotime($date);
                $date_format = get_option('date_format');
                $time_format = get_option('time_format');

                echo '<span title="' . date_i18n($date_format . ' ' . $time_format, $timestamp) . '">';
                echo date_i18n($date_format, $timestamp);
                echo '</span>';
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
    }
}, 10, 2);

// Make date_candidature column sortable
add_filter('manage_edit-candidatures_sortable_columns', function ($columns) {
    $columns['date_candidature'] = 'date_candidature';
    $columns['status'] = 'status';
    $columns['offre_associee'] = 'offre_associee';
    return $columns;
});

// Add filter for applications by company and status
add_action('restrict_manage_posts', function () {
    global $typenow;
    if ($typenow === 'candidatures') {
        // Status filter
        $status_options = [
            'pending' => 'À traiter',
            'reviewing' => 'En cours d\'examen',
            'interview' => 'Entretien planifié',
            'accepted' => 'Accepté',
            'rejected' => 'Refusé'
        ];

        echo '<select name="application_status" id="filter-by-status">';
        echo '<option value="">Tous les statuts</option>';

        foreach ($status_options as $value => $label) {
            $selected = isset($_GET['application_status']) && $_GET['application_status'] === $value ? 'selected' : '';
            echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
        }

        echo '</select>';
    }
});

// Apply the status filter
add_filter('parse_query', function ($query) {
    global $pagenow, $typenow;

    if ($pagenow === 'edit.php' && $typenow === 'candidatures') {
        // Filter by application status
        if (isset($_GET['application_status']) && !empty($_GET['application_status'])) {
            $query->query_vars['meta_query'][] = [
                'key' => 'statut_candidature',
                'value' => sanitize_text_field($_GET['application_status']),
                'compare' => '='
            ];
        }

        // Handle sorting
        if (isset($query->query_vars['orderby'])) {
            switch ($query->query_vars['orderby']) {
                case 'date_candidature':
                    $query->query_vars['meta_key'] = 'date_candidature';
                    $query->query_vars['orderby'] = 'meta_value';
                    break;

                case 'status':
                    $query->query_vars['meta_key'] = 'statut_candidature';
                    $query->query_vars['orderby'] = 'meta_value';
                    break;

                case 'offre_associee':
                    $query->query_vars['meta_key'] = 'offre_associee';
                    $query->query_vars['orderby'] = 'meta_value_num';
                    break;
            }
        }

        // Default to newest first if no specific order
        if (!isset($_GET['orderby'])) {
            $query->query_vars['meta_key'] = 'date_candidature';
            $query->query_vars['orderby'] = 'meta_value';
            $query->query_vars['order'] = 'DESC';
        }
    }
});

// Add admin script for quick status change
add_action('admin_footer', function () {
    global $typenow;
    if ($typenow !== 'candidatures') return;
?>
    <style>
        .quick-status-change {
            margin-top: 5px;
        }

        .change-application-status {
            width: 100%;
            max-width: 120px;
            font-size: 12px !important;
            height: 24px !important;
        }

        .status-badge-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .status-updating {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
    <script>
        jQuery(document).ready(function($) {
            $('.change-application-status').on('change', function() {
                var select = $(this);
                var newStatus = select.val();
                if (!newStatus) return;

                var postId = select.data('post-id');
                var nonce = select.data('nonce');
                var statusBadge = select.closest('.status-badge-wrapper').find('.status-badge');

                // Show loading state
                select.closest('td').addClass('status-updating');

                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'change_application_status',
                        post_id: postId,
                        status: newStatus,
                        nonce: nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the status badge color and text
                            statusBadge.css('background-color', response.data.color);
                            statusBadge.text(response.data.label);

                            // Reset the dropdown
                            select.html('<option value="">Changer...</option>');

                            // Add back all options except the current status
                            $.each(response.data.all_statuses, function(value, label) {
                                if (value !== newStatus) {
                                    select.append('<option value="' + value + '">' + label + '</option>');
                                }
                            });

                            // Show success message
                            select.after('<span class="success-message" style="color:#00a32a; font-size:11px; display:block; margin-top:3px;">✓ Mis à jour</span>');
                            setTimeout(function() {
                                $('.success-message').fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }, 2000);
                        } else {
                            alert('Erreur lors de la mise à jour du statut.');
                        }

                        select.closest('td').removeClass('status-updating');
                    },
                    error: function() {
                        alert('Erreur lors de la mise à jour du statut.');
                        select.closest('td').removeClass('status-updating');
                    }
                });
            });
        });
    </script>
<?php
});

// Add AJAX handler for changing application status
add_action('wp_ajax_change_application_status', function () {
    // Check nonce
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

    if (!wp_verify_nonce($nonce, 'change_application_status_' . $post_id) || !current_user_can('edit_post', $post_id)) {
        wp_send_json_error('Unauthorized');
        return;
    }

    $new_status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
    $valid_statuses = [
        'pending' => 'À traiter',
        'reviewing' => 'En cours d\'examen',
        'interview' => 'Entretien planifié',
        'accepted' => 'Accepté',
        'rejected' => 'Refusé'
    ];

    $status_colors = [
        'pending' => '#646970',
        'reviewing' => '#007cba',
        'interview' => '#b26200',
        'accepted' => '#00a32a',
        'rejected' => '#d63638'
    ];

    if (!array_key_exists($new_status, $valid_statuses)) {
        wp_send_json_error('Invalid status');
        return;
    }

    // Update the post meta
    update_field('statut_candidature', $new_status, $post_id);

    // Get some data for notifications
    $job_id = get_field('offre_associee', $post_id);
    $job_title = $job_id ? get_field('intitule_poste', $job_id) : '—';

    $member_id = get_field('membre_associe', $post_id);
    $candidate_email = '';

    if ($member_id) {
        $candidate_email = get_field('email', $member_id);
    } else {
        $post_author = get_post_field('post_author', $post_id);
        $user_data = get_userdata($post_author);
        if ($user_data) {
            $candidate_email = $user_data->user_email;
        }
    }

    // Record a note about the status change
    $user = wp_get_current_user();
    $admin_name = $user->display_name;
    $date = current_time('mysql');

    $notes = get_field('notes_candidature', $post_id);
    if (!is_array($notes)) {
        $notes = [];
    }

    $notes[] = [
        'date' => $date,
        'user' => $admin_name,
        'note' => sprintf(
            'Statut changé en "%s"',
            $valid_statuses[$new_status]
        )
    ];

    update_field('notes_candidature', $notes, $post_id);

    // Send email notification if needed
    if (in_array($new_status, ['interview', 'accepted', 'rejected']) && !empty($candidate_email)) {
        $subject = '';
        $message = '';

        switch ($new_status) {
            case 'interview':
                $subject = 'Entretien pour votre candidature - ' . $job_title;
                $message = "Bonjour,\n\n";
                $message .= "Nous avons examiné votre candidature pour le poste \"$job_title\" et souhaitons vous rencontrer pour un entretien.\n\n";
                $message .= "L'équipe RH vous contactera prochainement pour convenir d'une date.\n\n";
                $message .= "Cordialement,\nL'équipe Alumni ESG";
                break;

            case 'accepted':
                $subject = 'Bonne nouvelle concernant votre candidature - ' . $job_title;
                $message = "Bonjour,\n\n";
                $message .= "Nous sommes heureux de vous informer que votre candidature pour le poste \"$job_title\" a été retenue.\n\n";
                $message .= "Vous serez contacté(e) prochainement pour les prochaines étapes.\n\n";
                $message .= "Cordialement,\nL'équipe Alumni ESG";
                break;

            case 'rejected':
                $subject = 'Réponse à votre candidature - ' . $job_title;
                $message = "Bonjour,\n\n";
                $message .= "Nous avons examiné avec attention votre candidature pour le poste \"$job_title\".\n\n";
                $message .= "Malheureusement, nous avons retenu d'autres profils qui correspondaient plus précisément à nos besoins actuels.\n\n";
                $message .= "Nous vous remercions pour l'intérêt que vous portez à notre entreprise et vous souhaitons bonne chance dans vos recherches.\n\n";
                $message .= "Cordialement,\nL'équipe Alumni ESG";
                break;
        }

        if (!empty($subject) && !empty($message)) {
            wp_mail($candidate_email, $subject, $message);
        }
    }

    // Return updated status info
    wp_send_json_success([
        'status' => $new_status,
        'label' => $valid_statuses[$new_status],
        'color' => $status_colors[$new_status],
        'all_statuses' => $valid_statuses
    ]);
});

// Add application notes metabox
add_action('add_meta_boxes', function () {
    add_meta_box(
        'candidature_notes',
        'Notes et historique',
        'render_candidature_notes_metabox',
        'candidatures',
        'normal',
        'high'
    );
});

// Render application notes metabox
function render_candidature_notes_metabox($post)
{
    $notes = get_field('notes_candidature', $post->ID);
?>
    <div class="candidature-notes-wrapper">
        <div class="candidature-history">
            <?php if (!empty($notes) && is_array($notes)) : ?>
                <table class="widefat striped" style="margin-bottom: 15px;">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Date</th>
                            <th style="width: 20%;">Utilisateur</th>
                            <th>Action / Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($notes) as $note) : ?>
                            <tr>
                                <td><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($note['date'])); ?></td>
                                <td><?php echo esc_html($note['user']); ?></td>
                                <td><?php echo nl2br(esc_html($note['note'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p style="font-style: italic; color: #666;">Aucune note disponible pour cette candidature.</p>
            <?php endif; ?>
        </div>

        <div class="candidature-add-note">
            <h3>Ajouter une note</h3>
            <textarea id="candidature_note" name="candidature_note" rows="3" style="width: 100%; margin-bottom: 10px;"></textarea>
            <button type="button" class="button button-primary" id="add_candidature_note" data-post-id="<?php echo $post->ID; ?>" data-nonce="<?php echo wp_create_nonce('add_candidature_note_' . $post->ID); ?>">
                Ajouter la note
            </button>
            <span class="spinner" style="float: none; margin-top: 0;"></span>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#add_candidature_note').on('click', function() {
                var button = $(this);
                var spinner = button.next('.spinner');
                var note = $('#candidature_note').val().trim();

                if (!note) {
                    alert('Veuillez saisir une note avant de l\'ajouter.');
                    return;
                }

                // Show spinner
                spinner.css('visibility', 'visible');
                button.prop('disabled', true);

                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'add_candidature_note',
                        post_id: button.data('post-id'),
                        note: note,
                        nonce: button.data('nonce')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reload the page to show the new note
                            location.reload();
                        } else {
                            alert('Erreur lors de l\'ajout de la note.');
                            spinner.css('visibility', 'hidden');
                            button.prop('disabled', false);
                        }
                    },
                    error: function() {
                        alert('Erreur lors de l\'ajout de la note.');
                        spinner.css('visibility', 'hidden');
                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>
<?php
}

// Add AJAX handler for adding application notes
add_action('wp_ajax_add_candidature_note', function () {
    // Check nonce and permissions
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

    if (!wp_verify_nonce($nonce, 'add_candidature_note_' . $post_id) || !current_user_can('edit_post', $post_id)) {
        wp_send_json_error('Unauthorized');
        return;
    }

    $note_text = isset($_POST['note']) ? sanitize_textarea_field($_POST['note']) : '';
    if (empty($note_text)) {
        wp_send_json_error('Empty note');
        return;
    }

    // Get current user
    $user = wp_get_current_user();
    $admin_name = $user->display_name;
    $date = current_time('mysql');

    // Get existing notes
    $notes = get_field('notes_candidature', $post_id);
    if (!is_array($notes)) {
        $notes = [];
    }

    // Add new note
    $notes[] = [
        'date' => $date,
        'user' => $admin_name,
        'note' => $note_text
    ];

    // Update field
    update_field('notes_candidature', $notes, $post_id);

    wp_send_json_success();
});

// Function to handle job application submissions
add_action('wp_ajax_submit_job_application', 'handle_job_application_submission');
add_action('wp_ajax_nopriv_submit_job_application', 'handle_job_application_submission');

function handle_job_application_submission() {
    // Check nonce for security
    if (!isset($_POST['job_application_nonce']) || !wp_verify_nonce($_POST['job_application_nonce'], 'submit_job_application')) {
        wp_send_json_error(['message' => 'Vérification de sécurité échouée. Veuillez rafraîchir la page et réessayer.']);
        return;
    }

    // Get the job ID
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;
    if (!$job_id) {
        wp_send_json_error(['message' => 'ID de l\'offre d\'emploi invalide.']);
        return;
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Vous devez être connecté pour postuler.']);
        return;
    }

    $user_id = get_current_user_id();

    // Check if user has already applied
    $existing_application = new WP_Query([
        'post_type' => 'candidatures',
        'posts_per_page' => 1,
        'author' => $user_id,
        'meta_query' => [
            [
                'key' => 'offre_associee',
                'value' => $job_id,
                'compare' => '='
            ]
        ]
    ]);

    if ($existing_application->have_posts()) {
        wp_send_json_error(['message' => 'Vous avez déjà postulé à cette offre.']);
        return;
    }

    // Get member post associated with the user
    $member_id = null;
    $member_query = new WP_Query([
        'post_type' => 'membres',
        'posts_per_page' => 1,
        'meta_query' => [
            [
                'key' => 'compte_associe',
                'value' => $user_id,
                'compare' => '='
            ]
        ]
    ]);

    if ($member_query->have_posts()) {
        $member_query->the_post();
        $member_id = get_the_ID();
        wp_reset_postdata();
    }

    // Get application message
    $application_message = isset($_POST['application_message']) ? sanitize_textarea_field($_POST['application_message']) : '';

    // Handle file uploads
    $cv_id = 0;
    $cover_letter_id = 0;

    // Process CV upload
    if (isset($_FILES['application_cv']) && $_FILES['application_cv']['error'] === 0) {
        $cv_id = handle_application_file_upload('application_cv', ['pdf', 'docx']);
        if (is_wp_error($cv_id)) {
            wp_send_json_error(['message' => 'Erreur lors de l\'upload du CV: ' . $cv_id->get_error_message()]);
            return;
        }
    } else {
        wp_send_json_error(['message' => 'Le CV est requis.']);
        return;
    }

    // Process Cover Letter upload (optional)
    if (isset($_FILES['application_cover_letter']) && $_FILES['application_cover_letter']['error'] === 0) {
        $cover_letter_id = handle_application_file_upload('application_cover_letter', ['pdf', 'docx']);
        if (is_wp_error($cover_letter_id)) {
            wp_send_json_error(['message' => 'Erreur lors de l\'upload de la lettre de motivation: ' . $cover_letter_id->get_error_message()]);
            return;
        }
    }

    // Create application post
    $job_post = get_post($job_id);
    $user_data = get_userdata($user_id);
    $application_title = 'Candidature de ' . $user_data->display_name . ' - ' . get_field('intitule_poste', $job_id);

    $application_data = [
        'post_title'    => $application_title,
        'post_status'   => 'publish',
        'post_type'     => 'candidatures',
        'post_author'   => $user_id,
    ];

    $application_id = wp_insert_post($application_data);
    
    if (is_wp_error($application_id)) {
        wp_send_json_error(['message' => 'Erreur lors de la création de la candidature.']);
        return;
    }

    // Add application meta data
    update_field('offre_associee', $job_id, $application_id);
    if ($member_id) {
        update_field('membre_associe', $member_id, $application_id);
    }
    update_field('message', $application_message, $application_id);
    update_field('date_candidature', date('Y-m-d H:i:s'), $application_id);
    update_field('statut_candidature', 'pending', $application_id);
    
    // Add file attachments
    if ($cv_id) {
        update_field('cv', $cv_id, $application_id);
    }
    if ($cover_letter_id) {
        update_field('lettre_motivation', $cover_letter_id, $application_id);
    }

    // Add initial note
    $notes = [];
    $notes[] = [
        'date' => date('Y-m-d H:i:s'),
        'user' => $user_data->display_name,
        'note' => 'Candidature soumise via le formulaire en ligne'
    ];
    update_field('notes_candidature', $notes, $application_id);

    // Return success response
    wp_send_json_success([
        'message' => 'Votre candidature a été envoyée avec succès!',
        'redirect' => add_query_arg('application', 'success', get_permalink($job_id))
    ]);
}

// Helper function to handle file uploads
function handle_application_file_upload($file_key, $allowed_extensions = ['pdf', 'docx']) {
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    if (!function_exists('wp_generate_attachment_metadata')) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }
    
    // Check if file exists
    if (!isset($_FILES[$file_key]) || $_FILES[$file_key]['error'] !== 0) {
        return new WP_Error('upload_error', 'Aucun fichier téléchargé ou erreur lors du téléchargement.');
    }
    
    $file = $_FILES[$file_key];
    
    // Check file extension
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_extensions)) {
        return new WP_Error('invalid_extension', 'Type de fichier non autorisé. Formats acceptés: ' . implode(', ', $allowed_extensions));
    }
    
    // Check file size (5MB max)
    if ($file['size'] > 5 * 1024 * 1024) {
        return new WP_Error('file_too_large', 'Le fichier est trop volumineux. La taille maximale est de 5 Mo.');
    }
    
    // Handle the upload
    $upload_overrides = array('test_form' => false);
    $uploaded_file = wp_handle_upload($file, $upload_overrides);
    
    if (isset($uploaded_file['error'])) {
        return new WP_Error('upload_error', $uploaded_file['error']);
    }
    
    // Create attachment
    $attachment = array(
        'guid'           => $uploaded_file['url'],
        'post_mime_type' => $uploaded_file['type'],
        'post_title'     => sanitize_file_name(basename($uploaded_file['file'])),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    
    $attachment_id = wp_insert_attachment($attachment, $uploaded_file['file']);
    
    if (is_wp_error($attachment_id)) {
        return $attachment_id;
    }
    
    // Generate metadata for the attachment
    $attachment_data = wp_generate_attachment_metadata($attachment_id, $uploaded_file['file']);
    wp_update_attachment_metadata($attachment_id, $attachment_data);
    
    return $attachment_id;
}





function register_leader_post_type() {
    register_post_type('leader', [
        'labels' => [
            'name' => 'Leaders',
            'singular_name' => 'Leader',
            'add_new' => 'Ajouter un leader',
            'add_new_item' => 'Ajouter un nouveau leader',
            'edit_item' => 'Modifier le leader',
            'new_item' => 'Nouveau leader',
            'view_item' => 'Voir le leader',
            'search_items' => 'Rechercher un leader',
            'not_found' => 'Aucun leader trouvé',
            'not_found_in_trash' => 'Aucun leader dans la corbeille',
        ],
        'public' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'editor', 'thumbnail'],
    ]);
}
add_action('init', 'register_leader_post_type');

function enqueue_landing_page_styles() {
    if (is_page_template('landing-page-template.php')) {
        wp_enqueue_style('landing-page', get_template_directory_uri() . '/css/landing-page.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_landing_page_styles');

// Add filter fields for members page
add_action('restrict_manage_posts', function () {
    global $typenow;
    if ($typenow === 'membres') {

        // Active status filter
        echo '<select name="member_status" id="filter-by-status">';
        echo '<option value="">Tous les statuts</option>';
        $statuses = [
            'active' => 'Actif',
            'inactive' => 'Inactif'
        ];
        foreach ($statuses as $value => $label) {
            $selected = isset($_GET['member_status']) && $_GET['member_status'] === $value ? 'selected' : '';
            echo '<option value="' . esc_attr($value) . '" ' . $selected . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }
});

// Apply the filters
add_filter('parse_query', function ($query) {
    global $pagenow, $typenow;

    if ($pagenow === 'edit.php' && $typenow === 'membres') {
        $tax_query = [];

        // Filter by active status
        if (isset($_GET['member_status']) && !empty($_GET['member_status'])) {
            $query->query_vars['meta_query'][] = [
                'key' => 'active',
                'value' => $_GET['member_status'] === 'active' ? '1' : '0',
                'compare' => '='
            ];
        }

        // Add tax query if filters are set
        if (!empty($tax_query)) {
            $query->query_vars['tax_query'] = $tax_query;
        }
    }
});