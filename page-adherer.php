<?php
/**
 * Template Name: Landing Page INSA Alumni
 * Description: Template personnalisé pour la page d'accueil INSA Alumni
 */

// Chargement conditionnel du header selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('header', 'etudiant');
} else {
    get_header();
}

// Récupérer les messages de succès/erreur et les données du formulaire soumises (si présents)
$form_success = get_transient('adhesion_form_success');
$form_errors = get_transient('adhesion_form_errors');
$form_data = get_transient('adhesion_form_data');

// Supprimer les transients après les avoir récupérés pour qu'ils n'apparaissent qu'une fois
delete_transient('adhesion_form_success');
delete_transient('adhesion_form_errors');
delete_transient('adhesion_form_data');

// Initialiser $form_data si aucun transient n'est trouvé (pour éviter les erreurs d'undef)
if (!is_array($form_data)) {
    $form_data = [];
}

?>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --alumni-navy: #0b1c39;
    --alumni-gold: #d4af37;
    --alumni-gold-light: #e9d282;
    --alumni-white: #ffffff;
    --alumni-gray: #f8f9fa;
    --alumni-text: #333333;
    --alumni-border: #eaeaea;
    --alumni-shadow: rgba(0, 0, 0, 0.05);
}

body {
    font-family: 'Montserrat', sans-serif;
    background-color: var(--alumni-gray);
    color: var(--alumni-text);
}

.page-header {
    background: linear-gradient(135deg, var(--alumni-navy) 0%, #1a365d 100%);
    color: white;
    padding: 4rem 0 3rem;
    margin-bottom: 0;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 300;
}

.adhesion-section {
    padding: 3rem 0;
    background-color: var(--alumni-gray);
}

.adhesion-form-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.section-title {
    color: var(--alumni-navy);
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: var(--alumni-gold);
    font-size: 1.5rem;
}

.adhesion-form .form-label {
    color: var(--alumni-navy);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.adhesion-form .form-control,
.adhesion-form .form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.adhesion-form .form-control:focus,
.adhesion-form .form-select:focus {
    border-color: var(--alumni-gold);
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.btn-alumni {
    background: linear-gradient(135deg, var(--alumni-navy) 0%, #1a365d 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-alumni:hover {
    background: linear-gradient(135deg, #1a365d 0%, var(--alumni-navy) 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    color: white;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    border-radius: 8px;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .adhesion-form-card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
}
</style>

<main id="content">
    <!-- Adhesion Section -->
    <section class="adhesion-section">
        <div class="container">
            <div style="display: flex; align-items: center; margin-bottom: 30px;">
                <h2 style="font-size: 2.2rem; font-weight: bold; color: #7a7a7a; margin: 0;">Adhésion</h2>
                <hr style="flex: 1; margin-left: 20px; border: none; border-top: 2px solid #2196f3;">
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="adhesion-form-card">
                        <h3 class="section-title">
                            <i class="bi bi-person-plus-fill"></i>
                            Formulaire d'adhésion
                        </h3>

                        <?php if ($form_success): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>
                                    <strong>Demande d'adhésion envoyée avec succès !</strong><br>
                                    Nous vous contacterons dans les plus brefs délais.
                                </div>
                            </div>
                        <?php elseif (!empty($form_errors)): ?>
                            <div class="alert alert-danger d-flex align-items-start" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                <div>
                                    <strong>Erreurs détectées :</strong>
                                    <ul class="mb-0 mt-1">
                                        <?php foreach ($form_errors as $error): ?>
                                            <li><?php echo esc_html($error); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" class="adhesion-form">
                            <input type="hidden" name="action" value="submit_adhesion"> <!-- Important pour le hook admin_post -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">
                                        <i class="bi bi-person me-1"></i>Nom *
                                    </label>
                                    <input type="text" class="form-control" name="nom" id="nom" required 
                                        value="<?php echo isset($form_data['nom']) ? esc_attr($form_data['nom']) : ''; ?>"
                                        placeholder="Votre nom">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="prenom" class="form-label">
                                        <i class="bi bi-person me-1"></i>Prénom *
                                    </label>
                                    <input type="text" class="form-control" name="prenom" id="prenom" required
                                        value="<?php echo isset($form_data['prenom']) ? esc_attr($form_data['prenom']) : ''; ?>"
                                        placeholder="Votre prénom">
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i>Email *
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email" required
                                        value="<?php echo isset($form_data['email']) ? esc_attr($form_data['email']) : ''; ?>"
                                        placeholder="votre.email@exemple.com">
                                </div>

                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">
                                        <i class="bi bi-telephone me-1"></i>Téléphone *
                                    </label>
                                    <input type="tel" class="form-control" name="telephone" id="telephone" required
                                        value="<?php echo isset($form_data['telephone']) ? esc_attr($form_data['telephone']) : ''; ?>"
                                        placeholder="Votre numéro de téléphone">
                                </div>

                                <div class="col-12">
                                    <label for="adresse" class="form-label">
                                        <i class="bi bi-geo-alt me-1"></i>Adresse *
                                    </label>
                                    <textarea class="form-control" name="adresse" id="adresse" rows="3" required
                                        placeholder="Votre adresse complète"><?php echo isset($form_data['adresse']) ? esc_textarea($form_data['adresse']) : ''; ?></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="profession" class="form-label">
                                        <i class="bi bi-briefcase me-1"></i>Profession
                                    </label>
                                    <input type="text" class="form-control" name="profession" id="profession"
                                        value="<?php echo isset($form_data['profession']) ? esc_attr($form_data['profession']) : ''; ?>"
                                        placeholder="Votre profession">
                                </div>

                                <div class="col-md-6">
                                    <label for="entreprise" class="form-label">
                                        <i class="bi bi-building me-1"></i>Entreprise
                                    </label>
                                    <input type="text" class="form-control" name="entreprise" id="entreprise"
                                        value="<?php echo isset($form_data['entreprise']) ? esc_attr($form_data['entreprise']) : ''; ?>"
                                        placeholder="Nom de votre entreprise">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="bi bi-person-badge me-1"></i>Catégorie du membre *
                                    </label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categorie" value="etudiant" id="categorie_etudiant" required
                                                <?php checked( 'etudiant', isset($form_data['categorie']) ? $form_data['categorie'] : '' ); ?>>
                                            <label class="form-check-label" for="categorie_etudiant">
                                                Étudiant
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categorie" value="laureat" id="categorie_laureat" required
                                                <?php checked( 'laureat', isset($form_data['categorie']) ? $form_data['categorie'] : '' ); ?>>
                                            <label class="form-check-label" for="categorie_laureat">
                                                Lauréat
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" name="submit_adhesion" class="btn btn-alumni w-100">
                                        <i class="bi bi-send me-2"></i>
                                        Soumettre la demande d'adhésion
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                Vos données sont protégées et ne seront jamais partagées.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
// Chargement conditionnel du footer selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('footer', 'etudiant');
} else {
    get_footer();
}
?>