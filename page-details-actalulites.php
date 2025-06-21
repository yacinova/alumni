<?php
/**
 * Template Name: Détails Actualités
 * Description: Template pour afficher les détails d'une actualité
 */

// Chargement conditionnel du header selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('header', 'etudiant');
} else {
    get_header();
}

// Récupérer l'ID de l'article depuis l'URL
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Vérifier si l'article existe
if ($post_id > 0) {
    $post = get_post($post_id);
    if (!$post) {
        wp_redirect(home_url('/actualites'));
        exit;
    }
} else {
    wp_redirect(home_url('/actualites'));
    exit;
}


?>

<style>
    .actualite-details {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .actualite-header {
        margin-bottom: 40px;
    }

    .actualite-title {
        font-size: 36px;
        color: #0b65a0;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .actualite-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        color: #666;
        margin-bottom: 30px;
    }

    .actualite-date, .actualite-author {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .actualite-date i, .actualite-author i {
        color: #009640;
    }

    .actualite-featured-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 40px;
    }

    .actualite-content {
        font-size: 18px;
        line-height: 1.8;
        color: #333;
    }

    .actualite-content p {
        margin-bottom: 24px;
    }

    .actualite-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 30px 0;
    }

    .actualite-content h2, 
    .actualite-content h3 {
        color: #0b65a0;
        margin: 40px 0 20px;
    }

    .actualite-content h2 {
        font-size: 28px;
    }

    .actualite-content h3 {
        font-size: 24px;
    }

    .actualite-content blockquote {
        border-left: 4px solid #009640;
        padding: 20px;
        background: #f8f9fa;
        margin: 30px 0;
        font-style: italic;
    }

    .actualite-content ul, 
    .actualite-content ol {
        margin: 20px 0;
        padding-left: 20px;
    }

    .actualite-content li {
        margin-bottom: 10px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #009640;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 30px;
        transition: color 0.3s ease;
    }

    .back-button:hover {
        color: #0b65a0;
    }

    .back-button i {
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .actualite-title {
            font-size: 28px;
        }

        .actualite-featured-image {
            height: 300px;
        }

        .actualite-content {
            font-size: 16px;
        }

        .actualite-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>

<main id="content" class="actualite-details">
    <div class="container">
        <a href="<?php echo home_url('/actualites'); ?>" class="back-button">
            <i class="fas fa-arrow-left"></i> Retour aux actualités
        </a>

        <article>
            <header class="actualite-header">
                <h1 class="actualite-title"><?php echo esc_html($post->post_title); ?></h1>
                <div class="actualite-meta">
                    <span class="actualite-date">
                        <i class="far fa-calendar-alt"></i>
                        <?php echo get_the_date('', $post_id); ?>
                    </span>
                    <span class="actualite-author">
                        <i class="far fa-user"></i>
                        <?php echo get_the_author_meta('display_name', $post->post_author); ?>
                    </span>
                </div>
            </header>

            <?php if (has_post_thumbnail($post_id)) : ?>
                <div class="actualite-featured-image-container">
                    <?php echo get_the_post_thumbnail($post_id, 'full', ['class' => 'actualite-featured-image']); ?>
                </div>
            <?php endif; ?>

            <div class="actualite-content">
                <?php echo apply_filters('the_content', $post->post_content); ?>
            </div>
        </article>
    </div>
</main>

<?php 
// Chargement conditionnel du footer selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('footer', 'etudiant');
} else {
    get_footer();
}
?>
