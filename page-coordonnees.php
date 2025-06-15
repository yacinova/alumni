<?php
/**
 * Template Name: Landing Page Alumni ESG
 * Description: Template personnalisé pour la page d'accueil Alumni ESG Maroc
 */

// Chargement conditionnel du header selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('header', 'etudiant');
} else {
    get_header();
}

// Process contact form submission
$form_submitted = false;
$form_success = false;
$form_errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $form_submitted = true;
    
    // Validate required fields
    $required_fields = [
        'contact_name' => 'Le nom est requis',
        'contact_email' => 'L\'email est requis',
        'contact_subject' => 'Le sujet est requis',
        'contact_message' => 'Le message est requis'
    ];

    foreach ($required_fields as $field => $message) {
        if (empty($_POST[$field])) {
            $form_errors[] = $message;
        }
    }

    // Validate email
    if (!empty($_POST['contact_email']) && !is_email($_POST['contact_email'])) {
        $form_errors[] = 'L\'adresse email n\'est pas valide';
    }

    // If no errors, process the form
    if (empty($form_errors)) {
        // Here you would normally send an email or save to database
        // For now, we'll just set success to true
        $form_success = true;
        
        // You can add email sending logic here
        // wp_mail(...);
    }
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

.contact-section {
    padding: 3rem 0;
    background-color: var(--alumni-gray);
}

.contact-info-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: none;
}

.contact-form-card {
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

.info-item {
    margin-bottom: 1.5rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.info-label {
    font-weight: 600;
    color: var(--alumni-navy);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-label i {
    color: var(--alumni-gold);
    width: 20px;
}

.info-value {
    color: var(--alumni-text);
    line-height: 1.6;
    margin-left: 1.75rem;
}

.contact-form .form-label {
    color: var(--alumni-navy);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.contact-form .form-control,
.contact-form .form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.contact-form .form-control:focus,
.contact-form .form-select:focus {
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

.map-container {
    margin-top: 1.5rem;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.quick-contact {
    background: linear-gradient(135deg, var(--alumni-gold) 0%, var(--alumni-gold-light) 100%);
    color: var(--alumni-navy);
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 1.5rem;
    text-align: center;
}

.quick-contact h6 {
    font-weight: 600;
    margin-bottom: 1rem;
}

.quick-contact-buttons {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-quick {
    background: var(--alumni-navy);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-quick:hover {
    background: #1a365d;
    color: white;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .contact-info-card,
    .contact-form-card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .info-value {
        margin-left: 0;
        margin-top: 0.5rem;
    }
    
    .quick-contact-buttons {
        flex-direction: column;
    }
    
    .btn-quick {
        justify-content: center;
    }
}
</style>

<main id="content">
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div style="display: flex; align-items: center; margin-bottom: 30px;">
                <h2 style="font-size: 2.2rem; font-weight: bold; color: #7a7a7a; margin: 0;">Coordonnées</h2>
                <hr style="flex: 1; margin-left: 20px; border: none; border-top: 2px solid #2196f3;">
            </div>
            
            <div class="row g-4">
                <!-- Contact Information -->
                <div class="col-lg-6">
                    <div class="contact-info-card">
                        <h3 class="section-title">
                            <i class="bi bi-info-circle-fill"></i>
                            Nos coordonnées
                        </h3>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-building"></i>
                                Siège social
                            </div>
                            <div class="info-value">
                                12, rue Sabri Boujemaa<br>
                                Casablanca, Maroc
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-telephone-fill"></i>
                                Téléphone
                            </div>
                            <div class="info-value">
                                <a href="tel:+212522000000" class="text-decoration-none">
                                    +212 5 22 00 00 00
                                </a>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-envelope-fill"></i>
                                Email
                            </div>
                            <div class="info-value">
                                <a href="mailto:contact@alumni-esg.ma" class="text-decoration-none">
                                    contact@alumni-esg.ma
                                </a>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-clock-fill"></i>
                                Horaires d'ouverture
                            </div>
                            <div class="info-value">
                                Lundi - Vendredi : 9h00 - 18h00<br>
                                Samedi : 9h00 - 13h00<br>
                                Dimanche : Fermé
                            </div>
                        </div>

                        <!-- Quick Contact Actions -->
                        <div class="quick-contact">
                            <h6>Contact rapide</h6>
                            <div class="quick-contact-buttons">
                                <a href="tel:+212522000000" class="btn-quick">
                                    <i class="bi bi-telephone"></i>
                                    Appeler
                                </a>
                                <a href="mailto:contact@alumni-esg.ma" class="btn-quick">
                                    <i class="bi bi-envelope"></i>
                                    Email
                                </a>
                                <a href="https://wa.me/212522000000" class="btn-quick" target="_blank">
                                    <i class="bi bi-whatsapp"></i>
                                    WhatsApp
                                </a>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="map-container">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3323.4!2d-7.6204!3d33.5731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzPCsDM0JzIzLjIiTiA3wrAzNycxMy40Ilc!5e0!3m2!1sfr!2sma!4v1699000000000!5m2!1sfr!2sma" 
                                width="100%" 
                                height="250" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-6">
                    <div class="contact-form-card">
                        <h3 class="section-title">
                            <i class="bi bi-chat-dots-fill"></i>
                            Formulaire de contact
                        </h3>

                        <?php if ($form_submitted && $form_success): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>
                                    <strong>Message envoyé avec succès !</strong><br>
                                    Nous vous répondrons dans les plus brefs délais.
                                </div>
                            </div>
                        <?php elseif ($form_submitted && !empty($form_errors)): ?>
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

                        <form method="post" action="" class="contact-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contact_name" class="form-label">
                                        <i class="bi bi-person me-1"></i>Nom complet *
                                    </label>
                                    <input type="text" class="form-control" name="contact_name" id="contact_name" required 
                                        value="<?php echo isset($_POST['contact_name']) ? esc_attr($_POST['contact_name']) : ''; ?>"
                                        placeholder="Votre nom complet">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i>Email *
                                    </label>
                                    <input type="email" class="form-control" name="contact_email" id="contact_email" required
                                        value="<?php echo isset($_POST['contact_email']) ? esc_attr($_POST['contact_email']) : ''; ?>"
                                        placeholder="votre.email@exemple.com">
                                </div>

                                <div class="col-12">
                                    <label for="contact_subject" class="form-label">
                                        <i class="bi bi-tag me-1"></i>Sujet *
                                    </label>
                                    <select class="form-select" name="contact_subject" id="contact_subject" required>
                                        <option value="">Choisissez un sujet</option>
                                        <option value="Information générale" <?php echo (isset($_POST['contact_subject']) && $_POST['contact_subject'] == 'Information générale') ? 'selected' : ''; ?>>Information générale</option>
                                        <option value="Adhésion alumni" <?php echo (isset($_POST['contact_subject']) && $_POST['contact_subject'] == 'Adhésion alumni') ? 'selected' : ''; ?>>Adhésion alumni</option>
                                        <option value="Événements" <?php echo (isset($_POST['contact_subject']) && $_POST['contact_subject'] == 'Événements') ? 'selected' : ''; ?>>Événements</option>
                                        <option value="Opportunités emploi" <?php echo (isset($_POST['contact_subject']) && $_POST['contact_subject'] == 'Opportunités emploi') ? 'selected' : ''; ?>>Opportunités d'emploi</option>
                                        <option value="Partenariats" <?php echo (isset($_POST['contact_subject']) && $_POST['contact_subject'] == 'Partenariats') ? 'selected' : ''; ?>>Partenariats</option>
                                        <option value="Support technique" <?php echo (isset($_POST['contact_subject']) && $_POST['contact_subject'] == 'Support technique') ? 'selected' : ''; ?>>Support technique</option>
                                        <option value="Autre" <?php echo (isset($_POST['contact_subject']) && $_POST['contact_subject'] == 'Autre') ? 'selected' : ''; ?>>Autre</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="contact_message" class="form-label">
                                        <i class="bi bi-chat-text me-1"></i>Message *
                                    </label>
                                    <textarea class="form-control" name="contact_message" id="contact_message" rows="5" required
                                        placeholder="Décrivez votre demande en détail..."><?php echo isset($_POST['contact_message']) ? esc_textarea($_POST['contact_message']) : ''; ?></textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit" name="submit_contact" class="btn btn-alumni w-100">
                                        <i class="bi bi-send me-2"></i>
                                        Envoyer le message
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